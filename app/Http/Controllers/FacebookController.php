<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacebookController extends Controller
{
    public function privacy()
    {
        return view('facebook.privacy');
    }
    public function tos()
    {
        return view('facebook.tos');
    }
    public function delete()
    {
        return view('facebook.delete');
    }
}
