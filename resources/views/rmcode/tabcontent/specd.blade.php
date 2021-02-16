<div class=" row">
    <div class="col-md-6">
        <h5>ตั้งค่าโรคเฉพาะ</h5>
    </div>
    <div class="col-md-6 text-right">
        <a href="/rmcode/manage/specd" class=" btn btn-warning btn-sm text-dark"><i class="fas fa-tasks"></i> จัดการข้อมูล</a>
    </div>
</div>
<hr>
<div>
    <table id="tebal-setting5" class="table table-sm table-hover">
        <thead class="thead-light ">
          <tr>
            <th scope="col">รหัส</th>
            <th scope="col">ชื่อ</th>
            <th scope="col">สถานะ</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($specd as $r)
                <tr>
                    <th scope="row">{{$r->specd_code}}</th>
                    <td>{{$r->specd_name}}</td>
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
