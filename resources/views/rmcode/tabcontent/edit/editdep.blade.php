@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง > จัดการหน่วยงาน > แก้ไขหน่วยงาน</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{route('rmeditdep')}}">
                        @csrf
                            <div class="row">
                                <div class="col-md-12 pt-2 px-5">
                                    <h5>แก้ไขหน่วยงาน</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="dep_name" class=" h5">ชื่อ</label>
                                        <input type="text" placeholder="กรุณากรอก ชื่อหน่วยงาน" value="{{$qe->dep_name}}" name="dep_name" class=" form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="dep_ename" class=" h5">ชื่อ(ภาษาอังกฤษ)</label>
                                        <input type="text" placeholder="กรุณากรอก ชื่อหน่วยงานภาษาอังกฤษ" value="{{$qe->dep_ename}}" name="dep_ename" class=" form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="place">Mapping สรพ. (สถานที่เกิดเหตุ)</label>
                                        <select id="sel-26" name="place" class="form-control">
                                            <option value="" disabled selected>กรุณาเลือก</option>
                                            @foreach ($dep_srp as $r)
                                            <option value="{{$r->dep_srp_export_code}}" {{($r->dep_srp_export_code == $qe->place) ? "selected" : ""}}>[{{$r->dep_srp_export_code}}] : {{$r->dep_srp_name}}</option>
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
                                    <input type="hidden" name="code" value="{{$qe->dep_code}}">
                                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">ยืนยัน</button>
                                    <a href="/rmcode/manage/dep" class="btn btn-secondary">ย้อนกลับ</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
