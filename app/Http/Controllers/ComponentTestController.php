<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentTestController extends Controller
{
    //
    public function showComponent1()
    {
        $message123 = 'メッセージ';
        return view('tests.component-test1', compact('message123'));
    }

    public function showComponent2()
    {
        return view('tests.component-test2');
    }
}
