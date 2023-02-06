<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json($users);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            "email" => 'required',
            "username" => 'required',
            "password" => 'required',
            "firstname" => 'required',
            "lastname" => 'required',
        ]);
        User::create($validatedData);
        $data = array('data' => 'success', 'status' => 200);
        return response()->json($data);
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
                'email' => 'required|max:255',
                'username' => 'required|max:255',
                'password' => 'required|max:255',
                'firstname' => 'required|max:255',
                'lastname' => 'required|max:255',
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
            $item = User::findOrFail($id);
            
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
            $item = User::find($id);
           
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
