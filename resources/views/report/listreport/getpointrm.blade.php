@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center px-3 pb-3 pt-3 mb-3 border-bottom bg-white">
    <span>HOME > รายงาน > สถานที่เกิดเหตุ</span>
</div>
<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <canvas id="getdep" width="400" height="100"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script >
    var url = "{{url('/rm/getdep')}}";
    var dep = new Array();
    var count = new Array();
    $(document).ready(function(){
        $.get(url, function(res){
            res.forEach(function(res_data){
                    dep.push(res_data.dep_name);
                    count.push(res_data.count);
            });
            var ctx = document.getElementById("getdep").getContext('2d');
                var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',
                        // The data for our dataset
                        data: {
                            labels: dep,
                            datasets: [{
                                    label: 'จำนวนเหตุการณ์',
                                    data:count,
                                    backgroundColor: 'rgb(125, 214, 250)',
                                    borderColor: 'rgb(125, 214, 250)',
                            }]
                        },
                        options: {}
            });
        });
    });
</script>
@endsection
