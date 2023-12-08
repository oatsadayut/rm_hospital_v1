@extends('layouts.app')
@section('content')
@include('function.dathai')
    {{-- Modal --}}

    <!-- Modal ทบทวน -->
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">ลงทบทวน</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('managerrm_review') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rm_date_review">วันที่ทบทวน</label>
                                    <input type="date" class="form-control" id="rm_date_review"
                                        value="{{ $q->rm_date_review }}" name="rm_date_review" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rm_review">ทบทวน</label>
                                    <select id="sel-22" name="rm_review" class="form-control" required>
                                        <option value="" disabled selected>กรุณาเลือก</option>
                                        @foreach ($q_system as $r)
                                            <option value="{{ $r->system_code }}"
                                                {{ $r->system_code == $q->system_code ? 'selected' : '' }}>
                                                {{ $r->system_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="rm_results_review">ผลการทบทวน</label>
                                    <textarea name="rm_results_review" class=" form-control" rows="7" id="rm_results_review"
                                        placeholder=" กรุณากรอก ผลการทบทวน" required>{{ $q->rm_results_review }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="rmmain_id" value="{{ $q->rmmain_id }}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">บันทึกทบทวน</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Modal ยกเลิกความเสี่ยง -->
    <div class="modal fade" id="modalcancelrm" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">ยกเลิกความเสี่ยง</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('log_cancel_rm') }}">
                    @csrf

                    <div class="modal-body">
                        <div class="form-row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="log_detail" class=" text-danger">*กรุณากรอกเหตุผลการยกเลิก</label>
                                    <textarea name="log_detail" class=" form-control" rows="7" id="log_detail"
                                        placeholder=" กรุณากรอก เหตุผลการยกเลิก" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="rmmain_id" value="{{ $q->rmmain_id }}">
                        <input type="hidden" name="person_id" value="{{ Auth::user()->person_id }}">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                        <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">บันทึกทบทวน</button>
                    </div>

                </form>

            </div>
        </div>
    </div>



    {{-- End Modal --}}

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
        <span>HOME > จัดการความเสี่ยง > รายละเอียด</span>
        <a href="/managerrm" class=" btn btn-secondary">Back : ย้อนกลับ</a>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 mb-3">

                <div class="card">
                    <div class="card-body">

                        <div class=" row">
                            <div class="col-md-6">
                                <h4>รายละเอียด</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <h4>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ action('PrintrmController@printrm', $q->rmmain_id) }}" target="_blank"
                                            class="btn btn-primary"><i class="fas fa-file-pdf"></i> Print PDF</a>

                                        @if(Auth::user()->permission >= 2)
                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                data-target="#exampleModalScrollable"><i class="fas fa-check-circle"></i>
                                                ทบทวน</button>

                                            <a href="{{ action('ManagerrmController@frmupdate', $q->rmmain_id) }}"
                                                class="btn btn-warning"><i class="fas fa-edit"></i> แก้ไขความเสี่ยง</a>

                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#modalcancelrm"><i class="fas fa-times-circle"></i>
                                                ยกเลิกความเสี่ยง</button>
                                        @endif

                                    </div>
                                </h4>
                            </div>
                            <hr>
                        </div>

                        <div class=" row bg-detail-rm p-2">

                            <div class="col-md-6">
                                <h5><span class=" text-secondary"> แหล่งข้อมูล :</span> {{ $q->source->source_name }}</h5>
                                <h5><span class=" text-secondary"> วัน/เวลา ที่เกิดเหตุ :</span>{{DateThai($q->rmmain_dateon)}}
                                  เวลา :{{ $q->rmmain_time }} เวร :{{ $q->rm_part_time }}</h5>
                                <h5><span class=" text-secondary">สถานที่เกิดเหตุ :</span>
                                    @if ($q->rm_point != null || $q->rm_point != '')
                                        {{ $q->c_dep->dep_name }}
                                    @endif
                                </h5>
                                <h5><span class=" text-secondary">โรคเฉพาะ :</span>
                                    @if ($q->specd_code != null || $q->specd_code != '')
                                        {{ $q->specd->specd_name }}
                                    @endif
                                </h5>
                            </div>

                            <div class="col-md-6">

                                <h5><span class=" text-secondary">ผู้ได้รับผลกระทบ :</span>
                                    @if ($q->rm_affected_person != '' || $q->rm_affected_person != null)
                                        {{ $q->affected->affected_name }}
                                    @endif

                                    @if ($q->rm_affected_sex != '' || $q->rm_affected_sex != null)
                                        เพศ : {{ $q->c_sex->name }} อายุ : {{ $q->rm_affected_age }}
                                    @endif
                                </h5>
                                <h5><span class=" text-secondary">ผลกระทบ :</span>
                                    @if ($q->effect_code != '' || $q->effect_code != null)
                                        {{ $q->effect->effect_name }}
                                    @endif
                                </h5>
                                <h5><span class=" text-secondary">ชนิดความเสี่ยง :</span>
                                    @if ($q->clinic_code != '' || $q->clinic_code != null)
                                        {{ $q->c_clinic->clinic_name }}
                                    @endif
                                </h5>
                                <h5><span class=" text-secondary">ผู้รายงาน :</span>
                                    @if ($q_person_chk > 0 || $q_person_chk != null)
                                        {{ $q_person->person_fname }} {{ $q_person->person_lname }}
                                    @endif
                                </h5>

                            </div>

                        </div>

                    </div> {{-- card-body --}}
                </div> {{-- card --}}

            </div> {{-- col-md-12 --}}

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="code-rm" data-toggle="tab" href="#code" role="tab"
                                    aria-controls="code-rm" aria-selected="true">
                                    <h5 class=" text-secondary"><i class="fas fa-shield-alt text-warningb"></i>
                                        รหัสความเสี่ยง</h5>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="position-rm" data-toggle="tab" href="#position" role="tab"
                                    aria-controls="position-rm" aria-selected="false">
                                    <h5 class=" text-secondary"><i class="fas fa-clinic-medical text-success"></i>
                                        หน่วยงานที่เกี่ยว</h5>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="committee-rm" data-toggle="tab" href="#committtee" role="tab"
                                    aria-controls="committee-rm" aria-selected="false">
                                    <h5 class=" text-secondary"><i class="fas fa-user-md text-info"></i>
                                        กรรมการที่เกี่ยวข้อง</h5>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content py-2 pl-3 bg-detail-rm1" id="myTabContent">
                            <div class="tab-pane fade show active" id="code" role="tabpanel" aria-labelledby="code-rm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:10px" scope="col">รหัสส่งออก</th>
                                            <th style="width:400px" scope="col">ชื่อรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($q_risk_code as $r)
                                            <tr>
                                                <th scope="row">{{ $r->export_code }}</th>
                                                <td>{{ $r->risk_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="position" role="tabpanel" aria-labelledby="position-rm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:10px" scope="col">รหัสส่งออก</th>
                                            <th style="width:400px" scope="col">ชื่อรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($q_dep_code as $r)
                                            <tr>
                                                <th scope="row">{{ $r->place }}</th>
                                                <td>{{ $r->dep_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="committtee" role="tabpanel" aria-labelledby="committee-rm">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width:10px" scope="col">รหัสส่งออก</th>
                                            <th style="width:400px" scope="col">ชื่อรายการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($q_committee_code as $r)
                                            <tr>
                                                <th scope="row">{{ $r->committee_export }}</th>
                                                <td>{{ $r->committee_name }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5>เหตุการณ์</h5>
                        <hr>
                        <div class=" row bg-detail-rm p-2">
                            <div class="col-md-12 mb-3">
                                <div>
                                    <h5 class=" text-secondary">หัวข้อเหตุการณ์</h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $q->rmmain_topic }}
                                    </h5>
                                </div>
                                <hr>
                                <div>
                                    <h5 class=" text-secondary">รายละเอียดเหตุการณ์</h5>
                                    <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ $q->rmmain_detail }}
                                    </h5>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body ">
                        <h5>การทบทวน</h5>
                        <hr>
                        <div class=" row bg-detail-rm p-2">
                            <div class="col-md-12">
                                <h5><span class=" text-secondary">วันที่ทบทวน : </span>{{DateThai($q->rm_date_review)}}</h5>
                                <h5><span class=" text-secondary">การทบทวน : </span>{{ $q->system->system_name }}</h5>
                            </div>
                        </div>
                        <hr>
                        <div class=" row bg-detail-rm p-2">
                            <div class="col-md-12 mb-3">
                                <h5><span class=" text-secondary">รายละเอียดทบทวน :</span> </h5>
                                <h5>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{ $q->rm_results_review }}
                                </h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
