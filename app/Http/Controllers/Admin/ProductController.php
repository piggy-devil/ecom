<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::get();
        // $products = json_decode(json_encode($products));
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        // // Get Product Image
        // $categoryImage = Category::select('category_image')->where('id', $id)->first();
        // // $categoryImage = json_decode(json_encode($categoryImage), true);
        // // echo "<pre>"; print_r($categoryImage); die;

        // if($categoryImage['category_image'] != ''){
        //     // Get Category Image Path
        //     $category_image_path = 'images/admin_images/category_images/';
    
        //     // Delete Category image from category_images folder if exists
        //     if(file_exists($category_image_path.$categoryImage->category_image)){
        //         unlink($category_image_path.$categoryImage->category_image);
        //     }
        // }

        // Delete Product
        Product::where('id', $id)->delete();

        $message = 'Product has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
