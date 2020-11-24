<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function listing($url)
    {
        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if($categoryCount > 0) {
            $categoryDetails = Category::catDetails($url);
            $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])
                ->where('status', 1)->get()->toArray();
            // dd($categoryDetails);
            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts'));
        }else {
            abort(404);
        }
    }
}
