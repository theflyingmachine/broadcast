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


    public function dataapi(Request $request){
        if($request->session()->get('login')){
        $allmembers = Member::all();
        $count=1;
        $result = '{"data":[';
            foreach ($allmembers as $members){
            if ($count>1)
            $result .= ',';
            $result .= '["'.$members->id. '","'.$members->name.'","'.$members->gender.'","'.$members->mobile.'","'.$members->email.'"]';
            $count+=1;
            }
            $result .= ']}';
            
        return $result;
        
        }else
        return redirect('login');  
    }




    public function broadcaststaging(Request $request){
        if($request->session()->get('login')){
        $ids = $request->input('id');
        // $users="";
        // foreach ($ids as $id){
        //     $users[] = Member::select('*')
        //     ->where('members.id','=', $id)
        //     ->select('members.id','members.name')
        //     ->get();
        // }
        $users = Member::whereIn('id', $ids)->get();
        
        // $users = json_encode($users);
        // return view('pages.broadcastlaunchpad',compact('$users'));;
        return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);;
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