@extends('layouts.app')
@section('content')

{{-- Modal --}}

<!-- Modal ทบทวน -->
<div class="modal fade" id="modaladdperson" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">เพิ่มบุคคลกร</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>เกิดข้อผิดพลาดกรุณาตรวจสอบอีกครั้ง {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form method="POST" action="{{ route('person-add') }}">
                @csrf

                <div class="modal-body">
                    <div class="form-row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="person_fname">ชื่อ</label>
                                <input type="text" class="form-control" id="person_fname" name="person_fname" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="person_lname">สกุล</label>
                                <input type="text" class="form-control" id="person_lname" name="person_lname" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="person_cid">CID <span class=" text-danger">*กรุณาตรวจสอบให้ถูกต้อง</span></label>
                                <input type="number" class="form-control" id="person_cid" name="person_cid" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="dep_code">หน่วยงาน</label>
                                <select id="sel-rm13" name="dep_code" class="form-control" required>
                                    <option value="" disabled selected>กรุณาเลือก</option>
                                    @foreach ($dep as $r)
                                    <option value="{{$r->dep_code}}">{{$r->dep_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="status">สถานะ</label>
                                <select name="status" class="form-control" required>
                                    <option value="Y" selected>ปกติ</option>
                                    <option value="N" >ยกเลิก</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                    <button type="summit" id="btn-submit" name="btn-submit" class="btn btn-primary">บันทึกข้อมูล</button>
                </div>

            </form>

        </div>
    </div>
</div>
{{-- End Modal --}}

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > บุคคลากรในระบบ</span>
</div>


<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-md-6">
                            <h4>บุคคลากรในระบบ</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <button type="button" data-toggle="modal" data-target="#modaladdperson" class=" btn  btn-sm btn-success"><i class="fas fa-plus"></i> เพิ่มบุคคลากร</button>
                        </div>
                    </div>
                    <hr>
                    <div class=" row">
                        <div class="col-md-12">
                            <table id="tebal-person" class="table li table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>code</th>
                                        <th>cid</th>
                                        <th>ชื่อ</th>
                                        <th>สกุล</th>
                                        <th>หน่วยงาน</th>
                                        <th>สถานะ</th>
                                        <th class="bg-foot-b text-light text-center">view</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($person as $r)
                                        <tr>
                                            <th>{{$r->person_id}}</th>
                                            <td>{{$r->person_cid}}</td>
                                            <td>{{$r->person_fname}}</td>
                                            <td>{{$r->person_lname}}</td>
                                            @if ($r->dep_code != '')
                                                <td>{{$r->dep_name}}</td>
                                            @else
                                                <td><span class=" text-danger">ไม่ได้ระบุ</span></td>
                                            @endif
                                            <td>
                                                @if ($r->status == 'Y')
                                                <span class="badge badge-success">{{$r->status}} ปกติ</span>
                                                @else
                                                <span class="badge badge-danger">{{$r->status}} ยกเลิก</span>
                                                @endif

                                            </td>
                                            <td class=" bg-dark text-center"><a href="{{action('PersonController@get_person',$r->person_id)}}" class=" btn btn-warning btn-sm">แก้ไขข้อมูล</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>code</th>
                                        <th>cid</th>
                                        <th>ชื่อ</th>
                                        <th>สกุล</th>
                                        <th>หน่วยงาน</th>
                                        <th>สถานะ</th>
                                        <th class="bg-foot-b text-light text-center">view</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

