@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง > จัดการรหัสความเสี่ยง สรพ.</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <!-- Modal -->
                    <div class="modal fade" id="modaladdsrpaffected" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalScrollableTitle">เพิ่มข้อมูล</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <form method="POST" action="{{route('rmaddsrpriskcode')}}">
                                    @csrf

                                    <div class="modal-body">
                                        <div class="form-row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="name_srp_risk">ชื่อ</label>
                                                    <input type="text" class="form-control" id="name_srp_risk" name="name_srp_risk" placeholder="กรุณากรอก ชื่อ" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="code_export_srp">รหัสส่งออก</label>
                                                    <input type="text" class="form-control" id="code_export_srp" name="code_export_srp" placeholder="กรุณากรอก รหัสส่งออก" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="riskgroup_code">Risk group สรพ. (co_riskgroup_srp)</label>
                                                    <select name="riskgroup_code" class="form-control" required>
                                                        @foreach ($riskgroup_srp as $r)
                                                        <option value="{{$r->srp_riskgroup_id}}">{{$r->srp_riskgroup_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subgroup_srp_risk">Sub group</label>
                                                    <select name="subgroup_srp_risk" class="form-control" required>
                                                        @foreach ($subgroup_risk as $r)
                                                        <option value="{{$r->subgroup_id}}">{{$r->subgroup_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="category_srp_risk">Category Risk</label>
                                                    <select name="category_srp_risk" class="form-control" required>
                                                        @foreach ($category_risk as $r)
                                                        <option value="{{$r->category_id}}">{{$r->category_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="subcategory_srp_risk">Subcategory Risk</label>
                                                    <select name="subcategory_srp_risk" class="form-control" required>
                                                        @foreach ($subcategory_risk as $r)
                                                        <option value="{{$r->subcategory_id}}">{{$r->subcategory_name}}</option>
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

                    <div class=" row">
                        <div class="col-md-6">
                            <h5>รหัสส่งออก ผู้ได้รับผลกระทบ</h5>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" data-toggle="modal" data-target="#modaladdsrpaffected" class=" btn btn-success btn-sm"><i class="fas fa-plus"></i> เพิ่มข้อมูล</button>
                            <a href="/rmcode" class=" btn btn-secondary btn-sm"><i class="fas fa-undo"></i> ย้อนกลับ</a>
                        </div>
                    </div>

                    <hr>
                    <div>
                        <table id="tebal-setting5" class="table table-sm table-hover">
                            <thead class="thead-light ">
                              <tr>
                                <th scope="col">รหัส</th>
                                <th scope="col">ชื่อ</th>
                                <th scope="col">Export code</th>
                                <th scope="col">สถานะ</th>
                                <th scope="col" class=" text-center">view</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($riskcode_srp as $r)
                                    <tr>
                                        <th scope="row">{{$r->code_srp_id}}</th>
                                        <td>{{$r->name_srp_risk}}</td>
                                        <td>{{$r->code_export_srp}}</td>
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
                                            <a href="{{action('RmcodeController@frmsrpriskcode',$r->code_srp_id)}}" class=" btn btn-warning btn-sm">แก้ไข</a>
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
