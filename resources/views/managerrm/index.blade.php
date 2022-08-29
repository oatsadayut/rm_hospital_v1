@extends('layouts.app')
@section('content')
@include('function.dathai')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > จัดการความเสี่ยง</span>
</div>

<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class=" row">
                        <div class="col-md-12">
                            <h4>จัดการความเสี่ยง</h4>
                            <hr>
                        </div>
                    </div>
                    <form action="{{ route('managerrm_getdate') }}" method="get">
                        <div class=" row">
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <label class="input-group-text" for="dateStart">ตั้งแต่</label>
                                </div>
                                <input type="date" class="form-control" name="date_first" id="dateStart" value="{{$date_first}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                <label class="input-group-text" for="dateEnd">ถึง</label>
                                </div>
                                <input type="date" class="form-control" name="date_last" id="dateEnd" value="{{$date_last}}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="dep">หน่วยงาน</label>
                                    <select class="form-control" id="dep" name="dep">
                                        <option value="0" {{($dep == "0") ? "selected" : ""}}>ทั้งหมด</option>
                                        @foreach ($q_dep as $r)
                                            <option value="{{ $r->dep_code }}" {{($r->dep_code == $dep) ? "selected" : ""}}>{{ $r->dep_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class=" btn btn-primary">ค้นหา</button>
                                <button type="button" class=" btn btn-success" id="exportbutton">Excel Export</button>
                            </div>
                        </div>
                    </form>
                    <div class=" row">
                        <div class="col-md-12">
                            <table id="tebal-1" class="table li table-bordered table-sm table-hover">
                                <thead>
                                    <tr>

                                        <th>#รหัส</th>

                                        <th>หัวข้อเหตุการณ์</th>
                                        <th>วันที่รายงาน</th>
                                        <th>วันที่เกิดเหตุ</th>
                                        <th>ความรุนแรง</th>
                                        <th>ทบทวน</th>
                                        <th class="bg-foot-b text-light text-center">view</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($q as $r)
                                        <tr>
                                            <td class=" bg-title-table">{{$r->rmmain_id}}</td>
                                            <td class=" bg-title-table">{{$r->rmmain_topic}}</td>
                                            <td>{{DateThai($r->rmmain_daterp)}}</td>
                                            <td>{{DateThai($r->rmmain_dateon)}}</td>
                                            @if ($r->level_code == 1)
                                                <td><span class="badge c-a">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 2)
                                                <td><span class="badge c-b">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 3)
                                                <td><span class="badge c-c">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 4)
                                                <td><span class="badge c-d">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 5)
                                                <td><span class="badge c-e">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 6)
                                                <td><span class="badge c-f">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 7)
                                                <td><span class="badge c-g">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 8)
                                                <td><span class="badge c-h">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 9)
                                                <td><span class="badge c-i">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 10)
                                                <td><span class="badge c-a">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 11)
                                                <td><span class="badge c-b">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 12)
                                                <td><span class="badge c-c">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 13)
                                                <td><span class="badge c-d">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 14)
                                                <td><span class="badge badge-secondary">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 16)
                                                <td><span class="badge c-a">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 17)
                                                <td><span class="badge c-b">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 18)
                                                <td><span class="badge c-c">{{$r->level->level_name}}</span></td>
                                            @elseif($r->level_code == 19)
                                                <td><span class="badge c-d">{{$r->level->level_name}}</span></td>
                                            @else
                                                <td><span class="badge badge-secondary">ไม่ได้ลงข้อมูล</span></td>
                                            @endif

                                            @if ($r->system_code == 1)
                                                <td><span class="badge badge-warning">{{$r->system->system_name}}</span></td>
                                            @elseif($r->system_code == 2)
                                                <td><span class="badge badge-success">{{$r->system->system_name}}</span></td>
                                            @else
                                                <td><span class="badge badge-secondary">{{$r->system->system_name}}</span></td>
                                            @endif

                                            <td><a href="{{action('ManagerrmController@detail',$r->rmmain_id)}}" class=" btn btn-primary btn-block btn-sm">รายละเอียด</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#รหัส</th>
                                        <th>หัวข้อเหตุการณ์</th>
                                        <th>วันที่รายงาน</th>
                                        <th>วันที่เกิดเหตุ</th>
                                        <th>ความรุนแรง</th>
                                        <th>ทบทวน</th>
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

