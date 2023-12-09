@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ตั้งค่ารหัสความเสี่ยง</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="setting-code-tab" data-toggle="tab" href="#setting-code" role="tab" aria-controls="setting-code" aria-selected="true">รหัสความเสี่ยง</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="setting-codesrp-tab" data-toggle="tab" href="#setting-codesrp" role="tab" aria-controls="setting-codesrp" aria-selected="false">รหัส Mapping สรพ.</a>
                        </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="setting-code" role="tabpanel" aria-labelledby="setting-code-tab">
                            <div class="row my-3">
                                <div class="col-3 bg-menu-tab p-3">
                                  <div class="nav flex-column nav-pills  " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link text-dark active" id="source_code-tab" data-toggle="pill" href="#source_code" role="tab" aria-controls="source_code" aria-selected="true">แหล่งข้อมูล</a>
                                    <a class="nav-link text-dark" id="rm_dep-tab" data-toggle="pill" href="#rm_dep" role="tab" aria-controls="rm_dep" aria-selected="false">หน่วยงาน</a>
                                    <a class="nav-link text-dark" id="rm_affected_person-tab" data-toggle="pill" href="#rm_affected_person" role="tab" aria-controls="rm_affected_person" aria-selected="false">ผู้ได้รับผลกระทบ</a>
                                    <a class="nav-link text-dark" id="effect_code-tab" data-toggle="pill" href="#effect_code" role="tab" aria-controls="effect_code" aria-selected="false">ผลกระทบ</a>
                                    <a class="nav-link text-dark" id="specd_code-tab" data-toggle="pill" href="#specd_code" role="tab" aria-controls="specd_code" aria-selected="false">โรคเฉพาะ</a>
                                    <a class="nav-link text-dark" id="clinic_code-tab" data-toggle="pill" href="#clinic_code" role="tab" aria-controls="clinic_code" aria-selected="false">ชนิดความเสี่ยง</a>
                                    <a class="nav-link text-dark" id="rm_risk_code-tab" data-toggle="pill" href="#rm_risk_code" role="tab" aria-controls="rm_risk_code" aria-selected="false">รหัสความเสี่ยง</a>
                                    <a class="nav-link text-dark" id="rm_committee-tab" data-toggle="pill" href="#rm_committee" role="tab" aria-controls="rm_committee" aria-selected="false">กรรมการที่เกี่ยวข้อง</a>
                                  </div>
                                  <hr>
                                </div>
                                <div class="col-9">
                                  <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="source_code" role="tabpanel" aria-labelledby="source_code-tab">
                                        @include('rmcode.tabcontent.source')
                                    </div>
                                    <div class="tab-pane fade" id="rm_dep" role="tabpanel" aria-labelledby="rm_dep-tab">
                                        @include('rmcode.tabcontent.dep')
                                    </div>
                                    <div class="tab-pane fade" id="rm_affected_person" role="tabpanel" aria-labelledby="rm_affected_person-tab">
                                        @include('rmcode.tabcontent.affected')
                                    </div>
                                    <div class="tab-pane fade" id="effect_code" role="tabpanel" aria-labelledby="effect_code-tab">
                                        @include('rmcode.tabcontent.effect')
                                    </div>
                                    <div class="tab-pane fade" id="specd_code" role="tabpanel" aria-labelledby="specd_code-tab">
                                        @include('rmcode.tabcontent.specd')
                                    </div>
                                    <div class="tab-pane fade" id="clinic_code" role="tabpanel" aria-labelledby="clinic_code-tab">
                                        @include('rmcode.tabcontent.clinic')
                                    </div>
                                    <div class="tab-pane fade" id="rm_risk_code" role="tabpanel" aria-labelledby="rm_risk_code-tab">
                                        @include('rmcode.tabcontent.riskcode')
                                    </div>
                                    <div class="tab-pane fade" id="rm_committee" role="tabpanel" aria-labelledby="rm_committee-tab">
                                        @include('rmcode.tabcontent.committee')
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="setting-codesrp" role="tabpanel" aria-labelledby="setting-codesrp-tab">
                            <div class="row my-3">
                                <div class="col-3 bg-menu-tab p-3">
                                  <div class="nav flex-column nav-pills  " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                    <a class="nav-link text-dark active" id="rm_depsrp-tab" data-toggle="pill" href="#rm_depsrp" role="tab" aria-controls="rm_depsrp" aria-selected="false">หน่วยงาน</a>
                                    <a class="nav-link text-dark" id="rm_affectedsrp_person-tab" data-toggle="pill" href="#rm_affectedsrp_person" role="tab" aria-controls="rm_affectedsrp_person" aria-selected="false">ผู้ได้รับผลกระทบ</a>
                                    <a class="nav-link text-dark" id="rm_risk_codesrp-tab" data-toggle="pill" href="#rm_risk_codesrp" role="tab" aria-controls="rm_risk_codesrp" aria-selected="false">รหัสความเสี่ยง</a>
                                  </div>
                                  <hr>
                                </div>
                                <div class="col-9">
                                  <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="rm_depsrp" role="tabpanel" aria-labelledby="rm_depsrp-tab">
                                        @include('rmcode.tabcontent.srpdep')
                                    </div>
                                    <div class="tab-pane fade" id="rm_affectedsrp_person" role="tabpanel" aria-labelledby="rm_affectedsrp_person-tab">
                                        @include('rmcode.tabcontent.srpaffected')
                                    </div>
                                    <div class="tab-pane fade" id="rm_risk_codesrp" role="tabpanel" aria-labelledby="rm_risk_codesrp-tab">
                                        @include('rmcode.tabcontent.srpriskcode')
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
</div>

@endsection
