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
            <div class="row">
                <div class="col-12">
                    <!-- /.card -->
                    @if(Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 5px;">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">รุ่นที่จัดสร้าง</h3>
                            <a href="{{ url('admin/add-edit-ambook') }}" style="max-width: 150px; float:right; display: inline-block;" class="btn btn-block btn-success">เพิ่ม</a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="sections" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อรายการ</th>
                                        <th>จำนวนการสร้าง</th>
                                        <th>จำนวนที่เปิดจอง</th>
                                        <th>ราคาจอง</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 0; ?>
                                    @foreach($ambooks as $ambook)
                                    <?php $count += 1; ?>
                                    <tr>
                                        <td>{{ $count }}</td>
                                        @if($ambook->is_topic == 'Yes')
                                        <td colspan="4">{{ $ambook->ambook_name }}</td>
                                        @else
                                        <td>{{ $ambook->ambook_name }}</td>
                                        <td>{{ $ambook->ambook_create }}</td>
                                        <td>{{ $ambook->ambook_stock }}</td>
                                        <td>{{ $ambook->ambook_price }}</td>
                                        @endif
                                        <td class="float-right">
                                            @if($ambook->is_list == 'Yes')
                                            <a title="เพิ่ม/แก้ไขรายการย่อย" href="{{ url('admin/add-edit-attr-ambook/'.$ambook->id) }}"><i class="fas fa-plus"></i></a>
                                            &nbsp;&nbsp;
                                            @endif
                                            <a title="แก้ไขรายการหลัก" href="{{ url('admin/add-edit-ambook/'.$ambook->id) }}"><i class="fas fa-edit"></i></a>
                                            &nbsp;&nbsp;
                                            <a title="ลบรายการ" href="javascrip:void(0)" class="confirmDelete" record="ambook" recordid="{{ $ambook->id }}"><i class="fas fa-trash"></i></a>
                                            &nbsp;&nbsp;
                                            @if($ambook->status==1)
                                            <a class="updateAmbookStatus" id="ambook-{{$ambook->id}}" book_id="{{ $ambook->id }}" href="javascript:void(0)"><i title="ใช้งาน" class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                            @else
                                            <a class="updateAmbookStatus" id="ambook-{{$ambook->id}}" book_id="{{ $ambook->id }}" href="javascript:void(0)"><i title="ไม่ใช้งาน" class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    <?php $subcount = 0; ?>
                                    @foreach($ambook['ambookattributes'] as $am)
                                    <?php $subcount += 1; ?>

                                    <tr>
                                        <td></td>
                                        <td colspan="4">{{ $count.'.'.$subcount.' '.$am->ambook_name }}</td>
                                        <td></td>
                                    </tr>

                                    @endforeach
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection