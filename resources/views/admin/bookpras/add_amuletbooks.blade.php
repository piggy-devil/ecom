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
            <form name="addAmuletbookForm" id="addAmuletbookForm" action="{{ url('admin/add-amuletbooks/'.$amuletmodeldata['id']) }}" method="post" enctype="multipart/form-data">@csrf
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
                                    <label for="ambook_name">ชื่อรุ่น:</label> &nbsp; {{ $amuletmodeldata['name'] }}
                                </div>
                                <div class="form-group">
                                    <label for="ambook_create">จำนวนการสร้าง:</label> &nbsp; {{ $amuletmodeldata['purpose'] }}
                                </div>
                                <div class="form-group">
                                    <label for="ambook_stock">จำนวนที่เปิดให้จอง:</label> &nbsp; {{ $amuletmodeldata['ambook_stock'] }}
                                </div>
                                <div class="form-group">
                                    <label for="ambook_price">ราคา/รายการ:</label> &nbsp; {{ $amuletmodeldata['ambook_price'] }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <img style="width: 120px;" src="{{ asset('images/admin_images/ambook_images/small/'.$amuletmodeldata['ambook_image']) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <div>
                                            <input id="create" name="create[]" type="text" value="" placeholder="Size" style="width: 100px;" required />
                                            <input id="stock" name="stock[]" type="text" value="" placeholder="SKU" style="width: 100px;" required />
                                            <input id="price" name="price[]" type="number" value="" placeholder="Price" style="width: 100px;" required />
                                            <a href="javascript:void(0)" class="add_button" title="Add field">Add</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Add amuletbooks</button>
                    </div>
                </div>
            </form>

            <form name="editAmuletbookForm" id="editAmuletbookForm" method="POST" action="{{ url('admin/edit-amuletbooks/'.$amuletmodeldata['id']) }}">@csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Added ambook amuletbooks</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="ambooks" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ชื่อรายการ</th>
                                    <th>จำนวนการสร้าง</th>
                                    <th>จำนวนที่เปิดจอง</th>
                                    <th>ราคาจอง</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($amuletmodeldata['amuletbooks'] as $amuletbook)
                                <input style="display: none;" type="text" name="attrId[]" value="{{ $amuletbook['id'] }}">
                                <tr>
                                    <td>{{ $amuletbook['id'] }}</td>
                                    <td>{{ $amuletbook['ambook_name'] }}</td>
                                    <td>
                                        <input type="number" name="create[]" value="{{ $amuletbook['ambook_create'] }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="stock[]" value="{{ $amuletbook['ambook_stock'] }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="price[]" value="{{ $amuletbook['ambook_price'] }}" required>
                                    </td>
                                    <td>
                                        @if($amuletbook['status']==1)
                                        <a class="updateAmuletbookStatus" id="amuletbook-{{ $amuletbook['id'] }}" amuletbook_id="{{ $amuletbook['id'] }}" href="javascript:void(0)">Active</a>
                                        @else
                                        <a class="updateAmuletbookStatus" id="amuletbook-{{ $amuletbook['id'] }}" amuletbook_id="{{ $amuletbook['id'] }}" href="javascript:void(0)">Inactive</a>
                                        @endif
                                        &nbsp;&nbsp;
                                        <a title="Delete amuletbook" href="javascrip:void(0)" class="confirmDelete" record="amuletbook" recordid="{{ $amuletbook['id'] }}"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update amuletbooks</button>
                    </div>
                    <!-- /.card-body -->
                </div>
            </form>

        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection