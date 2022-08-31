@extends('layouts.app')
@section('content')
    @include('function.dathai')

    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
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
                                        <input type="date" class="form-control" name="date_first" id="dateStart"
                                            value="{{ $date_first }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="dateEnd">ถึง</label>
                                        </div>
                                        <input type="date" class="form-control" name="date_last" id="dateEnd"
                                            value="{{ $date_last }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="dep">หน่วยงาน</label>
                                        <select class="form-control" id="dep" name="dep">
                                            <option value="0" {{ $dep == '0' ? 'selected' : '' }}>ทั้งหมด</option>
                                            @foreach ($q_dep as $r)
                                                <option value="{{ $r->dep_code }}"
                                                    {{ $r->dep_code == $dep ? 'selected' : '' }}>{{ $r->dep_name }}
                                                </option>
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
                                <div class="table-responsive-xl">
                                    <table id="tebal-1" class="table li table-bordered table-sm table-hover "
                                        style="width:100%">
                                        <thead>
                                            <tr>

                                                <th>#รหัส</th>

                                                <th>หัวข้อเหตุการณ์</th>
                                                <th>หน่วยงานที่เกี่ยวข้อง</th>
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
                                                    <td class=" bg-title-table" style="width:5%">{{ $r->rmmain_id }}</td>
                                                    <td class=" bg-title-table" style="width:25%">{{ $r->rmmain_topic }}
                                                    </td>
                                                    <td style="width:21%">{{ $r->rmdepname }}</td>
                                                    <td style="width:13%">{{ DateThai($r->rmmain_daterp) }}</td>
                                                    <td style="width:13%">{{ DateThai($r->rmmain_dateon) }}</td>
                                                    @if ($r->level_code == 1)
                                                        <td style="width:7%"><span
                                                                class="badge c-a">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 2)
                                                        <td style="width:7%"><span
                                                                class="badge c-b">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 3)
                                                        <td style="width:7%"><span
                                                                class="badge c-c">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 4)
                                                        <td style="width:7%"><span
                                                                class="badge c-d">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 5)
                                                        <td style="width:7%"><span
                                                                class="badge c-e">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 6)
                                                        <td style="width:7%"><span
                                                                class="badge c-f">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 7)
                                                        <td style="width:7%"><span
                                                                class="badge c-g">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 8)
                                                        <td style="width:7%"><span
                                                                class="badge c-h">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 9)
                                                        <td style="width:7%"><span
                                                                class="badge c-i">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 10)
                                                        <td style="width:7%"><span
                                                                class="badge c-a">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 11)
                                                        <td style="width:7%"><span
                                                                class="badge c-b">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 12)
                                                        <td style="width:7%"><span
                                                                class="badge c-c">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 13)
                                                        <td style="width:7%"><span
                                                                class="badge c-d">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 14)
                                                        <td style="width:7%"><span
                                                                class="badge badge-secondary">{{ $r->rmlevel }}</span>
                                                        </td>
                                                    @elseif($r->level_code == 16)
                                                        <td style="width:7%"><span
                                                                class="badge c-a">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 17)
                                                        <td style="width:7%"><span
                                                                class="badge c-b">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 18)
                                                        <td style="width:7%"><span
                                                                class="badge c-c">{{ $r->rmlevel }}</span></td>
                                                    @elseif($r->level_code == 19)
                                                        <td style="width:7%"><span
                                                                class="badge c-d">{{ $r->rmlevel }}</span></td>
                                                    @else
                                                        <td style="width:7%"><span
                                                                class="badge badge-secondary">ไม่ได้ลงข้อมูล</span></td>
                                                    @endif

                                                    @if ($r->system_code == 1)
                                                        <td style="width:6%"><span
                                                                class="badge badge-warning">{{ $r->system_name }}</span>
                                                        </td>
                                                    @elseif($r->system_code == 2)
                                                        <td style="width:6%"><span
                                                                class="badge badge-success">{{ $r->system_name }}</span>
                                                        </td>
                                                    @else
                                                        <td style="width:6%"><span
                                                                class="badge badge-secondary">{{ $r->system_name }}</span>
                                                        </td>
                                                    @endif

                                                    <td style="width:10%"><a
                                                            href="{{ action('ManagerrmController@detail', $r->rmmain_id) }}"
                                                            class=" btn btn-primary btn-block btn-sm">รายละเอียด</a></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#รหัส</th>

                                                <th>หัวข้อเหตุการณ์</th>
                                                <th>หน่วยงาน</th>
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
    </div>
@endsection
