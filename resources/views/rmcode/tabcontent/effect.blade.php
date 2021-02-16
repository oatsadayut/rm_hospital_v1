{{-- Modal --}}

<!-- Modal -->
<div class="modal fade" id="modaladdeffect" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">เพิ่มผลกระทบ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form method="POST" action="{{route('rmaddeffect')}}">
                @csrf

                <div class="modal-body">
                    <div class="form-row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="effect_name">ชื่อ</label>
                                <input type="text" class="form-control" id="effect_name" name="effect_name" placeholder="กรุณากรอก ชื่อผลกระทบ" required>
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

<div class=" row">
    <div class="col-md-6">
        <h5>ตั้งค่าผลกระทบ</h5>
    </div>
    <div class="col-md-6 text-right">
        <a href="/rmcode/manage/effect" class=" btn btn-warning btn-sm text-dark"><i class="fas fa-tasks"></i> จัดการข้อมูล</a>
    </div>
</div>

<hr>
<div>
    <table id="tebal-setting4" class="table table-sm table-hover">
        <thead class="thead-light ">
          <tr>
            <th scope="col">รหัส</th>
            <th scope="col">ชื่อ</th>
            <th scope="col">สถานะ</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($effect as $r)
                <tr>
                    <th scope="row">{{$r->effect_code}}</th>
                    <td>{{$r->effect_name}}</td>
                    <td>
                        @if ($r->status != '' || $r->status != null)
                            @if ($r->status == 'Y')
                            <span class="badge badge-success">{{$r->status}} ใช้งาน</span>
                            @else
                            <span class="badge badge-danger">{{$r->status}} ยกเลิก</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
      </table>
</div>
