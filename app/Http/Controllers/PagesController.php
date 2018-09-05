<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Broadcast;
use App\Member;


class PagesController extends Controller
{
    public function index(Request $request){
        if($request->session()->get('login')){
          // return Broadcast::all();
        //$allbroadcasts = Broadcast::all();
        $allbroadcasts = Broadcast::select('b_id')->distinct()->get();
        return view('pages.index')->with('allbroadcasts',$allbroadcasts);
    }else
        return redirect('/login');
    }


    public function about(Request $request){
        // $value= $request->session()->get('login');
        if($request->session()->get('login')){
        return view('pages.about');
          }else{
        return redirect('login');  
          }     
    }


    public function newbroadcast(Request $request){
        if($request->session()->get('login')){
        $allmembers = Member::all();
        return view('pages.newbroadcast')->with('allmembers',$allmembers);;
        }else
        return redirect('login');  
    }

    public function login(Request $request){
        $name = $request->input('p');
        if ($name=="apple"){
        $request->session()->put('login',true);
        // session::put('login', true);
        return redirect('index');
        }else
        return view('pages.login');
    }

    public function logout(Request $request){
        // session_start();
        // $_SESSION['login']=false;
       // $request->session()->flush('login');
        $request->session()->flush();
        return redirect('/login');
        // return redirect()->route('login');
        // return view('pages.login');
    }
}