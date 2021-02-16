<?php

namespace App\Http\Controllers\Auth;

use DB;
use Alert;
use App\User;
use App\Person;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new Response('', 201)
                    : redirect($this->redirectPath());
    }
    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'cid' => ['required', 'string', 'max:13'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $cid = $data['cid'];
        $username = $data['username'];

        $q = Person::where('person_cid',$cid)->count();
        $q_user = User::where('cid',$cid)->count();
        $q_username = User::where('username',$username)->count();
        $q_person = Person::where('person_cid',$cid)->get();

        if($q_user == 0){
            if($q_username == 0){
                if($q > 0){
                    Alert::success('บันทึกข้อมูลเรียบร้อย', 'กรุณารอเจ้าหน้าที่อนุมัติการใช้งาน');
                    return User::create([
                        'person_id' => $q_person[0]->person_id,
                        'cid' => $data['cid'],
                        'username' => $data['username'],
                        'password' => Hash::make($data['password']),
                    ]);
                }else{
                    Alert::error('เกิดข้อผิดพลาด', 'เลขบัตรประชาชนนี้ยังไม่ได้ลงทะเบียน (Person CID)');
                    return back();
                }
            }else{
                Alert::error('เกิดข้อผิดพลาด', 'ชื่อผู้ใช้นี้มีในระบบแล้ว (User USERNAME)');
                return back();
            }
        }
        Alert::error('เกิดข้อผิดพลาด', 'เลขบัตรประชาชนนี้ใช้งานไปแล้ว (User CID)');
        return back();

    }
}
