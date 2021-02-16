<?php

use Illuminate\Support\Facades\Route;

Route::get('/about','AboutController@index')->name('about');
Route::get('', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login-auth','Auth\LoginController@login')->name('login-auth');
Auth::routes();

Route::group(['middleware' => ['user']], function () {

    //หน้าหลัก
    Route::get('/home', 'HomeController@index')->name('home');

    //ลงทะเบียน
    Route::get('/regrm', 'RegisterrmComtroller@index')->name('regrm');
    Route::post('/regrm-add', 'RegisterrmComtroller@store')->name('regrm-add');

    //จัดการความเสี่ยง
    Route::get('/managerrm', 'ManagerrmController@index')->name('managerrm');
    Route::get('/managerrm/getdate', 'ManagerrmController@getdate')->name('managerrm_getdate');
    Route::get('/managerrm/detail/{id}', 'ManagerrmController@detail')->name('managerrm_detail');
    Route::get('/managerrm/detail/view/frmupdate/{id}', 'ManagerrmController@frmupdate')->name('managerrm_frmupdate_view');

    //pdf ปริ้นใบความเสี่ยง
    Route::get('/rm/print/{id}','PrintrmController@printrm')->name('print-rm-select');
    Route::get('/pdf/view','PrintrmController@index')->name('print-rm-loadview');


    Route::post('/managerrm/detail/review', 'ManagerrmController@review')->name('managerrm_review');
    Route::post('/managerrm/detail/view/update', 'ManagerrmController@updaterm')->name('managerrm_update_rm');

    //Report
    Route::get('/rm/report','ReportController@index')->name('report');
    Route::get('/rm/report/pointdep','ReportController@view_report_getpointdep')->name('getpointdep');
    //pdf รายงานความเสี่ยง
    Route::get('/rm/report/pdf/allrm','PrintrmController@report_all_summary_rm')->name('report_all_summary_rm');
    Route::get('/rm/report/pdf/deprm','PrintrmController@report_dep_summary_rm')->name('report_dep_summary_rm');



    //Report Chart
    Route::get('/rm/getdep','ReportController@Getdep')->name('api.getdep');

    //LOG
    Route::post('/log/cancel-rm', 'LogrmController@log_cancel_rm')->name('log_cancel_rm'); //การยกเลิก Rm
});

Route::group(['middleware' => ['admin']], function () {

    //บุคลากรในระบบ
    Route::get('/person', 'PersonController@index')->name('person');
    Route::get('/person/frmperson/{id}', 'PersonController@get_person')->name('person-get');
    Route::post('/person/add', 'PersonController@add')->name('person-add');
    Route::post('/person/update', 'PersonController@update')->name('person-update');

    //ผู้มีสิทธิ์ใช้งานระบบ
    Route::get('/user', 'UserController@index')->name('user-all');

    Route::get('/user/frmedit/{id}','UserController@frmedit')->name('frmedit');
    Route::get('/user/frmsubmit/{id}','UserController@frmsubmit')->name('frmsubmit');

    Route::post('/user/submit', 'UserController@submit')->name('user-submit');

    Route::post('/user/cancel', 'UserController@cancel')->name('user-cancel');
    Route::post('/user/unblock', 'UserController@unblock')->name('user-unblock');
    Route::post('/user/block', 'UserController@block')->name('user-block');
    
    Route::post('/user/edit', 'UserController@edit')->name('user-edit');

    //ตั้งค่ารหัสความเสี่ยง
    Route::get('/rmcode','RmcodeController@index')->name('rmcode');

        //ฟอร์มแก้ไข
        Route::get('/rmcode/edit/source/{id}','RmcodeController@frmsource')->name('rmfrmsource');
        Route::get('/rmcode/edit/dep/{id}','RmcodeController@frmdep')->name('rmfrmdep');
        Route::get('/rmcode/edit/affected/{id}','RmcodeController@frmaffected')->name('rmfrmaffected');
        Route::get('/rmcode/edit/frmeffect/{id}','RmcodeController@frmeffect')->name('rmfrmeffect');
        Route::get('/rmcode/edit/frmspecd/{id}','RmcodeController@frmspecd')->name('rmfrmspecd');
        Route::get('/rmcode/edit/frmclinic/{id}','RmcodeController@frmclinic')->name('rmfrmclinic');
        Route::get('/rmcode/edit/frmriskcode/{id}','RmcodeController@frmriskcode')->name('rmfrmriskcode');
        Route::get('/rmcode/edit/frmcommittee/{id}','RmcodeController@frmcommittee')->name('rmfrmcommittee');
        Route::get('/rmcode/edit/frmsrpdep/{id}','RmcodeController@frmsrpdep')->name('rmfrmsrpdep');
        Route::get('/rmcode/edit/frmsrpaffected/{id}','RmcodeController@frmsrpaffected')->name('rmfrmsrpaffected');
        Route::get('/rmcode/edit/frmsrpriskcode/{id}','RmcodeController@frmsrpriskcode')->name('rmfrmsrpriskcode');


        //action edit
        Route::post('/rmcode/edit/source/','RmcodeController@editsource')->name('rmeditsource');
        Route::post('/rmcode/edit/dep/','RmcodeController@editdep')->name('rmeditdep');
        Route::post('/rmcode/edit/affected/','RmcodeController@editaffected')->name('rmeditaffected');
        Route::post('/rmcode/edit/effect/','RmcodeController@editeffect')->name('rmediteffect');
        Route::post('/rmcode/edit/specd/','RmcodeController@editspecd')->name('rmeditspecd');
        Route::post('/rmcode/edit/clinic/','RmcodeController@editclinic')->name('rmeditclinic');
        Route::post('/rmcode/edit/riskcode/','RmcodeController@editriskcode')->name('rmeditriskcode');
        Route::post('/rmcode/edit/committee/','RmcodeController@editcommittee')->name('rmeditcommittee');
        Route::post('/rmcode/edit/srpdep/','RmcodeController@editsrpdep')->name('rmeditsrpdep');
        Route::post('/rmcode/edit/srpaffected/','RmcodeController@editsrpaffected')->name('rmeditsrpaffected');
        Route::post('/rmcode/edit/srpriskcode/','RmcodeController@editsrpriskcode')->name('rmeditsrpriskcode');



        //action edit code สรพ.

        //action add
        Route::post('/rmcode/add/source/','RmcodeController@addsource')->name('rmaddsource');
        Route::post('/rmcode/add/dep/','RmcodeController@adddep')->name('rmadddep');
        Route::post('/rmcode/add/affected/','RmcodeController@addaffected')->name('rmaddaffected');
        Route::post('/rmcode/add/effect/','RmcodeController@addeffect')->name('rmaddeffect');
        Route::post('/rmcode/add/specd/','RmcodeController@addspecd')->name('rmaddspecd');
        Route::post('/rmcode/add/clinic/','RmcodeController@addclinic')->name('rmaddclinic');
        Route::post('/rmcode/add/riskcode/','RmcodeController@addriskcode')->name('rmaddriskcode');
        Route::post('/rmcode/add/committee/','RmcodeController@addcommittee')->name('rmaddcommittee');
        Route::post('/rmcode/add/srpdep/','RmcodeController@addsrpdep')->name('rmaddsrpdep');
        Route::post('/rmcode/add/srpaffected/','RmcodeController@addsrpaffected')->name('rmaddsrpaffected');
        Route::post('/rmcode/add/srpaddsrpriskcode/','RmcodeController@addsrpriskcode')->name('rmaddsrpriskcode');


        //frmview manage
        Route::get('/rmcode/manage/affected','RmcodeController@view_manager_affected')->name('m_affected');
        Route::get('/rmcode/manage/clinic','RmcodeController@view_manager_clinic')->name('m_clinic');
        Route::get('/rmcode/manage/committee','RmcodeController@view_manager_committee')->name('m_committee');
        Route::get('/rmcode/manage/dep','RmcodeController@view_manager_dep')->name('m_dep');
        Route::get('/rmcode/manage/effect','RmcodeController@view_manager_effect')->name('m_effect');
        Route::get('/rmcode/manage/riskcode','RmcodeController@view_manager_riskcode')->name('m_riskcode');
        Route::get('/rmcode/manage/source','RmcodeController@view_manager_source')->name('m_source');
        Route::get('/rmcode/manage/specd','RmcodeController@view_manager_specd')->name('m_specd');
        Route::get('/rmcode/manage/srpdep','RmcodeController@view_manager_srpdep')->name('m_srpdep');
        Route::get('/rmcode/manage/srpaffected','RmcodeController@view_manager_srpaffected')->name('m_srpaffected');
        Route::get('/rmcode/manage/srpriskcode','RmcodeController@view_manager_srpriskcode')->name('m_srpriskcode');


});

