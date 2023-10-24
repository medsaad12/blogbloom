<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function like(Request $request , $blogId , $userId)
    {
        try {
            $like = new Like ;
            $like->blog_id = $blogId;
            $like->user_id = $userId;
            $like->save();

            return response()->json([
                "status" => true,
                "message" => "Blog Liked Successfuly"
            ],200);

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
    public function unlike(Request $request , $blogId , $userId)
    {
       try {
            $like =  Like::where('blog_id', $blogId)->where("user_id" , $userId)->first();
            $like->delete();
            return response()->json([
             "status" => true,
             "message" => "Blog Unlike Successfuly"
            ],200);

       } catch (\Throwable $th) {

            return response()->json([
                'status' => false ,
                "errors" => $th->getMessage()
            ],500);
            
       }
    }
}
