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
            <div class="row">
                <div class="col-12">
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
                    <form name="ambookForm" id="ambookForm" @if(empty($ambookdata['id'])) action="{{ url('admin/add-edit-ambook') }}" @else action="{{ url('admin/add-edit-ambook/'.$ambookdata['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
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
                                            <label for="ambook_name">ชื่อรายการ</label>
                                            <textarea rows="5" class="form-control" id="ambook_name" name="ambook_name" placeholder="Enter ...">@if(!empty($ambookdata['ambook_name'])) {{ $ambookdata['ambook_name'] }}@else{{ old('ambook_name') }}@endif</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="checkbox" name="is_topic" id="is_topic" value="Yes" @if(!empty($ambookdata['is_topic']) && $ambookdata['is_topic']=="Yes" ) checked @endif>
                                            <label for="is_topic">เลือก(หากไม่ต้องการกำหนดราคาที่รายการหลัก)</label>
                                            <table class="table table-bordered table-striped" disabled>
                                                <thead>
                                                    <tr>
                                                        <th>จำนวนการสร้าง</th>
                                                        <th>จำนวนที่เปิดจอง</th>
                                                        <th>ราคาจอง</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="number" class="table_is_topic form-control" id="ambook_create" name="ambook_create" @if(!empty($ambookdata['ambook_create'])) value="{{ $ambookdata['ambook_create'] }}" @else value="{{ old('ambook_create') }}" @endif>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="table_is_topic form-control" id="ambook_stock" name="ambook_stock" @if(!empty($ambookdata['ambook_stock'])) value="{{ $ambookdata['ambook_stock'] }}" @else value="{{ old('ambook_stock') }}" @endif>
                                                        </td>
                                                        <td>
                                                            <input type="number" class="table_is_topic form-control" id="ambook_price" name="ambook_price" @if(!empty($ambookdata['ambook_price'])) value="{{ $ambookdata['ambook_price'] }}" @else value="{{ old('ambook_price') }}" @endif>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-primary">ตกลง</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>จำนวนการสร้าง</th>
                                            <th>จำนวนที่เปิดจอง</th>
                                            <th>ราคาจอง</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="number" class="form-control" id="ambook_create" name="ambook_create" @if(!empty($ambookdata['ambook_create'])) value="{{ $ambookdata['ambook_create'] }}" @else value="{{ old('ambook_create') }}" @endif>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="ambook_stock" name="ambook_stock" @if(!empty($ambookdata['ambook_stock'])) value="{{ $ambookdata['ambook_stock'] }}" @else value="{{ old('ambook_stock') }}" @endif>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" id="ambook_price" name="ambook_price" @if(!empty($ambookdata['ambook_price'])) value="{{ $ambookdata['ambook_price'] }}" @else value="{{ old('ambook_price') }}" @endif>
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-primary">ตกลง</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection