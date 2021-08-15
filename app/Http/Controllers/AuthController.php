<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $data)
    {
        try {
            $validator = Validator::make($data->all(), [
                'user_username' => 'required',
                'password' => 'required',
                'user_role_id'=>'required',
            ]);
            if ($validator->fails()){
                throw new \Exception($validator->errors()->first());
            }
            $param = [
                [
                    'name'     => 'user_username',
                    'contents' => $data->user_username
                ],
                [
                    'name'     => 'password',
                    'contents' => $data->password
                ],
                [
                    'name'  => 'user_role_id',
                    'contents'   => $data->user_role_id
                ]
            ];
            
            $result = $this->send_request_backend(config('endpoint.END_POINT_LOGIN'), $param, 'POST');

            if(!$result->success){
                throw new \Exception($result->message);
            }

            $data->session()->put('authenticated', time());
            $data->session()->put('token_apps', $result->data->token);
            $data->session()->put('data_user', $result->data->data_user);
            $data->session()->put('additional_data_user', $result->data->additional_data_user);

            $res = [
                'url' => route('wkwkPage')
            ];

            return $this->success_response("Berhasil Mengubah Data Karyawan", $res, $data->all());
        } catch (\Exception $e) {
            return $this->failed_response($e->getMessage());
        }
    }

    public function wkwkPage(Request $request)
    {
        dd(session()->all());
    }

    public function logout()
    {
        request()->session()->regenerate(true);
        request()->session()->flush();
        return redirect()->route('/');
    }

    public function loginPage(Request $request)
    {
        $result = $this->send_request_backend(config('endpoint.END_POINT_LIST_ROLE'), [], 'GET');
        if(!$result->success){
            throw new \Exception($result->message);
        }
        $this->list_role = $result->data->list_role;

        return $this->view('auth.login', ['list_role']);
    }
}
