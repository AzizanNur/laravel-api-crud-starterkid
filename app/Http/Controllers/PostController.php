<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Exception;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        echo 'create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([
        //     "title" => 'required|max:255',
        //     "news_content" => 'required|max:255',
        //     "author" => 'required|integer'
        // ]);
        // Post::create($validatedData);
        // $data = array('data' => 'success', 'status' => 200);
        // return response()->json($data);

        try{
            $validator = Validator::make($request->all(), [
                "title" => 'required|max:255',
                "news_content" => 'required|max:255',
                "author" => 'required|integer'
            ]);

            if ($validator->fails()) {
                return redirect('post/create')
                            ->withErrors($validator)
                            ->withInput();
            }

            Post::create($request->all());
            $data = array('data' => 'success', 'status' => 200);
            return response()->json($data);

        }catch(Exception $error){
            return response()->json([
                'message' => 'something is error',
                'error' => $error
            ], 500);    
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
        try {
            // validation input
            $validator = Validator::make( $request->all(),[
                "title" => 'required|max:255',
                "news_content" => 'required|max:255',
                "author" => 'required|integer'
            ]);

            // validation errors
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validator->errors()
                ], 401); 
            }
            
            // find data by id
            $item = Post::findOrFail($id);
            
            // save data
            $item->update($request->all());

            // if success save data
            if ($item) {
            return response()->json([
                'message' => 'Success Updates'
                ],200);
            }  
        } catch (Exception $error) {
            // if error
            return response()->json([
                'message' => 'Something went Wrong!',
                'error' => $error
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            // find data by id
            $item = Post::find($id);
           
            // if response success
            if ($item) {

                // deleted
                $item->delete();
                
                return response()->json([
                    'message' => 'Data Deleted Successfully'
                    ]
                );
            }else{
                return response()->json([
                    'message' => 'Data Empty'
                    ]
                );
            }
        } catch (Exception $error) {
            // if error success
            return response()->json([
                'message' => 'Something went Wrong!',
                'error' => $error
            ], 500);
        }
    }
}
