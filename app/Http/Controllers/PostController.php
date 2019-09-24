<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use App\Category;
use App\Like;
use App\Dislike;
use App\Post;
use Illuminate\Support\Facades\Auth;
use App\Comment;
use App\Profile;
use DB;
class PostController extends Controller
{
    public function post()
    { $categories= Category::all();
    	
    	return view('posts.post',['categories'=>$categories]);
    }
    /////////////////////// Add Post
    public function addPost(Request $request)
    {
    	# code...
$this->validate($request,
    		['post_title'=>'required',
    		'post_body'=>'required',
    		'category_id'=>'required',
    		'post_image'=>'required'
    	]);
$post=new Post;
    	$post->post_title=$request->input('post_title');
    	$post->category_id=$request->input('category_id');
    	$post->user_id= Auth::user()->id;
    	$post->post_body=$request->input('post_body');
    	if(Input::hasFile('post_image')){
    		$file=Input::file('post_image');
    		$file->move(public_path().'/posts/',$file->getClientOriginalName());
    		$url=URL::to("/").'/posts/'.$file->getClientOriginalName(); 
    		  	}
    	$post->post_image=$url;
    	$post->save();
    	return redirect("/home")->with('response','Post Published Successfully');    
    }
/////////////////// View Post    
public function view($post_id){
$categories= Category::all();
//////Like
$likePost=Post::find($post_id);
$likeCtr=Like::where(['post_id'=>$likePost->id])->count();
//////DisLike
$dislikePost=Post::find($post_id);
$dislikeCtr=Dislike::where(['post_id'=>$dislikePost->id])->count();
$posts=Post::where('id','=',$post_id)->get();

///Comment
  $comments= DB::table('users')
            ->join('comments', 'users.id', '=', 'comments.user_id')
            ->join('posts','comments.post_id','=','posts.id')
            ->select('users.name', 'comments.*')
            ->where(['posts.id'=>$post_id])
            ->get();
            

return view('posts.view',['posts'=>$posts,'categories'=>$categories,'likeCtr'=>$likeCtr,'dislikeCtr'=>$dislikeCtr,'comments'=>$comments]);

}
public function edit($post_id){
$categories=Category::all();
$posts=Post::find($post_id);
$category=Category::find($posts->category_id);
return view('posts.edit',['categories'=>$categories,'posts'=>$posts,'category'=>$category]);
}
////////////////////Edit Post
public function editPost(Request $request,$post_id){
# code...
$this->validate($request,
    		['post_title'=>'required',
    		'post_body'=>'required',
    		'category_id'=>'required',
    		'post_image'=>'required'
    	]);
$post=new Post;
    	$post->post_title=$request->input('post_title');
    	$post->category_id=$request->input('category_id');
    	$post->user_id= Auth::user()->id;
    	$post->post_body=$request->input('post_body');
    	if(Input::hasFile('post_image')){
    		$file=Input::file('post_image');
    		$file->move(public_path().'/posts/',$file->getClientOriginalName());
    		$url=URL::to("/").'/posts/'.$file->getClientOriginalName(); 
    		  	}
    	$post->post_image=$url;
    	$data=array(
    		'post_title'=>$post->post_title,
    		'user_id'=>$post->user_id,
    		'category_id'=>$post->category_id,
    		'post_body'=>$post->post_body,
    		'post_image'=>$post->post_image
    	);
    	Post::where('id',$post_id)->update($data);
    	$post->update();
    	return redirect("/home")->with('response','Post Updated Successfully');  
}

//////////////Delete Post
public function deletePost($post_id){
	Post::where('id',$post_id)->delete();
    	
return redirect("/home")->with('response','Post Deleted Successfully');

}
public function category($cat_id){
    $categories=Category::all();
    $posts= DB::table('posts')
            ->join('categories', 'posts.category_id', '=', 'categories.id')
            ->select('posts.*', 'categories.*')
            ->where(['categories.id'=>$cat_id])
            ->paginate(4);

    return view('categories.categoriesposts',['categories'=>$categories,'posts'=>$posts]);

}
////////////Like Function
public function like($id){
$loggedin_user=Auth::user()->id;
$like_user=Like::where(['user_id'=>$loggedin_user,'post_id'=>$id])->first();
if(empty($like_user->user_id)){
    $user_id=Auth::user()->id;
    $email=Auth::user()->email;
    $post_id=$id;
    $like=new Like;
    $like->user_id=$user_id;
    $like->email=$email;
    $like->post_id=$post_id;
    $like->save();
    return redirect("/view/{$id}");
}
else{
    return redirect("/view/{$id}");
}
}
////////////Dislike Function
public function dislike($id){
$loggedin_user=Auth::user()->id;
$dislike=Dislike::where(['user_id'=>$loggedin_user,'post_id'=>$id])->first();
if(empty($dislike_user->user_id)){
    $user_id=Auth::user()->id;
    $email=Auth::user()->email;
    $post_id=$id;
    $dislike=new Dislike;
    $dislike->user_id=$user_id;
    $dislike->email=$email;
    $dislike->post_id=$post_id;
    $dislike->save();
    return redirect("/view/{$id}");
}
else{
    return redirect("/view/{$id}");
}
}
//////COMMENT POST
public function comment(Request $request,$post_id){
# code...
$this->validate($request,
            ['comment'=>'required']);

    $comment= new Comment;
        $comment->user_id=Auth::user()->id;
         $comment->post_id=$post_id;
        $comment->comment=$request->input('comment');
       
      
$comment->save();
  return redirect("/view/{$post_id}")->with('response','Comment Added Successfully'); 
}

public function search1(Request $request){
   $user_id=Auth::user()->id;
$profile=Profile::find($user_id);

$profile= DB::table('profiles')
        ->select('name','designation','profile_pic')
        ->where(['profiles.user_id'=>$user_id])->first();
$keyword=$request->input('search');
$posts= Post::where('post_title','LIKE','%'.$keyword.'%')->get();
return view('posts.searchposts',['posts'=>$posts,'profile'=>$profile]);
}
}