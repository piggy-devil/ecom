<?php

namespace App\Http\Controllers\Admin;

use App\Models\Amuletmodel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class AmuletModelController extends Controller
{
    public function amuletmodels()
    {
        Session::put('page', 'amuletmodels');
        $amuletmodels = Amuletmodel::get();
        return view('admin.bookpra.amuletmodels')->with(compact('amuletmodels'));
    }

    public function amuletmodelStatus(Request $request)
    {
        if($request->ajax()){
            $data = $request->all();

            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Amuletmodel::where('id', $data['amuletmodel_id'])->update(['status'=>$status]);

            return response()->json(['status'=>$status, 'amuletmodel_id'=>$data['amuletmodel_id']]);
        }
    }

    public function addEditAmuletModel(Request $request, $id = null)
    {
        if($id == "") {
            $title = "เพิ่ม-ชื่อรุ่น";
            $amuletmodel = new Amuletmodel;
            $message = "คุณเพิ่มรายการสำเร็จ!";
        }else {
            $title = "แก้ไข-ชื่อรุ่น";
            $amuletmodel = Amuletmodel::find($id);
            $message = "คุณปรับปรุงรายการสำเร็จ!";
        }

        if($request->isMethod('post')) {
            $data = $request->all();
            
            //amuletmodel validations
            $rules=[
                'amuletmodel'=>'required'
            ];
            $customMessages=[
                'amuletmodel.required'=>'กรุณากรอกชื่อรุ่นที่จัดสร้าง',
            ];
            $this->validate($request,$rules,$customMessages);

            $amuletmodel->name = $data['amuletmodel'];
            $amuletmodel->creator = $data['creator'];
            $amuletmodel->purpose = $data['purpose'];
            // dd($amuletmodel);
            $amuletmodel->save();

            session::flash('success_message', $message);

            return redirect('admin/amuletmodels');;

        }
        $amuletmodeldata = $amuletmodel;

        return view('admin.bookpra.add_edit_amuletmodel')->with(compact('title', 'amuletmodeldata'));
    }

    public function deleteAmuletmodel($id)
    {
        // Delete Amuletmodel
        Amuletmodel::where('id', $id)->delete();

        $message = 'Amuletmodel has been deleted successfully!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
