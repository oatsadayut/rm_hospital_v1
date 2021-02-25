@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > บุคคลากรในระบบ > แก้ไขบุคคลากร</span>
</div>

<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>เกิดข้อผิดพลาดกรุณาตรวจสอบอีกครั้ง {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class=" row">
                        <div class="col-md-6">
                            <h4>แก้ไขบุคคลากร</h4>
                        </div>
                    </div>
                    <hr>
                    <div class=" row">
                        <div class="col-md-12">
                            <form method="POST" action="{{ route('person-update') }}">
                            @csrf
                                <div class="form-row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="person_fname">ชื่อ <span class=" text-danger">*</span></label>
                                            <input id="person_fname" name="person_fname" type="text" class="form-control" value="{{$g_person->person_fname}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="person_lname">สกุล <span class=" text-danger">*</span></label>
                                            <input id="person_lname" name="person_lname" type="text" class="form-control" value="{{$g_person->person_lname}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="person_cid">เลขบัตรประชาชน CID <span class=" text-danger">*</span></label>
                                            <input id="person_cid" name="person_cid" type="number" class="form-control" value="{{$g_person->person_cid}}" disabled required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dep_code">หน่วยงาน <span class=" text-danger">*</span></label>
                                            <select id="sel-20" name="dep_code" class="form-control" required>
                                                @foreach ($dep as $r)
                                                    <option value="{{$r->dep_code}}" {{($r->dep_code == $g_person->dep_code) ? "selected" : ""}}>{{$r->dep_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">สถานะ <span class=" text-danger">*</span></label>
                                            <select id="sel-21" name="status" class="form-control" required>
                                                @if ($g_person->status == 'Y')
                                                    <option value="Y"selected>ปกติ</option>
                                                    <option value="N">ยกเลิก</option>
                                                @else
                                                    <option value="Y">ปกติ</option>
                                                    <option value="N"selected>ยกเลิก</option>
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                        <input type="hidden" name="person_id" value="{{$g_person->person_id}}">
                                        <button type="submit" id="btn-submit" name="btn-submit" class=" btn btn-sm btn-primary"> บันทึกข้อมูล</button>
                                        <a href="/person" class="btn btn-sm btn-secondary"><i class="fas fa-undo"></i> ย้อนกลับ</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection

