<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(session('data_user')->user_username);
        return $this->view('home', []);
    }

    public function resetPassword()
    {
        return view('resetPassword');
    }

    public function aktivasiAkun()
    {
        return view('aktivasiAkun');
    }
}
