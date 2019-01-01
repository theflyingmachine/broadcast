<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Broadcast;
use App\Member;
use File;
use Session;

class BroadcastController extends Controller
{

    public function broadcaststaging(Request $request){
        if($request->session()->get('login')){
        $request->broadcastTemplate->store('broadcastTemplate');
        $ids = $request->input('id');
        $title=$request->input('title');

        //vaildate if nay member is selected
        if((count($ids)) == 0){
        echo '<script type="text/javascript">alert("We cant broadcast to ghosts");</script>';
        // return (count($ids));
        return redirect('newbroadcast'); 
        }
        
        //get has file name
        $hashFilename = $request->broadcastTemplate->hashName();
        $openFilename = "app/broadcastTemplate/";
        $openFilename .= $hashFilename;
        //read file from disk
        $templateContent  = File::get(storage_path($openFilename));
        //put file name in session
        $request->session()->put('templatefilename',$hashFilename); 


        $users = Member::whereIn('id', $ids)->get();
        // DO all the personalzation
        foreach ($users as $user){
        $personalizedTemplate = $templateContent;
        $Name = ucwords(strtolower($user->name));
        $token = $this->generateRandomString();
        //name
        $personalizedTemplate = str_replace("[myName]",$Name, $personalizedTemplate);
        //first name
        $fName=strtok($Name, " ");
        $personalizedTemplate = str_replace("[myfName]",$fName, $personalizedTemplate);
        //email
        $personalizedTemplate = str_replace("[myEmail]",$user->email, $personalizedTemplate);
        //mobile
        $personalizedTemplate = str_replace("[myNumber]",$user->mobile, $personalizedTemplate);
        //token
        $personalizedTemplate = str_replace("[myToken]",$token, $personalizedTemplate);
        $user['token'] =  $token;
        $user['template'] = $personalizedTemplate;
        $user['title'] = $title;
        $request->session()->push('broadcast',$user);
        }
        
        
        return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);
         }else
        return redirect('login'); 
    }


    public function broadcast(Request $request){
        if($request->session()->get('login')){
            $broadcastinit=false;
           
            $broadcastpermission = $request->input('broadcastpermission');
        if ($broadcastpermission=="525bc1c0751a58ea8d9ef774a9a59e91"){
            echo "Permission verified";
            $templatefilename=$request->session()->get('templatefilename');  
            $bdate = date('Y-m-d H:i:s');
            $broadcastinit=true;
        }
        $ids = $request->session()->get('broadcast');
        $request->session()->put('broadcast',false);
        ini_set('max_execution_time', 0); // to get unlimited php script execution time
        
            $request->session()->put('progress',0);
            $total = count($ids);
            $x = 0;
           
            for($i=$request->session()->get('progress');$i<$total;$i++)
            {
                $percent = intval($i/($total-$x) * 100)."%"; 
                $x = 1;  
                $request->session()->put('progress',$i);
                echo '<script>
                parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
                parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed. '.($i+1).' of '.$total.' records. Broadcasting: '.$ids[$i]['name'].'</div>";</script>';
                $request->session()->put('progress',$i);
                
                
               // sleep(1); // Here call your time taking function like sending bulk sms etc.
               usleep( 250 * 1000 );
                $broadcast = new Broadcast;
                //Extract Variables
                $sub = $ids[$i]['title'];
                $msg = $ids[$i]['template'];
                $toemail = $ids[$i]['email'];
                $token = $ids[$i]['token'];
                
               
                if ($broadcastinit){
            //insert to database
                $broadcast->b_id = $bdate ." - Email - ". $sub;
                $broadcast->token = $token;
                $broadcast->send_to = $toemail;
                $broadcast->status = "pending";
                // $broadcast->content = "It saew";
                $broadcast->content = $templatefilename;
                $broadcast->save();
               // sleep(1);
               usleep( 250 * 1000 );
            //Shoot Email
		$headers = "From: Eric Abraham <cyberboy.inc@gmail.com>" . "\r\n" .
		'Reply-To: ericabraham.ea@gmail.com' . "\r\n" .
		'Content-type: text/html' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();
       
        mail($toemail,$sub,$msg,$headers);
        usleep( 250 * 1000 );
                }
                
                
                ob_flush(); 
                flush(); 
            }

            echo '<script>parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">Process completed</div>"</script>';

            $request->session()->put('progress',false);
                    
                    return "Done";    
                    // return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);
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


       // Funcutions which will be used by this script
   public function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
	}
    
    

    //SMS broadcaststaging
    public function smsbroadcaststaging(Request $request){
        if($request->session()->get('login')){
       
        $ids = $request->input('id');
        $title=$request->input('title');
        $smstext=$request->input('smstext');

        //vaildate if nay member is selected
        if((count($ids)) == 0){
        echo '<script type="text/javascript">alert("We cant broadcast to ghosts");</script>';
         //return (count($ids));
        return redirect('smsnewbroadcast'); 
        }
        
        $users = Member::whereIn('id', $ids)->get();
        // DO all the personalzation
        foreach ($users as $user){
        $personalizedTemplate = $smstext;
        $Name = ucwords(strtolower($user->name));
        $token = $this->generateRandomString();
        //name
        $personalizedTemplate = str_replace("[myName]",$Name, $personalizedTemplate);
        //first name
        $fName=strtok($Name, " ");
        $personalizedTemplate = str_replace("[myfName]",$fName, $personalizedTemplate);
        //email
        $personalizedTemplate = str_replace("[myEmail]",$user->email, $personalizedTemplate);
        //mobile
        $personalizedTemplate = str_replace("[myNumber]",$user->mobile, $personalizedTemplate);
        //token
        $personalizedTemplate = str_replace("[myToken]",$token, $personalizedTemplate);
        $user['token'] =  $token;
        $user['template'] = $personalizedTemplate;
        $user['title'] = $title;
        $request->session()->push('broadcast',$user);
        }
        
        
        return view('pages.smsbroadcastlaunchpad')->with('allbroadcasts',$users);
         }else
        return redirect('login'); 
    }


    //Broadcast sms
    public function smsbroadcast(Request $request){
        if($request->session()->get('login')){
            $broadcastinit=false;

    
            $broadcastpermission = $request->input('broadcastpermission');
        if ($broadcastpermission=="525bc1c0751a58ea8d9ef774a9a59e91"){
            echo "Permission verified"; 
            $bdate = date('Y-m-d H:i:s');
            $broadcastinit=true;
        }
        $ids = $request->session()->get('broadcast');
        $request->session()->put('broadcast',false);
        ini_set('max_execution_time', 0); // to get unlimited php script execution time
        
            $request->session()->put('progress',0);
            $total = count($ids);
            $x = 0;
           
            for($i=$request->session()->get('progress');$i<$total;$i++)
            {
                $percent = intval($i/($total-$x) * 100)."%"; 
                $x = 1;  
                $request->session()->put('progress',$i);
                echo '<script>
                parent.document.getElementById("progressbar").innerHTML="<div style=\"width:'.$percent.';background:linear-gradient(to bottom, rgba(125,126,125,1) 0%,rgba(14,14,14,1) 100%); ;height:35px;\">&nbsp;</div>";
                parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">'.$percent.' is processed. '.($i+1).' of '.$total.' records. Broadcasting: '.$ids[$i]['name'].'</div>";</script>';
                $request->session()->put('progress',$i);
                
                
              //  sleep(1); // Here call your time taking function like sending bulk sms etc.
              usleep( 250 * 1000 );
                $broadcast = new Broadcast;
                //Extract Variables
                $sub = $ids[$i]['title'];
                $msg = $ids[$i]['template'];
                $tomobile = $ids[$i]['mobile'];
                $token = $ids[$i]['token'];
                
               
                if ($broadcastinit){
            //insert to database 
                $broadcast->b_id = $bdate ." - SMS - ". $sub;
                $broadcast->token = $token;
                $broadcast->send_to = $tomobile;
                $broadcast->status = "pending";
                $broadcast->content = $msg;
                $broadcast->save();
                //sleep(1);
                usleep( 250 * 1000 );
            //Shoot SMS
        
            $url = 'https://cyberboy.in/sms/smsapi.php';
$myvars = 'apikey=9b6c17e81969d43e3a7c8106f5f7da7b&mobile=' . $tomobile. '&message=' . $msg;

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
//sleep(1);
usleep( 250 * 1000 );
                }
                
                
                ob_flush(); 
                flush(); 
            }

            echo '<script>parent.document.getElementById("information").innerHTML="<div style=\"text-align:center; font-weight:bold\">Process completed</div>"</script>';

            $request->session()->put('progress',false);
                    
                    return "Done";    
                    // return view('pages.broadcastlaunchpad')->with('allbroadcasts',$users);
                    }else
                    return redirect('login'); 
        }

}
