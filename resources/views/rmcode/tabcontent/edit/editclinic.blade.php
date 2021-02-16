@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง > จัดการชนิดความเสี่ยง > แก้ไขชนิดความเสี่ยง</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{route('rmeditclinic')}}">
                        @csrf
                            <div class="row">
                                <div class="col-md-12 pt-2 px-5">
                                    <h5>แก้ไขชนิดความเสี่ยง</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 px-5 pt-1">
                                    <div class="form-group">
                                        <label for="clinic_name" class=" h5">ชื่อ</label>
                                        <input type="text" placeholder="กรุณากรอก ชื่อชนิดความเสี่ยง" value="{{$qe->clinic_name}}" name="clinic_name" class=" form-control" required>
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
                                    <input type="hidden" name="code" value="{{$qe->clinic_code}}">
                                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">ยืนยัน</button>
                                    <a href="/rmcode/manage/clinic" class="btn btn-secondary">ย้อนกลับ</a>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

