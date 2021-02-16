<!-- รายงานภาพรวมความเสี่ยง ระดับโรงพยาบาล -->
<div class="modal fade" id="printallrm" tabindex="-1" aria-labelledby="printallrmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="printallrmLabel">เลือกช่วงเวลา</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('report_all_summary_rm')}}" method="get">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="date_start">วันที่เริ่มต้น</label>
                        <input type="date" name="date_start" id="date_start" class=" form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_start">ถึงวันที่</label>
                        <input type="date" name="date_end" id="date_end" class=" form-control" required>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Export PDF</button>
            </div>
        </form>
        </div>
    </div>
</div>


<!-- รายงานภาพรวมความเสี่ยง ระดับโรงพยาบาล -->
<div class="modal fade" id="printdeprm" tabindex="-1" aria-labelledby="printdeprmLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="printdeprmLabel">เลือกหน่วยงาน - ช่วงเวลา</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="{{route('report_dep_summary_rm')}}" method="get">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label for="dep">เลือกหน่วยงาน</label>
                        <select id="sel-24" name="dep" class="form-control" required>
                            @foreach ($dep as $r)
                                <option value="{{$r->dep_code}}" selected>[{{$r->dep_ename}}] : {{$r->dep_name}}</option>
                            @endforeach
                        </select>
                        <hr>
                    </div>

                    <div class="col-md-6">
                        <label for="date_start">วันที่เริ่มต้น</label>
                        <input type="date" name="date_start" id="date_start" class=" form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label for="date_start">ถึงวันที่</label>
                        <input type="date" name="date_end" id="date_end" class=" form-control" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Export PDF</button>
            </div>
        </form>
        </div>
    </div>
</div>
