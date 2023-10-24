<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        request()->query('id') ? $id = request()->query('id') : $id = null ;
        $allblogs = Blog::orderBy("updated_at",'desc')->get();
        $blogs = array();
        foreach($allblogs as $blog){
            if ($id) {
                $user = User::find($blog->user_id);
                $isLiked = false ;
                foreach($blog->likes as $like){
                    if ($like->user_id == $id) {
                        $isLiked = true ;
                    }
                }
                array_push($blogs,["data"=>$blog,"user"=>$user , "isLiked" => $isLiked , "count" => count($blog->likes)]);
            } else {
                $user = User::find($blog->user_id);
                array_push($blogs,["data"=>$blog,"user"=>$user]);
            }
        }
        return response()->json([
            "blogs" => $blogs
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(),[
                'title' => 'required|string',
                'body' => 'required|string',
                'user_id' => 'required|integer',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    "status" => false ,
                    "errors" => $validator->errors()
                ],400);
            }
    
            $validatedDataBlog = $validator->validate();
    
            $blog = Blog::create([
                'title' => $validatedDataBlog['title'],
                'body' => $validatedDataBlog['body'],
                'user_id' => $validatedDataBlog['user_id'],
            ]);
    
            return response()->json([
                "message" => "Blog Created Seccessfully",
                "blog" => $blog,
            ],201) ;
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false ,
                "errors" => $th->getMessage()
            ],500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        try {
            $validator = Validator::make($request->all(),[
                'title' => 'string',
                'body' => 'string',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    "status" => false ,
                    "errors" => $validator->errors()
                ],400);
            }
    
            $validatedDataBlog = $validator->validate();
    
            $blog->title = $validatedDataBlog['title'] ;
            $blog->body = $validatedDataBlog['body'];
            $blog->save();
            
            return response()->json([
                "message" => "Blog Updated Seccessfully",
                "blog" => $blog,
            ],200) ;

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false ,
                "errors" => $th->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            if ($blog) {
                $blog->delete();
                return response()->json([
                    "status" => true,
                    "message" => "Blog deleted Successfuly"
                ]);
            } 
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false ,
                "errors" => $th->getMessage()
            ],500);
        }
    }
}
