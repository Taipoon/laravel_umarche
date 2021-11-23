<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        // Auth::id(); // 冗長な記述
        $shops = Shop::where('owner_id', Auth::id())->get();
        return view('owner.shops.index', compact('shops'));
    }

    public function edit($id)
    {
        $shop = Shop::findOrFail($id);
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(Request $request, $id)
    {
        $imageFile = $request->image;
        if (!is_null($imageFile) && $imageFile->isValid()) {
            Storage::putFile('public/shops', $imageFile);
        }

        return redirect()->route('owner.shops.index');
    }
}
