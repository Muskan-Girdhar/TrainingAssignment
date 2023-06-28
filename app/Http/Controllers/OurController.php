<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Http\Requests\UserpostRequest;
use Illuminate\Http\Request;
use lluminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Mail\welcomeEmail;

use Illuminate\Support\Facades\Mail;
use Hash;

class OurController extends Controller
{ 
  public function home(Request $request)
  {
    
    $users=DB::table('posts')->where('posttype','=','post')->get();
      return view('Home',['users' => $users]);
  }

    public function loginget()
    {
      return view('Login');
    }

    public function registrationget()
    {
      return view('Registration');
    }

    public function addpostget()
    {
      return view('Addpost');
    }

    public function dashboard()        
{
//     $value = session('loginId');
// echo $value;
    
if(session()->has('loginId'))
{
    $data=user::where('id','=',session()->get('loginId'))->first();
}

    
    // echo $data;
    $users=DB::table('posts')->where('posttype','=','post')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
  
    
}
public function logout()
{
    if(session()->has('loginId'))
    {
        session()->pull('loginId');
        return redirect('login');
    }
} 

    public function loginpost(Request $request)
    {
        $this->validate($request,[
            
             'email'=>'required',
             'password'=>'required',
          ]);
    

    $myusers=user::where('email','=',$request->email)->first();
    if($myusers)
   {
    if(Hash::check($request->password,$myusers->password))
    {
        $request->session()->put('loginId',$myusers->id);
        return redirect('dashboard');
    }
    else{
        return back()->with('fail','the password is wrong');;
    }
   }
   else
           {
            return back()->with('fail','this email is not registered');
           }
    }

    public function registrationpost(Request $request)
    {
      $this->validate($request,[
        'name'=>'required|min:5|max:20|string',
         'email'=>'bail|required|email|unique:users,email',
         'password'=>'required|min:5|max:12',
      ]);

    DB::table('users')->insert([
        'name'=>$request->name,
        'email' =>$request->email ,
        'password'=> Hash::make($request->password),
        'created_at'=>now(),
        'updated_at'=>now(),
    ]);

       $myusers=DB::table('users')->where('email','=',$request->email)->first();
       $request->session()->put('loginId',$myusers->id);
      return redirect('dashboard');
    }
   
    public function addpost(Request $request)
    {
     $validator =Validator::make($request->all(),[
           'description'=>'required|min:5|max:500',
            'tittle'=>'required|min:5|max:50',
            'file'=>'required|mimes:jpeg,bmp,png,mp4,mp3,gif',
            'coursetype'=>'required|in:dance,singing,publicSpeaking',
            'postingtype'=>'required|in:draft|post',
      ]);
         $file = $request->file;
        $filename = time().'.'.$file->getClientOriginalExtension();
        $request->file->move('assets',$filename);
      
      DB::table('posts')->insert([
        'tittle'=>$request->tittle,
        'description' =>$request->description ,
        'file' => $filename,
        'coursetype' =>$request->coursetype,
        'posttype'=>$request->postingtype,
        'user_id'=> $request->session()->get('loginId'),
        'created_at'=>now(),
        'updated_at'=>now(),
    ]);
    return redirect('dashboard');  
    }

    public function email(Request $request)
    {
     
        $emailData=[
            'subject'=>'Welcome to my blog site',
            'body'=>'you can here upload and see others posts',
        ];
        $to = [
          [
              'email' => 'muskangirdhar345@gmail.com', 
              'name' => 'Muskan',
          ]
      ];
      //Mail::to($to)
        Mail::to($to)->send(new welcomeEmail($emailData));

    }

    public function userdataget(Request $request)
    {
      $myid=session()->get('loginId');
      $users=DB::table('posts')->where('posttype','=','post')->where('user_id','=',$myid)->orderBy('updated_at','DESC')->get();
      return view('userdata',['users' => $users]);
  
    }
    public function all(Request $request)
    {

      $users=DB::table('posts')->where('posttype','=','post')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
  
    }

  public function dance(Request $request)
    {
       
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','dance')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
  
    }
    public function singing(Request $request)
    {
       
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','singing')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
  
    }
    public function publicspeaking(Request $request)
    {
       
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','publicSpeaking')->orderBy('updated_at','DESC')->get();
      return view('Home',['users' => $users]);
  
    }
    public function userall(Request $request)
    {
      if(session()->has('loginId'))
{
    $data=user::where('id','=',session()->get('loginId'))->first();
}
      $users=DB::table('posts')->where('posttype','=','post')->orderBy('updated_at','DESC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
  
    }

  public function userdance(Request $request)
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','dance')->orderBy('updated_at', 'ASC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
  
    }
    public function usersinging(Request $request)
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','singing')->orderBy('updated_at', 'DESC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
  
    }
    public function userpublicspeaking(Request $request)
    {
      if(session()->has('loginId'))
      {
          $data=user::where('id','=',session()->get('loginId'))->first();
      }
      $users=DB::table('posts')->where('posttype','=','post')->where('coursetype','=','publicSpeaking')->orderBy('updated_at', 'DESC')->get();
      return view('Dashboard',['users' => $users,'data'=>$data]);
  
    }

    public function yourpost(Request $request)
    {
      $myid=session()->get('loginId');
      $users=DB::table('posts')->where('posttype','=','post')->where('user_id','=',$myid)->orderBy('updated_at', 'DESC')->get();
      return view('userdata',['users' => $users]);
  
    }
    public function yourdraft(Request $request)
    {
      $myid=session()->get('loginId');
      $users=DB::table('posts')->where('posttype','=','draft')->where('user_id','=',$myid)->orderBy('updated_at', 'DESC')->get();
      return view('userdata',['users' => $users]);
  
    }
}
