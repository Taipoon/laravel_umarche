<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LifeCycleTestController extends Controller
{

    public function showServiceProviderTest()
    {
        $keyword = 'password';
        $encrypter = app()->make('encrypter');
        $encrypted_word = $encrypter->encrypt($keyword);

        $sample = app()->make('serviceProviderTest');

        dd($encrypted_word, $encrypter->decrypt($encrypted_word), $sample);
    }
    public function showServiceContainerTest()
    {
        // サービスコンテナにクロージャーを登録
        app()->bind('lifeCycleTest', function(){
            return 'ライフサイクルテスト';
        });

        // サービスコンテナを呼び出し
        $test = app()->make('lifeCycleTest');

        /**
         * サービスコンテナを使わない場合、クラス内で別のクラスを
         * 使用する場合、それぞれのクラスをインスタンス化した後に、
         * 依存関係に応じてクラスを使う必要がある(日本語下手)が、
         * サービスコンテナを用いた場合は、依存関係に応じて
         * 自動でクラスをインスタンス化するので、楽。
         */

        // サービスコンテナを使わない場合
        $message = new Message();
        $sample = new Sample($message);
        $sample->run();

        // サービスコンテナ app() ありのパターン
        // サービスコンテナへ登録
        app()->bind('sample', Sample::class);
        // サービスコンテナを呼び出した時点で、依存関係は解決され
        $sample2 = app()->make('sample');
        // 問題なく、メソッドが呼び出せる。
        $sample2->run();

        dd($test, app());
    }
}

/**
 * 依存関係のある2つのクラス
 * Sampleクラスは内部でMessageクラスのインスタンスを用いる。
 */
class Sample
{
    public $message;
    public function __construct(Message $message)
    {
        $this->message = $message;
    }
    public function run()
    {
        $this->message->send();
    }
}
class Message
{
    public function send()
    {
        echo 'メッセージです';
    }
}
