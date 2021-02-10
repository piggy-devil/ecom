<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ambook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AmbookController extends Controller
{
    public function ambooks()
    {
        Session::put('page', 'ambooks');
        $ambooks = Ambook::with('ambookattributes')->get();
        // dd($ambooks);
        return view('admin.bookpras.ambooks')->with(compact('ambooks'));
    }

    public function addAmuletbook(Request $request, $id = null)
    {
        if($id == "") {
            $title = "เพิ่ม-รายการ";
            $amuletmodel = new Ambook;
            $message = "คุณเพิ่มรายการสำเร็จ!";
        }else {
            $title = "แก้ไข-รายการ";
            $amuletmodel = Ambook::find($id);
            $message = "คุณปรับปรุงรายการสำเร็จ!";
        }

        if($request->isMethod('post')){
            dd('psot');
        }
        
        $amuletmodeldata = Ambook::select('id', 'name')->with('amuletbooks')->find($id);
        // dd($amuletmodeldata);
        // $amuletmodeldata = json_decode(json_encode($amuletmodeldata), true);
        // echo "<pre>"; print_r($amuletmodeldata); die;
        // $title = "Amuletmodel Amuletbooks";
        return view('admin.bookpras.add_amuletbooks')->with(compact('amuletmodeldata', 'title'));
    }

    public function addEditAmbook(Request $request, $id = null)
    {
        if($id == "") {
            $title = "เพิ่ม-รายการ";
            $ambook = new Ambook;
            $message = "คุณเพิ่มรายการสำเร็จ!";
        }else {
            $title = "แก้ไข-รายการ";
            $ambook = Ambook::find($id);
            $message = "คุณปรับปรุงรายการสำเร็จ!";
        }

        if($request->isMethod('post')) {
            $data = $request->all();
            $rules=[
                'ambook_name'=>'required',
                'ambook_create'=>'required',
                'ambook_stock'=>'required',
                'ambook_price'=>'required',
            ];
            $customMessages=[
                'ambook_name.required'=>'กรุณากรอกชื่อรายการ',
                'ambook_create.required'=>'กรุณากรอกจำนวนการจัดสร้าง',
                'ambook_stock.required'=>'กรุณากรอกจำนวนที่เปิดจอง',
                'ambook_price.required'=>'กรุณากรอกราคา',
            ];
            $this->validate($request,$rules,$customMessages);

             $ambook->ambook_name = $data['ambook_name'];
             $ambook->ambook_create = $data['ambook_create'];
             $ambook->ambook_stock = $data['ambook_stock'];
             $ambook->ambook_price = $data['ambook_price'];

             $ambook->save();

            session::flash('success_message', $message);

            return redirect('admin/ambooks');;
        }

        $ambookdata = Ambook::select('id', 'ambook_name', 'ambook_create', 'ambook_stock', 'ambook_price')->find($id);
        // dd($ambookdata);

        return view('admin.bookpras.add_edit_ambook')->with(compact('ambookdata', 'title'));
    }

    public function addEditAttrAmbook(Request $request, $id = null) {
        if($id == "") {
            $maintitle = "เพิ่ม-รายการ-หลัก";
            $subtitle = "เพิ่ม-รายการ-ย่อย";
            $ambook = new Ambook;
            $message = "คุณเพิ่มรายการสำเร็จ!";
        }else {
            $maintitle = "แก้ไข-รายการ-หลัก";
            $subtitle = "แก้ไข-รายการ-ย่อย";
            $ambook = Ambook::find($id);
            $message = "คุณปรับปรุงรายการสำเร็จ!";
        }
        $ambookdata = Ambook::select('id', 'ambook_name', 'ambook_create', 'ambook_stock', 'ambook_price')->with('ambookattributes')->find($id);
        // dd($ambookdata);
        return view('admin.bookpras.add_edit_attribute_ambook')->with(compact('ambookdata', 'maintitle', 'subtitle'));
    }

    public function deleteAmbook($id)
    {
        // Delete Ambook
        Ambook::where('id', $id)->delete();

        $message = 'Ambook has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
