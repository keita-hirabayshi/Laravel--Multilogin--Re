<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(){
        $user = User::findOrFail(Auth::id());
        $products = $user->products;
        $totalPrice =0;

        foreach($products as $product){
            $totalPrice += $product->price * $product->pivot->quantity;
        }

        // dd($products,$totalPrice);

        return view('user.cart',
        compact('products','totalPrice'));
    }

    public function add(Request $request){
    // cartに商品があるかをチェック。
    // リクエストがあった、ユーザー・プロダクト情報にてすでに商品をカートに入れていれば、ここで取得される」
       $itemInCart = Cart::where('product_id',$request->product_id)
       ->where('user_id',Auth::id())->first();

    // ユーザーが既に入れている場合には、追加のみされる
       if($itemInCart){
        $itemInCart->quantity += $request->quantity;
        $itemInCart->SAVE();
       }else{
    // なければ自動生成される
           Cart::create([
               'user_id' => Auth::id(),
               'product_id' => $request->product_id,
               'quantity' => $request->quantity
           ]);
       }
       
       return redirect()->route('user.cart.index');
    }

    public function delete($id){
        Cart::where('product_id',$id)
        ->where('user_id',Auth::id())->delete();

        return redirect()->route('user.cart.index');
    }

    public function checkout(){
        $user = User::findOrFail(Auth::id());
        $products = $user->products;

        
        $lineItems = [];

        foreach ($products as $product) {
            $quantity = '';
            $quantity = Stock::where('product_id', $product->id)->sum('quantity');

            if($product->pivot->quantit > $quantity){
            // 在庫よりカート内の数の方が多い場合には、、リダイレクトする
                return redirect()->route('user.cart.index');
            }else{
                $lineItem = [
                    'name' => $product->name,
                    'description' => $product->information,
                    'amount' => $product->price,
                    'currency' => 'jpy',
                    'quantity' => $product->pivot->quantity
                ];
                array_push($lineItems,$lineItem);
            }
        }

        foreach ($products as $product) {
            Stock::create([
                'product_id' => $product->id,
                'type'     => \Constant::PRODUCT_LIST['reduce'],
                'quantity' => $product->pivot->quantity * -1
            ]);
        }

        dd('test');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $session = \Stripe\Checkout\Session::create([
            'payment_method' => ['cart'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('user.items.index'),
            'cancel_url' =>route('user.cart.index'),
        ]);

        $publicKey = env('STRIPE_PUBLIC_KEY');

        return view('user.checkout',
        compact('session','publicKey'));
    }
}
