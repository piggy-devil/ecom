@extends('layouts.backend.layout')
@section('content')
<div class="content-wrapper">
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
            @if(Session::has('error_message'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 5px;">
                {{ Session::get('error_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            <form name="ambookForm" id="ambookForm" @if(empty($ambookdata['id'])) action="{{ url('admin/add-edit-ambook') }}" @else action="{{ url('admin/add-edit-ambook/'.$ambookdata['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{ $maintitle }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ชื่อรายการ</th>
                                        <th>จำนวนการสร้าง</th>
                                        <th>จำนวนที่เปิดจอง</th>
                                        <th>ราคาจอง</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="ambook_name" name="ambook_name" value="{{ $ambookdata['ambook_name'] }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="ambook_create" name="ambook_create" value="{{ $ambookdata['ambook_create'] }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="ambook_stock" name="ambook_stock" value="{{ $ambookdata['ambook_stock'] }}">
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" id="ambook_price" name="ambook_price" value="{{ $ambookdata['ambook_price'] }}">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">ตกลง</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <div>
                                            <input id="size" name="size[]" type="text" value="" placeholder="Size" style="width: 100px;" required />
                                            <input id="sku" name="sku[]" type="text" value="" placeholder="SKU" style="width: 100px;" required />
                                            <input id="price" name="price[]" type="number" value="" placeholder="Price" style="width: 100px;" required />
                                            <input id="stock" name="stock[]" type="number" value="" placeholder="Stock" style="width: 100px;" required />
                                            <a href="javascript:void(0)" class="add_button" title="Add field">Add</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add Attributes</button>
                    </div>
                </div>
            </form>

            <form name="ambookForm" id="ambookForm" @if(empty($ambookdata['id'])) action="{{ url('admin/add-edit-ambook') }}" @else action="{{ url('admin/add-edit-ambook/'.$ambookdata['id']) }}" @endif method="post" enctype="multipart/form-data">@csrf
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">{{ $subtitle }}</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ชื่อรายการ</th>
                                    <th>จำนวนการสร้าง</th>
                                    <th>จำนวนที่เปิดจอง</th>
                                    <th>ราคาจอง</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ambookdata['ambookattributes'] as $ambookattribute)
                                <input style="display: none;" type="text" name="attrId[]" value="{{ $ambookattribute['id'] }}">
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" id="ambook_name" name="ambook_name" value="{{ $ambookattribute['ambook_name'] }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="ambook_create" name="ambook_create" value="{{ $ambookattribute['ambook_create'] }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="ambook_stock" name="ambook_stock" value="{{ $ambookattribute['ambook_stock'] }}">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" id="ambook_price" name="ambook_price" value="{{ $ambookattribute['ambook_price'] }}">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">ตกลง</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection