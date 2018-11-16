<?php

namespace App\Http\Controllers\API;

use App\Models\Consumer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConsumersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Consumer::all()) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4|max:40',
            'age' => 'required|integer|between: 14,99',
            'city' => 'required|in:Sofia,Varna,Plovdiv',
        ]);


        $consumer = new Consumer();
        $consumer->name = $request->input('name');
        $consumer->age = $request->input('age');
        $consumer->city = $request->input('city');

        if( $consumer->save()){
            return response()->json(['errors' => false, 'message' => "The record was successfully saved." , 'id' => $consumer->id] );
        }
        return response()->json(['errors' => true, 'message' => "There is some error, please try again latter."] , 422);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'min:4|max:40',
            'age' => 'integer|between: 14,99',
            'city' => 'in:Sofia,Varna,Plovdiv',
        ]);


        $consumer = Consumer::find($id);
        if($consumer){

            foreach ($request->all() as $key => $param){
                if(in_array($key , Consumer::$fields)){
                    if($consumer->{$key} != $param){
                        $consumer->{$key} = $param;
                    }

                }
            }

            if($consumer->isDirty() && $consumer->save()){
                return response()->json(['errors' => false, 'message' => "The record was successfully updated."]);
            }
        }

        return response()->json(['errors' => true, 'message' => "The record doesn't exist or there isn't any change to be saved."] , 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $consumer = Consumer::find($id);
        if($consumer && $consumer->delete()){
            return response()->json(['errors' => false, 'message' => "The record was successfully removed."]);
        }
        return response()->json(['errors' => true, 'message' => "There is some error, please try again latter."] , 422);
    }
}
