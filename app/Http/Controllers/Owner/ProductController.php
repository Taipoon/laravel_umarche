<?php

namespace App\Http\Controllers\Owner;

use App\Constants\Common;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Owner;
use App\Models\PrimaryCategory;
use App\Models\Product;
use App\Models\Shop;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth:owners');

    $this->middleware(function ($request, $next) {
      $id = $request->route()->parameter('product'); // /edit/{image} の image(id)を取得
      if (!is_null($id)) { // 非null判定
        $productsOwnerId = Product::findOrFail($id)->shop->owner->id;
        $productId = (int)$productsOwnerId;
        if ($productId != Auth::id()) {
          abort(404);
        }
      }
      return $next($request);
    });
  }

  public function index()
  {
    // Eager Loadなし ==> N + 1問題の発生 (大元のリレーションOwnerと紐づく各リレーションに対して、データの数だけSQLが発行されて負荷が多くなる)
    // $products = Owner::findOrFail(Auth::id())->shop->product;

    $ownerInfo = Owner::with('shop.product.imageFirst')->where('id', Auth::id())->get();

    // dd($ownerInfo);

    // foreach ($ownerInfo as $owner) {
    //     foreach ($owner->shop->product as $product) {
    //         dd($product->imageFirst->filename);
    //     }
    // }
    return view('owner.products.index', compact('ownerInfo'));
  }

  public function create()
  {
    $shops = Shop::where('owner_id', Auth::id())->select('id', 'name')->get();

    $images = Image::where('owner_id', Auth::id())->select('id', 'title', 'filename')
      ->orderBy('updated_at', 'desc')->get();

    $categories = PrimaryCategory::with('secondary')->get();

    return view('owner.products.create', compact('shops', 'images', 'categories'));
  }

  public function store(ProductRequest $request)
  {
    $request->validate([
      'name' => 'required|string|max:50',
      'information' => 'required|string|max:1000',
      'price' => 'required|integer',
      'sort_order' => 'nullable|integer',
      'quantity' => 'required|integer',
      'shop_id' => 'required|exists:shops,id',
      'category' => 'required|exists:secondary_categories,id',
      'image1' => 'nullable|exists:images,id',
      'image2' => 'nullable|exists:images,id',
      'image3' => 'nullable|exists:images,id',
      'image4' => 'nullable|exists:images,id',
      'is_selling' => 'required',
    ]);

    // Shop にも同時に店舗情報を登録する
    try {
      DB::transaction(function () use ($request) {
        $product = Product::create([
          'name' => $request->name,
          'information' => $request->information,
          'price' => $request->price,
          'sort_order' => $request->sort_order,
          'shop_id' => $request->shop_id,
          'secondary_category_id' => $request->category,
          'image1' => $request->image1,
          'image2' => $request->image2,
          'image3' => $request->image3,
          'image4' => $request->image4,
          'is_selling' => $request->is_selling,
        ]);

        Stock::create([
          'product_id' => $product->id,
          'type' => 1,
          'quantity' => $request->quantity,
        ]);

        // Image::create([
        //     'owner_id' => Auth::id(),
        // ]);
      });
    } catch (Throwable $e) {
      Log::error($e);
      throw $e;
    }


    return redirect()->route('owner.products.index')
      ->with([
        'message' => '商品登録しました。',
        'status' => 'info'
      ]);
  }

  public function edit($id)
  {
    $product = Product::findOrFail($id);
    $quantity = Stock::where('product_id', $product->id)->sum('quantity');

    $shops = Shop::where('owner_id', Auth::id())->select('id', 'name')->get();

    $images = Image::where('owner_id', Auth::id())->select('id', 'title', 'filename')
      ->orderBy('updated_at', 'desc')->get();

    $categories = PrimaryCategory::with('secondary')->get();

    return view(
      'owner.products.edit',
      compact('product', 'quantity', 'shops', 'images', 'categories')
    );
  }

  public function update(ProductRequest $request, $id)
  {
    // ProductRequest の rules の後にvalidationを追加
    $request->validate([
      'current_quantity' => 'required|integer',
    ]);

    $product = Product::findOrFail($id);
    $quantity = Stock::where('product_id', $product->id)->sum('quantity');
    if ($request->current_quantity !== $quantity) {
      $id = $request->route()->parameter('product');
      return redirect()->route('owner.products.edit', ['product' => $id])
        ->with([
          'message' => '在庫数が変更されています。再度確認してください。',
          'status' => 'alert',
        ]);
    } else {
      // Shop にも同時に店舗情報を登録する
      try {
        DB::transaction(function () use ($request, $product) {
          $product->name = $request->name;
          $product->information = $request->information;
          $product->price = $request->price;
          $product->sort_order = $request->sort_order;
          $product->shop_id = $request->shop_id;
          $product->secondary_category_id = $request->category;
          $product->image1 = $request->image1;
          $product->image2 = $request->image2;
          $product->image3 = $request->image3;
          $product->image4 = $request->image4;
          $product->is_selling = $request->is_selling;
          $product->save();

          if ($request->type === Common::PRODUCT_LIST['add']) {
            $newQuantity = $request->quantity;
          }
          if ($request->type === Common::PRODUCT_LIST['reduce']) {
            $newQuantity = $request->quantity * -1;
          }
          Stock::create([
            'product_id' => $product->id,
            'type' => $request->type,
            'quantity' => $newQuantity,
          ]);
        });
      } catch (Throwable $e) {
        Log::error($e);
        throw $e;
      }
      return redirect()->route('owner.products.index')
        ->with([
          'message' => '商品情報を更新しました。',
          'status' => 'info',
        ]);
    }
  }

  public function destroy($id)
  {

    Product::findOrFail($id)->delete();

    return redirect()->route('owner.products.index')
      ->with([
        'message' => '商品を削除しました。',
        'status' => 'alert'
      ]);
  }
}
