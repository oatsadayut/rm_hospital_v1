@extends('layouts.app')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > ผู้มีสิทธิ์ใช้งานระบบ</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-md-6">
                            <h4>ผู้มีสิทธิ์ใช้งานระบบ</h4>
                        </div>
                    </div>
                    <hr>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="code-rm" data-toggle="tab" href="#userall" role="tab" aria-controls="code-rm" aria-selected="true"><h6 class=" text-secondary"><i class="fas fa-users"></i> ผู้มีสิทธิ์ใช้งานทั้งหมด</h6> </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="position-rm" data-toggle="tab" href="#userregis" role="tab" aria-controls="position-rm" aria-selected="false">
                                <h6 class=" text-secondary"><i class="fas fa-registered"></i> ลงทะเบียนใหม่
                                    @if ($q_count > 0)
                                        <span class="badge badge-danger">{{$q_count}}</span>
                                    @endif
                                </h6>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content py-2 pl-3 bg-detail-rm1" id="myTabContent">
                        <div class="tab-pane fade show active" id="userall" role="tabpanel" aria-labelledby="userall">
                            <table id="tebal-user1" class="table li table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>code</th>
                                        <th>cid</th>
                                        <th>ชื่อ</th>
                                        <th>สกุล</th>
                                        <th>สิทธิ์การใช้งาน</th>
                                        <th>สถานะ</th>
                                        <th class="bg-foot-b text-light text-center">view</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($q_all as $ra)
                                        <tr>
                                            <th>{{$ra->person_id}}</th>
                                            <td>{{$ra->cid}}</td>
                                            <td>{{$ra->person_fname}}</td>
                                            <td>{{$ra->person_lname}}</td>
                                            <td>{{$ra->per_name}}</td>
                                            @if ($ra->status_at == 1)
                                                <td><span class=" badge badge-success">ปกติ</span> </td>
                                            @elseif($ra->status_at == 2)
                                                <td><span class=" badge badge-danger">Block</span> </td>
                                            @else
                                                <td><span class=" badge badge-warning">ยังไม่ได้รับการอนุมัติ</span> </td>
                                            @endif

                                            <td class=" bg-dark text-center">
                                                @if ($ra->status_at == 2)
                                                {{-- //unblock --}}
                                                <form method="POST" action="{{ route('user-unblock') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_unblock_id" value="{{$ra->id}}">
                                                    <button type="submit" id="btn-submit" name="btn-submit" class=" btn btn-secondary btn-sm">Unblock</button>
                                                </form>
                                                @elseif ($ra->status_at == 1)
                                                {{-- //block --}}
                                                <form method="POST" action="{{ route('user-block') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_block_id" value="{{$ra->id}}">
                                                    <button type="submit" id="btn-submit" name="btn-submit" class=" btn btn-danger btn-sm">Block</button>
                                                    <a href="{{action('UserController@frmedit',$ra->id)}}" class=" btn btn-warning btn-sm">แก้ไข</a>
                                                </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>code</th>
                                        <th>cid</th>
                                        <th>ชื่อ</th>
                                        <th>สกุล</th>
                                        <th>สิทธิ์การใช้งาน</th>
                                        <th>สถานะ</th>
                                        <th class="bg-foot-b text-light text-center">view</th>
                                    </tr>

                                </tfoot>
                            </table>
                        </div>

                        <div class="tab-pane fade" id="userregis" role="tabpanel" aria-labelledby="userregis">
                            <table id="tebal-user2" class="table li table-bordered table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>code</th>
                                        <th>cid</th>
                                        <th>ชื่อ</th>
                                        <th>สกุล</th>
                                        <th>สถานะ</th>
                                        <th class="bg-foot-b text-light text-center">view</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($q as $r)
                                        <tr>
                                            <th>{{$r->person_id}}</th>
                                            <td>{{$r->cid}}</td>
                                            <td>{{$r->person_fname}}</td>
                                            <td>{{$r->person_lname}}</td>
                                            @if ($r->status_at == 1)
                                                <td><span class=" badge badge-success">ปกติ</span> </td>
                                            @elseif($r->status_at == 0)
                                                <td><span class=" badge badge-warning">ยังไม่ได้รับการอนุมัติ</span></td>
                                            @else
                                                <td><span class=" badge badge-danger">ยกเลิก</span> </td>
                                            @endif
                                            <td class=" bg-dark text-center">
                                                <form method="POST" action="{{ route('user-cancel') }}">
                                                    @csrf
                                                    <input type="hidden" name="user_cancel_id" value="{{$ra->id}}">
                                                    <button type="summit" id="btn-submit" name="btn-submit" class=" btn btn-danger btn-sm">ยกเลิก</button>
                                                    <a href="{{action('UserController@frmsubmit',$r->id)}}" class=" btn btn-success btn-sm">อนุมัติ</a>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>code</th>
                                        <th>cid</th>
                                        <th>ชื่อ</th>
                                        <th>สกุล</th>
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

