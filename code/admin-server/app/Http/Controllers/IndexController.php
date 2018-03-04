<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index() {
        // return $this->getBaseData();
        return view('index.index');
    }

    public function info() {
        return view('info');
    }

}
