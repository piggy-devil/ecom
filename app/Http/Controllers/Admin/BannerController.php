<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Session;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function banners()
    {
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
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
