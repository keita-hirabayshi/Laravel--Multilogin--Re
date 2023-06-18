<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 
use App\Http\Requests\UploadImageRequest;
use App\Services\ImageService;
use InterventionImage;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:owners');

        $this->middleware(function ($request, $next) {
        // 別のオーナーのショップ情報を閲覧できないようにしておく

            $id = $request->route()->parameter('shop'); //shopのid取得
            if(!is_null($id)){ // null判定
                $shopsOwnerId = Shop::findOrFail($id)->owner->id;
                $shopId = (int)$shopsOwnerId; // キャスト 文字列→数値に型変換
                $ownerId = Auth::id();

                if($shopId !== $ownerId){ // 同じでなかったら
                    abort(404); // 404画面表示
                }
            }
            return $next($request);
        });

    }

    public function index()
    {
        // $ownerId = Auth::id();
        $shops = Shop::where('owner_id',Auth::id())->get();

        return view ('owner.shops.index',compact('shops'));
    }

    public function edit(string $id)
    {
        $shop = Shop::findOrFail($id);
        // dd($owner);
        return view('owner.shops.edit', compact('shop'));
    }

    public function update(UploadImageRequest $request, $id)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'information' => ['required', 'string', 'max:1000'],
            'is_selling' => ['required']
        ]);

        $imageFile = $request->image; //一時保存
        // // nullでないか？ アップデートされたものであるか？
        if(!is_null($imageFile) && $imageFile->isValid() ){
            $fileNameToStore = ImageService::upload($imageFile, 'shops');
    //     // shopのファイルの中にデータを保存する
    //     // Storage::putFile('public/shops', $imageFile);  //リサイズなしの場合

    //     // ランダムなファイル名を作成する
    //         $fileName = uniqid(rand().'_');
    //     // extentionにて拡張子を取得
    //         $extension = $imageFile->extension();
    //     // ファイル名を取得
    //         $fileNameToStore = $fileName. '.' . $extension;
    //     // 画像を調整して変数に格納する
    //         $resizedImage = InterventionImage::make($imageFile)->resize(1920, 1080)->encode();
    //         // dd($imageFile,$resizedImage);
    //         Storage::put('public/shops/' . $fileNameToStore, $resizedImage );
        }

        $shop = Shop::findOrFail($id);
        $shop->name = $request->name;
        $shop->information = $request->information;
        $shop->is_selling = $request->is_selling;

        if(!is_null($imageFile) && $imageFile->isValid()){
            $shop->filename = $fileNameToStore;
        }

        $shop->save();

        return redirect()->route('owner.shops.index')->with(['message' => '店舗情報を更新しました。',
        'status' => 'info']);
    }
    


}
