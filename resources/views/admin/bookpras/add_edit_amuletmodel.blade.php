@extends('layouts.backend.layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>รายการวัตถุมงคล</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">หน้าแรก</a></li>
                        <li class="breadcrumb-item active">รุ่นที่จัดสร้าง</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            @if ($errors->any())
            <div class="alert alert-danger" style="margin-top: 5px;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 5px;">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form name="amuletmodelForm" id="amuletmodelForm" @if(empty($amuletmodeldata['id'])) action="{{ url('admin/add-edit-amuletmodel') }}" @else action="{{ url('admin/add-edit-amuletmodel/'.$amuletmodeldata['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{ $title }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amuletmodel">ชื่อรุ่นที่จัดสร้าง</label>
                                    <input type="text" class="form-control" id="amuletmodel" name="amuletmodel" placeholder="ตย. หลวงพ่อปลอด วัดหัวป่า รุ่น120ปี" @if(!empty($amuletmodeldata['name'])) value="{{ $amuletmodeldata['name'] }}" @else value="{{ old('name') }}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="creator">จัดสร้างโดย</label>
                                    <input type="text" class="form-control" id="creator" name="creator" placeholder="ตย. วัดหัวป่า อ.ระโนด จ.สงขลา" @if(!empty($amuletmodeldata['creator'])) value="{{ $amuletmodeldata['creator'] }}" @else value="{{ old('creator') }}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="purpose">วัตถุประสงค์ในการจัดสร้าง</label>
                                    <textarea rows="3" class="form-control" id="purpose" name="purpose" placeholder="ตย. สร้างศาลาการเปรียญ">@if(!empty($amuletmodeldata['purpose'])){{ $amuletmodeldata['purpose'] }} @else{{ old('purpose') }}@endif</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ตกลง</button>
                    </div>
                </div>
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection