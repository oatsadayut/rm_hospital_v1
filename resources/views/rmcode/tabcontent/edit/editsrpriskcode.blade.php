@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง > จัดการรหัสความเสี่ยง สรพ. > แก้ไขรหัสความเสี่ยง สรพ.</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{route('rmeditsrpriskcode')}}">
                        @csrf
                            <div class="row">
                                <div class="col-md-12 pt-2 px-5">
                                    <h5>แก้ไขรหัสความเสี่ยง</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="name_srp_risk">ชื่อ</label>
                                        <input type="text" class="form-control" value="{{$qe->name_srp_risk}}" id="name_srp_risk" name="name_srp_risk" placeholder="กรุณากรอก ชื่อ" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="code_export_srp">รหัสส่งออก</label>
                                        <input type="text" class="form-control" value="{{$qe->code_export_srp}}" id="code_export_srp"  name="code_export_srp" placeholder="กรุณากรอก รหัสส่งออก" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="riskgroup_code">Risk group สรพ. (co_riskgroup_srp)</label>
                                        <select name="riskgroup_code" class="form-control" required>
                                            @foreach ($riskgroup_srp as $r)
                                            <option value="{{$r->srp_riskgroup_id}}" {{($r->srp_riskgroup_id == $qe->riskgroup_code) ? "selected" : ""}}>{{$r->srp_riskgroup_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="subgroup_srp_risk">Sub group</label>
                                        <select id="sel-21" name="subgroup_srp_risk" class="form-control" required>
                                            @foreach ($subgroup_risk as $r)
                                            <option value="{{$r->subgroup_id}}" {{($r->subgroup_id == $qe->subgroup_srp_risk) ? "selected" : ""}}>{{$r->subgroup_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="category_srp_risk">Category Risk</label>
                                        <select id="sel-22" name="category_srp_risk" class="form-control" required>
                                            @foreach ($category_risk as $r)
                                            <option value="{{$r->category_id}}" {{($r->category_id == $qe->category_srp_risk) ? "selected" : ""}}>{{$r->category_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="subcategory_srp_risk">Subcategory Risk</label>
                                        <select id="sel-20" name="subcategory_srp_risk" class="form-control" required>
                                            @foreach ($subcategory_risk as $r)
                                            <option value="{{$r->subcategory_id}}" {{($r->subcategory_id == $qe->subcategory_srp_risk) ? "selected" : ""}}>{{$r->subcategory_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="status">สถานะ</label>
                                        <select name="status" class="form-control" required>
                                            @if ($qe->status === 'Y')
                                                <option value="Y" selected>ปกติ</option>
                                                <option value="N">ยกเลิก</option>
                                            @elseif($qe->status === 'N')
                                                <option value="Y">ปกติ</option>
                                                <option value="N" selected>ยกเลิก</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 py-2">
                                    <input type="hidden" name="code" value="{{$qe->code_srp_id}}">
                                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">ยืนยัน</button>
                                    <a href="/rmcode/manage/srpriskcode" class="btn btn-secondary">ย้อนกลับ</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 
@endsection
