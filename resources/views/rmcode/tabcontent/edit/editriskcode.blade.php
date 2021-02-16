@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง > จัดการรหัสความเสี่ยง > แก้ไขรหัสความเสี่ยง</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" action="{{route('rmeditriskcode')}}">
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
                                        <label for="risk_name" class=" h5">ชื่อ</label>
                                        <input type="text" placeholder="กรุณากรอก ชื่อผลกระทบ" value="{{$qe->risk_name}}" name="risk_name" class=" form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="committee_code">กรรมการที่เกี่ยวข้อง</label>
                                        <select id="sel-31" name="committee_code" class="form-control" required>
                                            <option value="" disabled selected>กรุณาเลือก</option>
                                            @foreach ($committee as $r)
                                            <option value="{{$r->committee_code}}" {{($r->committee_code == $qe->committee_code) ? "selected" : ""}}>[{{$r->committee_code}}] : {{$r->committee_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="clinic_code">ชนิดความเสี่ยง</label>
                                        <select id="sel-32" name="clinic_code" class="form-control" required>
                                            <option value="" disabled selected>กรุณาเลือก</option>
                                            @foreach ($clinic as $r)
                                            <option value="{{$r->clinic_code}}" {{($r->clinic_code == $qe->clinic_code) ? "selected" : ""}}>[{{$r->clinic_code}}] : {{$r->clinic_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="riskgroup_code">กลุ่มความเสี่ยง</label>
                                        <select id="sel-33" name="riskgroup_code" class="form-control" required>
                                            <option value="" disabled selected>กรุณาเลือก</option>
                                            @foreach ($riskgroup as $r)
                                            <option value="{{$r->riskgroup_code}}" {{($r->riskgroup_code == $qe->riskgroup_code) ? "selected" : ""}}>[{{$r->riskgroup_code}}] : {{$r->riskgroup_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="export_code">Mapping สรพ. (รหัสความเสี่ยง)</label>
                                        <select id="sel-34" name="export_code" class="form-control">
                                            <option value="" disabled selected>กรุณาเลือก</option>
                                            @foreach ($riskcode_srp as $r)
                                            <option value="{{$r->code_export_srp}}" {{($r->code_export_srp == $qe->export_code) ? "selected" : ""}}>[{{$r->code_export_srp}}] : {{$r->name_srp_risk}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pb-1 pt-1">
                                    <div class="form-group">
                                        <label for="status" class=" h5">สถานะ</label>
                                        <select id="sel-24" name="status" class="form-control" required>
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
                                    <input type="hidden" name="code" value="{{$qe->risk_code}}">
                                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">ยืนยัน</button>
                                    <a href="/rmcode/manage/riskcode" class="btn btn-secondary">ย้อนกลับ</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection