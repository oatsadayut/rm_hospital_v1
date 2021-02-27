@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > รายงาน</span>
</div>
@include('report.modal.modalbox')
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12">
                            <h5><b>รายงานความเสี่ยง</b></h5>
                            <hr>
                        </div>
                        <div class=" col-md-12">
                            <table class="table table-sm table-hover">
                                <thead>
                                  <tr>
                                    <th scope="col">ลำดับที่</th>
                                    <th scope="col">รายงาน</th>
                                    <th scope="col">view</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th scope="row">1</th>
                                    <td>รายงานภาพรวมความเสี่ยง ระดับโรงพยาบาล</td>
                                    <td>
                                      <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#printallrm">
                                        Print PDF <i class="far fa-file-pdf"></i>
                                      </button>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th scope="row">2</th>
                                    <td>รายงานภาพรวมความเสี่ยง ระดับหน่วยงาน</td>
                                    <td>
                                      <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#printdeprm">
                                        Print PDF <i class="far fa-file-pdf"></i>
                                      </button>
                                    </td>
                                  </tr>
                                  <tr>
                                    <th scope="row">3</th>
                                    <td>รายงานภาพรวมความเสี่ยง กรรมการที่เกี่ยวข้อง (ทีม)</td>
                                    <td>
                                      <button type="button" class="btn btn-sm btn-outline-success" data-toggle="modal" data-target="#printcommitteerm">
                                        Print PDF <i class="far fa-file-pdf"></i>
                                      </button>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
