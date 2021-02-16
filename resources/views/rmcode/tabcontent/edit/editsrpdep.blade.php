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

                    <form method="POST" action="{{route('rmeditsrpdep')}}">
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
                                        <label for="dep_srp_name" class=" h5">ชื่อ</label>
                                        <input type="text" placeholder="กรุณากรอก ชื่อหน่วยงาน" value="{{$qe->dep_srp_name}}" name="dep_srp_name" class=" form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="dep_srp_export_code" class=" h5">รหัสส่งออก</label>
                                        <input type="text" placeholder="กรุณากรอก ชื่อหน่วยงานภาษาอังกฤษ" value="{{$qe->dep_srp_export_code}}" name="dep_srp_export_code" class=" form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 px-5 py-2">
                                    <input type="hidden" name="code" value="{{$qe->dep_srp_id}}">
                                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">ยืนยัน</button>
                                    <a href="/rmcode/manage/srpdep" class="btn btn-secondary">ย้อนกลับ</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
