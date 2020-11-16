<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
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
            $product = new Product;
        }else {
            $title = "Edit Product";
        }

        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //Product Validations
            $rules=[
                'category_id'=>'required',
                'product_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'product_code'=>'required|regex:/^[\w-]*$/',
                'product_price'=>'required|numeric',
                'product_color'=>'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages=[
                'category_id.required'=>'Category is required',
                'product_name.required'=>'Product Name is required',
                'product_name.regex'=>'Valid Product Name is required',
                'product_code.required'=>'Product Code is required',
                'product_code.regex'=>'Valid Product Code is required',
                'product_price.required'=>'Product Price is required',
                'product_price.numeric'=>'Valid Product Price is required',
                'product_color.required'=>'Product Color is required',
                'product_color.regex'=>'Valid Product Color is required',
            ];
            $this->validate($request,$rules,$customMessages);

            if(empty($data['is_featured'])){
                $data['is_featured'] = "No";
            }

            if(empty($data['product_discount'])){
                $data['product_discount'] = "";
            }

            if(empty($data['fabric'])){
                $data['fabric'] = "";
            }

            if(empty($data['pattern'])){
                $data['pattern'] = "";
            }

            if(empty($data['sleeve'])){
                $data['sleeve'] = "";
            }

            if(empty($data['fit'])){
                $data['fit'] = "";
            }

            if(empty($data['occasion'])){
                $data['occasion'] = "";
            }

            if(empty($data['meta_title'])){
                $data['meta_title'] = "";
            }

            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] = "";
            }

            if(empty($data['meta_description'])){
                $data['meta_description'] = "";
            }

            // Upload Product Image
            if($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if($image_tmp->isValid()){
                    
                    // Get Original Image Name
                    $image_name = $image_tmp->getClientOriginalName();

                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();

                    // Generate New Image Name
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                    
                    // Set Paths for small, medium and large images
                    $large_image_path = 'images/admin_images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/admin_images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/admin_images/product_images/small/'.$imageName;

                    // Upload Large Image after Resize
                    Image::make($image_tmp)->save($large_image_path); // W:1040 H:1200

                    // Upload Medium and Small Image after Resize
                    Image::make($image_tmp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260, 300)->save($small_image_path);

                    // Save Product Main Image in products table
                    $product->product_image = $imageName;
                }
            }

            // Upload Product Video
            if($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if($video_tmp->isValid()) {
                    // Upload Video
                    $video_name = $video_tmp->getClientOriginalName();
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = $video_name.'-'.rand().'.'.$extension;
                    $video_path = 'videos/product_videos/';
                    $video_tmp->move($video_path, $videoName);

                    // Save Video in products table
                    $product->product_video = $videoName;
                }
            }

            // Save Product details in products table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            $product->is_featured = $data['is_featured'];
            $product->status = 1;
            $product->save();
            session::flash('success_message', 'Product added successfully!');
            return redirect('admin/products');
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
