<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::with(['category' => function($query){
            $query->select('id', 'category_name');
        }, 'section' => function($query) {
            $query->select('id', 'name');
        }])->get();
        // $products = json_decode(json_encode($products));
        // echo "<pre>"; print_r($products); die;
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

    public function addEditProduct(Request $request, $id=null)
    {
        if($id == "") {
            $title = "Add Product";
        }else {
            $title = "Edit Product";
        }

        // Filter Arrays
        $fabricArray = array('Cotton', 'Polyester', 'Wool');
        $sleevArray = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $fitArray = array('Regular', 'Slim');
        $occasionArray = array('Casual', 'Formal');

        // Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        // echo "<pre>"; print_r($categories); die;

        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleevArray', 'patternArray', 'fitArray', 'occasionArray', 'categories'));
    }
}
