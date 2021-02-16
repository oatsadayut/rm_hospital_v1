@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง > จัดการรหัสผู้ได้รับผลกระทบ</span>
</div>
{{-- Modal --}}

<!-- Modal -->
<div class="modal fade" id="modaladdaffected" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">เพิ่มผู้ได้รับผลกระทบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{route('rmaddaffected')}}">
                @csrf

                <div class="modal-body">
                    <div class="form-row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="affected_name">ชื่อ</label>
                                <input type="text" class="form-control" id="affected_name" name="affected_name" placeholder="กรุณากรอก ชื่อผู้ได้รับผลกระทบ" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="export_code">Mapping สรพ. (ผู้ได้รับผลกระทบ)</label>
                                <select id="sel-27" name="export_code" class="form-control">
                                    <option value="" disabled selected>กรุณาเลือก</option>
                                    @foreach ($affected_srp as $r)
                                    <option value="{{$r->affected_export_code}}">[{{$r->affected_export_code}}] : {{$r->affected_srp_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">สถานะ</label>
                                <select name="status" class="form-control" required>
                                    <option value="Y" selected>ปกติ</option>
                                    <option value="N" >ยกเลิก</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>

            </form>

        </div>
    </div>
</div>
{{-- End Modal --}}
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-md-6">
                            <h5>ตั้งค่าผู้ได้รับผลกระทบ</h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" data-toggle="modal" data-target="#modaladdaffected" class=" btn btn-success btn-sm"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                            <a href="/rmcode" class=" btn btn-secondary btn-sm"><i class="fas fa-undo"></i> ย้อนกลับ</a>
                        </div>
                    </div>

                    <hr>
                    <div>
                        <table id="tebal-setting3" class="table table-sm table-hover">
                            <thead class="thead-light ">
                            <tr>
                                <th scope="col">รหัส</th>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">Mapping code</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col" class=" text-center">view</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($affected as $r)
                                    <tr>
                                        <th scope="row">{{$r->affected_code}}</th>
                                        <td>{{$r->affected_name}}</td>
                                        <td>{{$r->export_code}}</td>
                                        <td>
                                            @if ($r->status != '' || $r->status != null)
                                                @if ($r->status == 'Y')
                                                <span class="badge badge-success">{{$r->status}} ใช้งาน</span>
                                                @else
                                                <span class="badge badge-danger">{{$r->status}} ยกเลิก</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class=" text-center bg-secondary">
                                        <a href="{{action('RmcodeController@frmaffected',$r->affected_code)}}" class=" btn btn-warning btn-sm">แก้ไข</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection