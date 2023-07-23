<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\PrimaryCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Jobs\SendThanksMail;

class ItemController extends Controller
{
    public function __construct()    {
        $this->middleware('auth:users');

        $this->middleware(function ($request, $next) {

            $id = $request->route()->parameter('item'); 
            if(!is_null($id)){ 
            // データベース上で存在しているプロダクトか、確認の後に取得する
                $itemId = Product::availableItems()->where('products.id',$id)->exists();
              
                if(!$itemId){ 
                    abort(404); 
                }
            }
            return $next($request);
        });

    }
    public function index(Request $request){
        // dd($request);

        // 同期的に送信
        //ログイン時にメールを送信するよう実行
        // Mail::to('test@example.com')
        // ->send(new TestMail());

        //非同期に送信
        SendThanksMail::dispatch();
        
        $categories = PrimaryCategory::with('secondary')
        ->get();
    // 在庫が最低1つはあるものを取得している
        $products = Product::availableItems()
        ->selectCategory($request->category ?? '0')
        ->searchKeyword($request->keyword)
        ->sortOrder($request->sort)
        ->paginate($request->pagination ?? '20');
  
        return view('user.index',compact('products','categories'));
    }

    public function show($id){
        $product = Product::findOrFail($id);
        $quantity = Stock::where('product_id', $product->id)
        ->sum('quantity');

        if($quantity > 9){
            $quantity = 9;
        }

        return view('user.show', compact('product','quantity'));
    }
}
