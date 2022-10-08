<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImageRequest;
use App\Models\Shop;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use InterventionImage;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
            $id = $request->route()->parameter('shop'); // /edit/{shop} の shop(id)を取得
            if (!is_null($id)) { // 非null判定
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; // 文字列 --キャスト--> 整数
                $ownerId = Auth::id(); // 整数型
                if ($shopId != $ownerId) { // 認証済みユーザーが持つShopの情報でなければ
                    abort(404); // Not Found(404)画面を表示
                }
            }
            // dd($request->route()->parameter('shop')); // 文字列
            // dd(Auth::id()); // 整数

            return $next($request);
        });
    }

    public function index()
    {
        $shops = Shop::where('owner_id', Auth::id())->get();
        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)
    {

        $request->validate([
            'name' => 'required|string|max:50',
            'information' => 'required|string|max:1000',
            'is_selling' => 'required',
        ]);

        $imageFile = $request->image;
        if (!is_null($imageFile) && $imageFile->isValid()) {
            // Storage::putFile('public/shops', $imageFile); // リサイズなしの場合

            // // ファイル名に一意なファイル名を付与
            // $fileName = uniqid(rand() . '_');
            // $extension = $imageFile->extension();

            // // 拡張子と合わせて一意なファイル名を作成
            // $fileNameToStore = $fileName . '.' . $extension;
            // // 画像リサイズ処理
            // $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();

            // // dd($imageFile, $resizedImage);

            // // 画像を保存
            // Storage::put('public/shops/' . $fileNameToStore, $resizedImage);
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;
        // 画像があれば、画像のファイル名を保存
        if (!is_null($imageFile) && $imageFile->isValid()) {
            $shop->filename = $fileNameToStore;
        }
        $shop->save();

        return redirect()->route('owner.shops.index')->with([
            'message' => '店舗情報を更新しました。',
            'status' => 'info',
        ]);
    }
}
