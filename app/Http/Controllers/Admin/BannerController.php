<?php

namespace App\Http\Controllers\Admin;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;

class BannerController extends Controller
{
    public function banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function addEditBanner(Request $request, $id=null)
    {
        if($id == "") {
            // Add Banner
            $bannerdata = new Banner;
            $title = "Add Banner Image";
            $message = "Banner added successfully!";
        }else {
            // Edit Banner
            $bannerdata = Banner::find($id);
            $title = "Edit Banner Image";
            $message = "Banner added successfully!";
        }

        if($request->isMethod('post')) {
            $data = $request->all();
            $bannerdata->link = $data['link'];
            $bannerdata->title = $data['title'];
            $bannerdata->alt = $data['alt'];

            // Upload Product Image
            if($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if($image_tmp->isValid()){
                    
                    // Get Original Image Name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;

                    // Set Paths for images
                    $banner_image_path = 'images/admin_images/banner_images/'.$imageName;

                    // Upload Banner Image after Resize
                    Image::make($image_tmp)->resize(1170, 480)->save($banner_image_path);

                    // Save Banner Image in banner table
                    $bannerdata->image = $imageName;
                }
            }
            $bannerdata->save();
            session::flash('success_message', $message);
            return redirect('admin/banners');

        }

        return view('admin.banners.add_edit_banner')->with(compact('title', 'bannerdata'));
    }

    public function updateBannerStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner($id)
    {
        // Get Banner Image
        $bannerImage = Banner::where('id', $id)->first();

        // Get Banner Image Path
        $banner_image_path = 'images/admin_images/banner_images/';

        // Delete Banner Image if exists in banners folder
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        
        // Delete Banner
        Banner::where('id', $id)->delete();

        $message = 'Banner has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
