<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     */
    public function index()
    {
        return Redirect::route('profile.my');
//        $u = Auth::user();
//        if( $u->hasRole('financial')){
//            return Redirect::route('profile.my');
//        } else if( $u->hasRole('seller')){
//            return Redirect::route('requests.my');
//        } else {
//            return Redirect::route('requests.wait_separations');
//        }
    }
}
