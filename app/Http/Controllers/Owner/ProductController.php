<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
