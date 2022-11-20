<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        echo 'hello world';
        //return view('welcome_message');
    }

    public function test()
    {
        echo 'test';
    }
}
