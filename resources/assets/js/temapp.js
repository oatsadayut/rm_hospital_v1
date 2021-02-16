/** Samitra & ICE.CN Risk 2020**/

// select2 ID tag
$(document).ready(function() {
    $('#sel-source').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm1').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm2').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm3').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm4').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm5').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm6').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm7').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm8').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm9').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm10').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm11').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm12').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm13').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm14').select2({
        theme: 'bootstrap4',
    });
    $('#sel-rm15').select2({
        theme: 'bootstrap4',
    });

    $('#sel-20').select2({
        theme: 'bootstrap4',
    });
    $('#sel-21').select2({
        theme: 'bootstrap4',
    });
    $('#sel-22').select2({
        theme: 'bootstrap4',
    });
    $('#sel-24').select2({
        theme: 'bootstrap4',
    });
    $('#sel-25').select2({
        theme: 'bootstrap4',
    });
    $('#sel-26').select2({
        theme: 'bootstrap4',
    });
    $('#sel-27').select2({
        theme: 'bootstrap4',
    });
    $('#sel-28').select2({
        theme: 'bootstrap4',
    });
    $('#sel-29').select2({
        theme: 'bootstrap4',
    });
    $('#sel-30').select2({
        theme: 'bootstrap4',
    });
    $('#sel-31').select2({
        theme: 'bootstrap4',
    });
    $('#sel-32').select2({
        theme: 'bootstrap4',
    });
    $('#sel-33').select2({
        theme: 'bootstrap4',
    });
    $('#sel-34').select2({
        theme: 'bootstrap4',
    });
    $('#tebal-1').DataTable({
        "order": [[ 2, "desc" ]]
    });
    $('#tebal-person').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-user1').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-user2').DataTable({
        "order": [[ 0, "asc" ]]
    });

    $('#tebal-setting1').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting2').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting3').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting4').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting5').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting6').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting7').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting8').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting9').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting10').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting11').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting12').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting13').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting14').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting15').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting16').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting17').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting18').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting19').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting20').DataTable({
        "order": [[ 0, "asc" ]]
    });
    $('#tebal-setting21').DataTable({
        "order": [[ 0, "asc" ]]
    });
});



$('#rm_date').change(function(){
    let val = $(this).val()
    let date = new Date(val);
    $("#date_show").empty();
    $("#date_show").append("วันที่ " + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)))  + '/' + date.getFullYear() );
})

$('#rm_time').change(function(){
    let val = $(this).val()
    $("#time_show").empty();
    $("#time_show").append("เวลา " + val );
    let val_part = document.getElementById("part_show_hidden");

    let t = val.split(':');
    let h = t[0];
    let m = t[1];
    let timeint = Number(h+m)

    if((timeint >= 800) && (timeint <= 1600)){
        $("#part_show").empty();
        $("#part_show").append(" (เวรเช้า)");
        val_part.value = "เช้า"
    }
    if((timeint >= 1601) && (timeint <= 2359)){
        $("#part_show").empty();
        $("#part_show").append(" (เวรบ่าย)");
        val_part.value = "บ่าย"
    }
    if((timeint >= 1) && (timeint <= 759) || (timeint == 0)){
        $("#part_show").empty();
        $("#part_show").append(" (เวรดึก)");
        val_part.value = "ดึก"
    }
})

$('#sel-rm11').change(function(){
    let val = $(this).val()
    let d_sex = document.getElementById("d_rm_sex");
    let d_age = document.getElementById("d_rm_age");

    let sex = document.getElementById("sel-rm12");
    let age = document.getElementById("rm_affected_age");

    if (val == 1) {
        d_sex.style.display = "block";
        d_age.style.display = "block";
    }else {
        d_sex.style.display = "none";
        d_age.style.display = "none";
        sex.value = "";
        age.value = "";
    }
});

$('#rm_date').ready(function(){
    let val = document.getElementById("rm_date").value
    let date = new Date(val);
    $("#date_show").empty();
    if(val.length != 0){
        $("#date_show").append("วันที่ " + ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date.getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1)))  + '/' + date.getFullYear() );
    }
})

$('#rm_time').ready(function(){
    let val = document.getElementById("rm_time").value
    $("#time_show").empty();
    if(val.length != 0){
        $("#time_show").append("เวลา " + val );
    }
    let val_part = document.getElementById("part_show_hidden");

    let t = val.split(':');
    let h = t[0];
    let m = t[1];
    let timeint = Number(h+m)

    if((timeint >= 800) && (timeint <= 1600)){
        $("#part_show").empty();
        $("#part_show").append(" (เวรเช้า)");
        val_part.value = "เช้า"
    }
    if((timeint >= 1601) && (timeint <= 2359)){
        $("#part_show").empty();
        $("#part_show").append(" (เวรบ่าย)");
        val_part.value = "บ่าย"
    }
    if((timeint >= 1) && (timeint <= 759) || (timeint == 0)){
        $("#part_show").empty();
        $("#part_show").append(" (เวรดึก)");
        val_part.value = "ดึก"
    }
})

$('#sel-rm11').ready(function(){
    let val = document.getElementById("sel-rm11").value
    let d_sex = document.getElementById("d_rm_sex");
    let d_age = document.getElementById("d_rm_age");

    let sex = document.getElementById("sel-rm12");
    let age = document.getElementById("rm_affected_age");

    if (val == 1) {
        d_sex.style.display = "block";
        d_age.style.display = "block";
    }else {
        d_sex.style.display = "none";
        d_age.style.display = "none";
        sex.value = "";
        age.value = "";
    }
});
