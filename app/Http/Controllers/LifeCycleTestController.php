<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{
    public function showServiceProviderTest(){
    // encryptionサービスプロバイダーを変数内へ代入する
        $encrypt = app()->make('encrypter');
    // 中のメソッドにてパスワードを暗号化させる
        $password = $encrypt->encrypt('password');
    // 暗号化したパスワードはdecryptメソッドにて、元に戻される

        $sample = app()->make('serviceProviderTest');

        dd($sample,$password,$encrypt->decrypt($password));
    }
    public function showServiceContainerTest(){
    // ライフサイクルテストの設定方法(bindメソッドを用いる)
        app()->bind('lifeCycleTest',function(){
            return 'ライフサイクルテスト';
        });
    // サービスコンテナの出力
        $test = app()->make('lifeCycleTest');

        // サービスコンテナなし
        // $message = new Message();
        // $sample = new Sample($message);
        // $sample->run();

        // サービスコンテナapp()あり
        app()->bind('sample', Sample::class);
        $sample = app()->make('sample');
        $sample->run();

        //  dd(app())にて中身を確認できる
        dd($test,app());
    }
}

class Sample
{
    public $message;
    public function __construct(Message $message){
        $this->message = $message;
    }
    public function run(){
        $this->message->send();
    }
}
class Message
{
    public function send(){
        echo ('メッセージ表示');
    }
}
