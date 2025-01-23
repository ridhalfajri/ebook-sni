<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index():View {
        $ebooks = Ebook::all();
        return view('frontend.home',compact('ebooks'));
    }
}
