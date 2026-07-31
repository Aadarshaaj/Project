<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'featuredProducts' => Product::query()->take(4)->get(),
            'collections' => ['Essentials', 'Travel', 'Workspace', 'Footwear'],
        ]);
    }

    public function shop(Request $request)
    {
        $products = Product::query()->with('media')->paginate(12);

        return view('pages.shop', [
            'products' => $products,
        ]);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->with('variants', 'media')->firstOrFail();

        return view('pages.product', [
            'product' => $product,
        ]);
    }

    public function cart()
    {
        return view('pages.cart');
    }
}
