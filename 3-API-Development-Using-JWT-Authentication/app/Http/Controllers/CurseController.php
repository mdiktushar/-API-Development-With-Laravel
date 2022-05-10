<?php

namespace App\Http\Controllers;

use App\Models\Curses;
use Illuminate\Http\Request;

use App\Models\User;

class CurseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = User::findOrFail(auth()->user()->id);
        $curses = $user->curses;
        return response()->json(["data"=>$curses], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        // Findeing user
        $user = User::findOrFail(auth()->user()->id);
        try {
            //code...
            $user->curses()->create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    "message" => $th
                ],
                406
            );
        }
        #Response
        return response()->json(
            [
                'massage'=>'Information Saved'
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curses  $curses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $data = Curses::findOrFail($id);
        return response()->json($data, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curses  $curses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        $curses = Curses::findOrFail($id);

        if ($curses->user_id != auth()->user()->id) {
            return response()->json(['message'=>'you are not authorised to update this'], 401);
        }
        try {
            //code...
            $curses->update($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    "message" => $th
                ],
                406
            );
        }
        return response()->json(['message'=>"updated"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curses  $curses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $curses = Curses::findOrFail($id);

        if ($curses->user_id != auth()->user()->id) {
            return response()->json(['message'=>'you are not authorised to update this'], 401);
        }
        try {
            //code...
            $curses->delete();
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(
                [
                    "message" => $th
                ],
                406
            );
        }
        return response()->json(["Message"=>"Deleted"], 200);
    }
}
