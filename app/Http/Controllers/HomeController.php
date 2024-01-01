<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\dffsdata;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
         // Get the user ID if the user is logged in
       $userId = Auth::id();
    
       $ipfsFiles = dffsdata::where('userId', $userId)->get();

     return view('home', ['ipfsFiles' => $ipfsFiles, 'userId' => $userId]);

    }
}
