<?php

namespace App\Http\Controllers;
use Response;
use Illuminate\Http\Request;
use App\Post;
use App\UserLog;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        echo "sojib";
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function getPost()
    {
        //
       // echo "sojib";

        $post = Post::all();

//  dd($post);
// exit();
        foreach ($post as $item){
            $listCircular[]=[
              
                'title' =>$item->title,
                'details' =>$item->details,
            ];

                //echo $item->title;
               //  echo $item->details;
        }

         //dd($listCircular);
        // exit();

          if(count($listCircular)>0){
            $arr['status'] = 1;
            $arr["message"] = "Circular found!";
            $arr["circular"] = $listCircular;
       
            return Response::json($arr);
        } else {
            $arr['status'] = 0;
            $arr["message"] = "Circular not found!";
            return Response::json($arr);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        //

    }

 /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request){

        $input = $request->all();
// echo "string";
// dd($input );
// exit();
        $user = new User();
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
   $saved = $user->save();
       if($saved){
           $oauth_token = 'fhgfhgf';
           $oauth_token = base64_encode(md5($oauth_token));


           $userLog = new UserLog();
           $userLog->oauth_token = $oauth_token;
           $userLog->user_id = 1;
           $userLog->login_date = date("Y-m-d H:i:s");
           $userLog->is_loggedin = 1;

           if ($userLog->save()) {
               $this->arr["status"] = 1;
               $this->arr["message"] = "login success.";
               $this->arr["oauth_token"] = $oauth_token;
               $this->arr["data"] = $saved;
               return Response::json($this->arr);
           }

       }else {
           $this->arr["status"] = 1;
           $this->arr["message"] = "Something went wrong. Please try again !";
           return Response::json($this->arr);
       }
   }
      
      //  $saved = $user->save();
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
    
            $post = new Post();
         
            $post->title = $data['title'];
            $post->details = $data['details'];
          
            $saved = $post->save();
            if($saved){
                $this->arr['status'] = 1;
                $this->arr["message"] = "Post created!";
                return Response::json($this->arr);
            } else {
                $this->arr['status'] = 0;
                $this->arr["message"] = "something went wrong!";
                return Response::json($this->arr);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
