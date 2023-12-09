@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > จัดการความเสี่ยง > รายละเอียด > แก้ไขข้อมูล</span>
    <a href="{{action('ManagerrmController@detail',$qe->rmmain_id)}}" class=" btn btn-secondary">Back : ย้อนกลับ</a>
</div>



<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>เกิดข้อผิดพลาดกรุณาตรวจสอบอีกครั้ง {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-body">


                    <div class="row mb-5">
                        <div class="col-md-12 text-center">
                            <h2>แก้ไขข้อมูลความเสี่ยง RM</h2>
                            <hr>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('managerrm_update_rm') }}">
                        @csrf
{{------------------------------------------ 1 -------------------------------------------------------------}}

                        <h5 ><span class=" bg-title-rm0 p-2">1.แหล่งข้อมูล / วันเวลาเกิดเหตุ</span></h5>
                        <hr>
                        <div class="form-row mb-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="source_code">แหล่งข้อมูล <span class=" text-danger">*</span></label>
                                    <select id="sel-source" name="source_code" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_source as $r)
                                            <option value="{{$r->source_code}}" {{($r->source_code == $qe->source_code) ? "selected" : ""}}>{{$r->source_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rm_date">วันที่เกิดเหตุ <span class=" text-danger">*</span></label>
                                    <input id="rm_date" name="rm_date" type="date" value="{{$qe->rmmain_dateon}}" onkeydown="return false" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rm_time">เวลาเกิดเหตุการณ์ <span class=" text-danger">*</span></label>
                                    <input id="rm_time" name="rm_time" type="time" value="{{$qe->rmmain_time}}" class="form-control" required>
                                    <input type="hidden" id="part_show_hidden" name="part_show_hidden" required>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="alert alert-primary" role="alert">
                                    <span>เหตุการณ์ : </span>
                                    <span id="date_show"></span>
                                    <span id="time_show"></span>
                                    <span id="part_show"></span>
                                </div>
                            </div>

                        </div>

{{------------------------------------------ 2 -------------------------------------------------------------}}

                        <h5><span class=" bg-title-rm0 p-2">2.รายละเอียดเหตุการณ์</span></h5>
                        <hr>
                        <div class="form-row mb-3">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rm_point">สถานที่เกิดเหตุ <span class=" text-danger">*</span></label>
                                    <select id="sel-rm15" name="rm_point" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_dep as $r)
                                        <option value="{{$r->dep_code}}" {{($r->dep_code == $qe->rm_point) ? "selected" : ""}}>{{$r->dep_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="rm_title">หัวข้อเหตุการณ์ (150 ตัวอักษร) <span class=" text-danger">*</span></label>
                                    <input type="text" class="form-control" id="rm_title" value="{{$qe->rmmain_topic}}" name="rm_title" maxlength="150" required placeholder=" กรุณากรอก หัวข้อเหตุการณ์">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rm_detail">รายละเอียดเหตุการณ์</label>
                                    <textarea name="rm_detail" class=" form-control" rows="7"  id="rm_detail" required name="rm_detail" placeholder=" กรุณากรอก รายละเอียดเหตุการณ์">{{$qe->rmmain_detail}}</textarea>
                                </div>
                            </div>

                        </div>

{{------------------------------------------ 3 -------------------------------------------------------------}}
                        <h5><span class=" bg-title-rm0 p-2">3.ผลกระทบ / โรคเฉพาะ</span></h5>
                        <hr>
                        <div class="form-row mb-3">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_affected_person">ผู้ได้รับผลกระทบ <span class=" text-danger">*</span></label>
                                    <select id="sel-rm11" name="rm_affected_person" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_affected_person as $r)
                                            <option value="{{$r->affected_code}}" {{($r->affected_code == $qe->rm_affected_person) ? "selected" : ""}}>{{$r->affected_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" >
                                <div class="form-group" id="d_rm_sex" style="display: none">
                                    <label for="rm_affected_sex">เพศ</label>
                                    <select id="sel-rm12" name="rm_affected_sex" class="form-control">
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_sex as $r)
                                            <option value="{{$r->code}}" {{($r->code == $qe->rm_affected_sex) ? "selected" : ""}}>{{$r->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-3" >
                                <div class="form-group" id="d_rm_age" style="display: none">
                                    <label for="rm_affected_age">อายุ</label>
                                    <input type="number" class="form-control" value="{{$qe->rm_affected_age}}" id="rm_affected_age" name="rm_affected_age" placeholder=" กรุณากรอก อายุ">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_effect">ผลกระทบ <span class=" text-danger">*</span></label>
                                    <select id="sel-rm4" name="rm_effect" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_effect as $r)
                                        <option value="{{$r->effect_code}}" {{($r->effect_code == $qe->effect_code) ? "selected" : ""}}>{{$r->effect_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_disease">โรคเฉพาะ</label>
                                    <select id="sel-rm6" name="rm_disease" class="form-control">
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_specd as $r)
                                        <option value="{{$r->specd_code}}" {{($r->specd_code == $qe->specd_code) ? "selected" : ""}}>{{$r->specd_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


{{------------------------------------------ 4 -------------------------------------------------------------}}

                        <h5><span class=" bg-title-rm0 p-2">4.ความเสี่ยง / ความรุนแรง</span></h5>
                        <hr>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_risk_type">ชนิดความเสี่ยง <span class=" text-danger">*</span></label>
                                    <select id="sel-rm1" name="rm_risk_type" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_clinic as $r)
                                        <option value="{{$r->clinic_code}}" {{($r->clinic_code == $qe->clinic_code) ? "selected" : ""}}>{{$r->clinic_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_risk_code">รหัสความเสี่ยง <span class=" text-danger">*</span></label>
                                    <select id="sel-rm2" name="rm_risk_code[]" class="form-control" required multiple="multiple">
                                        @foreach ($q_risk as $r)
                                            <option value="{{$r->risk_code}}"
                                                @foreach ($q_risk_code as $ra)
                                                {{($r->risk_code == $ra->risk_code) ? "selected" : ""}}
                                                @endforeach
                                                >{{$r->risk_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rm_violence_level">ระดับความรุนแรง <span class=" text-danger">*</span></label>
                                    <select id="sel-rm3" name="rm_violence_level" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_level as $r)
                                            <option value="{{$r->level_code}}" {{($r->level_code == $qe->level_code) ? "selected" : ""}}>{{$r->level_name}} : {{$r->level_detail}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

{{------------------------------------------ 5 -------------------------------------------------------------}}

                        <h5><span class=" bg-title-rm0 p-2">5.การเกี่ยวข้อง</span></h5>
                        <hr>
                        <div class="form-row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_dep">หน่วยงานที่เกี่ยวข้อง <span class=" text-danger">*</span></label>
                                    <select id="sel-rm7" name="rm_dep[]" class="form-control" multiple="multiple" required>
                                        @foreach ($q_dep as $r)
                                            <option value="{{$r->dep_code}}"
                                                @foreach ($q_dep_code as $ra)
                                                    {{($r->dep_code == $ra->dep_code) ? "selected" : ""}}
                                                @endforeach
                                                >{{$r->dep_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rm_committee">กรรมการที่เกี่ยวข้อง</label>
                                    <select id="sel-rm8" name="rm_committee[]" class="form-control" multiple="multiple" required>
                                        @foreach ($q_committee as $r)
                                            <option value="{{$r->committee_code}}"
                                                @foreach ($q_committee_code as $ra)
                                                    {{($r->committee_code == $ra->committee_code) ? "selected" : ""}}
                                                @endforeach
                                                >{{$r->committee_name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

{{------------------------------------------ 6 -------------------------------------------------------------}}

                        <h5><span class=" bg-title-rm0 p-2">6.ผู้รายงาน</span></h5>
                        <hr>
                        <div class="form-row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rm_reporter">ผู้เขียนรายงาน <span class=" text-danger">*</span></label>
                                    <select id="sel-rm9" name="rm_reporter" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_persons as $r)
                                        <option value="{{$r->person_cid}}" {{($r->person_cid == $qe->rmmain_cidrp) ? "selected" : ""}}>{{$r->person_fname}}  {{$r->person_lname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-row justify-content-center mt-2">
                            <div class="col-md-12 text-center mb-4">
                                <span class=" text-danger">กรุณาตรวจสอบข้อมูลอีกรอบก่อนการบันทึก</span>
                            </div>

                            <div class="col-md-3">
                                <input type="hidden" name="rmmain_id" value="{{$qe->rmmain_id}}">
                                <button type="submit" id="btn-submit" name="btn-submit" class="btn btn-primary btn-block">Save : บันทักข้อมูล</button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{action('ManagerrmController@detail',$qe->rmmain_id)}}" class="btn btn-secondary btn-block">Back : ย้อนกลับ</a>
                            </div>
                        </div>

{{------------------------------------------ end input -------------------------------------------------------------}}

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
