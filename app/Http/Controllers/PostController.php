<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){

        // select * from posts

        $postsFromDB = Post::all(); // collection object
        //dd($postsFromDB);
       
        return view('posts.index',['posts'=>$postsFromDB]);
    }

    // convention over configuration 
    public function show(Post $post) { // type hinting -----> handle not found too

        // select * from posts where id = $postId limit 1;

        // $singlePostFromDB = Post::find($postId); // model object
        //dd($post);
        //$singlePostFromDB = Post::findOrFail($postId); // model object -----> display 404 page where ths element == null

        // if(is_null($singlePostFromDB)){
        //     return to_route('posts.index');
        // }

        //$singlePostFromDB = Post::where('id',$postId)->first(); // model object -----> the best way without conflict

        // $singlePostFromDB = Post::where('id',$postId)->get(); // collection object
        
        // Post::where('title','PHP')->first() // select * from posts where title = 'php' limit 1;

        // Post::where('title','PHP')->get() // select * from posts where title = 'php';

        // dd($singlePostFromDB);

        // return view('posts.show',['post'=>$singlePostFromDB]);
        return view('posts.show',['post'=>$post]);
    }

    public function create(){

        // select * from users
        $uesrFromDB = User::all();
        //dd($uesrFromDB);
        return view('posts.create',['users'=>$uesrFromDB]);
    }

    public function store(){

        request()->validate([
            'title' => ['required','min:3'],
            'description' => ['required','min:5'],
            'post_creator' => ['required','exists:users,id'],
        ]);
        // get the user data 

        //$request = request();
        //dd($request->title,$request->all());
            $data = request()->all();
            $title = request()->title;
            $description = request()->description;
            $postCreator= request()->post_creator;
            $image= request()->image;

        //    dd($data,$title,$description,$postCreator,$image);

        // store the user data in database

        // $post = new Post;

        // $post->title = request()->title;
        // $post->description = request()->description;
        // $post->post_creator = request()->post_creator;
        // $post->image = request()->image;

        // $post->save(); // insert into posts
        Post::create([
            'title'=>$title,
            'description'=>$description,
            'user_id'=>$postCreator,
            'image'=>$image,
        ]);

        // redirection to posts.index
        return to_route('posts.index');
    }

    public function edit($postId){

                $singlePostDB = Post::find($postId);
                // select * from users
                $uesrFromDB = User::all();
                
                return view('posts.edit',['post'=>$singlePostDB,'users'=>$uesrFromDB]);
    }

    public function update($postId){
       // get the user data 

        $data = request()->all();
        $title = request()->title;
        $description = request()->description;
        $image = request()->image;
        $postCreator= request()->post_creator;
        $singlePostDB = Post::find($postId);
        $singlePostDB->update(
            [
                'title'=>$title,
                'description'=>$description,
                'image'=>$image,
                'user_id'=>$postCreator,
            ]
        );
       //dd($data,$title,$description,$postCreator);

    // update the user data in database

    // redirection to posts.show
    return to_route('posts.show',$postId);
    }

    public function destroy($postId){
        // delete post from database

        $post = Post::find($postId);
        $post->delete();
        // return to index

        return to_route('posts.index');
    }

    public function uploadImage()
{   
    $request = request();
    // التحقق من صحة الملف
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5 ميجابايت
    ]);

    // رفع الصورة وتعيين اسم مميز لها
    $image = $request->file('file');
    $imageName = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
    $image->move(public_path('uploads'), $imageName);

    // إعادة اسم الصورة للمستخدم
    return response()->json(['image' => $imageName]);
}

}
