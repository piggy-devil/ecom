<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductAttribute;
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
            $productdata = array();
            $message = "Product added successfully!";
        }else {
            $title = "Edit Product";
            $productdata = Product::find($id);
            // $productdata = json_decode(json_encode($productdata), true);
            // echo "<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "Product edit successfully!";
        }

        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //Product Validations
            $rules=[
                'brand_id'=>'required',
                'category_id'=>'required',
                'product_name'=>'required|regex:/^[\pL\s\-]+$/u',
                'product_code'=>'required|regex:/^[\w-]*$/',
                'product_price'=>'required|numeric',
                'product_color'=>'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages=[
                'category_id.required'=>'Category is required',
                'brand_id.required'=>'Brand is required',
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

            // if(empty($data['product_discount'])){
            //     $data['product_discount'] = "";
            // }

            // if(empty($data['fabric'])){
            //     $data['fabric'] = "";
            // }

            // if(empty($data['pattern'])){
            //     $data['pattern'] = "";
            // }

            // if(empty($data['sleeve'])){
            //     $data['sleeve'] = "";
            // }

            // if(empty($data['fit'])){
            //     $data['fit'] = "";
            // }

            // if(empty($data['occasion'])){
            //     $data['occasion'] = "";
            // }

            // if(empty($data['meta_title'])){
            //     $data['meta_title'] = "";
            // }

            // if(empty($data['meta_keywords'])){
            //     $data['meta_keywords'] = "";
            // }

            // if(empty($data['meta_description'])){
            //     $data['meta_description'] = "";
            // }

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
            $product->brand_id = $data['brand_id'];
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
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else {
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            session::flash('success_message', $message);
            return redirect('admin/products');
        }

        // Product Filters
        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];
        

        // Sections with Categories and Sub Categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        // echo "<pre>"; print_r($categories); die;

        // Get All Brands
        $brands = Brand::where('status', 1)->get();

        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'productdata', 'brands'));
    }

    public function deleteProductImage($id)
    {
        // Get Product Image
        $productImage = Product::select('product_image')->where('id', $id)->first();

        // Get Product Image Paths
        $small_image_path = 'images/admin_images/product_images/small/';
        $medium_image_path = 'images/admin_images/product_images/medium/';
        $large_image_path = 'images/admin_images/product_images/large/';

        // Delete Product small image if exits in small folder
        if(file_exists($small_image_path.$productImage->product_image)){
            unlink($small_image_path.$productImage->product_image);
        }
        // Delete Product medium image if exits in medium folder
        if(file_exists($medium_image_path.$productImage->product_image)){
            unlink($medium_image_path.$productImage->product_image);
        }
        // Delete Product large image if exits in large folder
        if(file_exists($large_image_path.$productImage->product_image)){
            unlink($large_image_path.$productImage->product_image);
        }

        // Delete Product Image from categories table
        product::where('id', $id)->update(['product_image' => '']);

        $message = 'product image has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }

    public function deleteProductVideo($id)
    {
        // Get Product Image
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // Get Product Video Path
        $product_video_path = 'videos/product_videos/';

        // Delete product video from product_videos folder if exists
        if(file_exists($product_video_path.$productVideo->product_video)){
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete product video from categories table
        product::where('id', $id)->update(['product_video' => '']);

        $message = 'Product video has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }

    public function addAttributes(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['sku'] as $key => $value) {
                if(!empty($value)) {

                    // SKU already exists check
                    $attrCountSKU = ProductAttribute::where('sku' ,$value)->count();
                    if($attrCountSKU > 0) {
                        $message = 'SKU already exists. Please add another SKU';
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    // Size already exists check
                    $attrCountSize = ProductAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if($attrCountSize > 0) {
                        $message = 'Size already exists. Please add another Size';
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $message = 'Product Attributes added successfully!';
            session::flash('success_message', $message);
            return redirect()->back();
        }
        $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_image')->with('attributes')->find($id);
        // $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    public function editAttributes(Request $request, $id)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach($data['attrId'] as $key => $attr) {
                if(!empty($attr)) {
                    ProductAttribute::where(['id' => $data['attrId'][$key]])->update(['price' => $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
            }
            $message = 'Product Attributes has been updated successfully!';
            session::flash('success_message', $message);
            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteAttribute($id)
    {
        // Delete Attribute
        ProductAttribute::where('id', $id)->delete();

        $message = 'Attribute has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }

    public function addImages(Request $request, $id)
    {
        if($request->isMethod('post')){
            // $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($request->hasFile('images')){
                $images = $request->file('images');
                // echo "test"; die;
                // echo "<pre>"; print_r($images); die;
                foreach($images as $key => $image) {
                    $productImage = new ProductImage;
                    $image_tmp = Image::make($image);
                    // echo $originalName = $image->getClientOriginalName(); die;
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,9999999).time().".".$extension;
                            
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
                        $productImage->image = $imageName;
                        $productImage->product_id = $id;
                        $productImage->status = 1;
                        $productImage->save();
                }

                $message = 'Product Images has been added successfully!';
                session::flash('success_message', $message);

                return redirect()->back();
            }
        }

        $productdata = Product::with('images')->select('id', 'product_name', 'product_code', 'product_color', 'product_image')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Product Images";
        return view('admin.products.add_images')->with(compact('productdata', 'title'));
    }

    public function updateImageStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            ProductImage::where('id', $data['image_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id)
    {
        // // Delete Image
        // ProductImage::where('id', $id)->delete();

        // $message = 'Image has been deleted successfully!';
        // session::flash('success_message', $message);

        // return redirect()->back();
        // Get Product Image
        $productImage = ProductImage::select('image')->where('id', $id)->first();

        // Get Product Image Paths
        $small_image_path = 'images/admin_images/product_images/small/';
        $medium_image_path = 'images/admin_images/product_images/medium/';
        $large_image_path = 'images/admin_images/product_images/large/';

        // Delete Product small image if exits in small folder
        if(file_exists($small_image_path.$productImage->image)){
            unlink($small_image_path.$productImage->image);
        }
        // Delete Product medium image if exits in medium folder
        if(file_exists($medium_image_path.$productImage->image)){
            unlink($medium_image_path.$productImage->image);
        }
        // Delete Product large image if exits in large folder
        if(file_exists($large_image_path.$productImage->image)){
            unlink($large_image_path.$productImage->image);
        }

        // Delete Product Image from categories table
        ProductImage::where('id', $id)->delete();

        $message = 'product image has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
