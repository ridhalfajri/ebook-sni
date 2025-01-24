<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Ebook;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index():View {
        $ebooks = Ebook::limit(8)->get();
        return view('frontend.home',compact('ebooks'));
    }
}
