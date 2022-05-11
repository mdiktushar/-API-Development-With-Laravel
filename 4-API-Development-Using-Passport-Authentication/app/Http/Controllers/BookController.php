<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        
        return response()->json(
            [
                'message' => 'book list',
                'data' => $books
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookRequest $request)
    {
        //
        User::findOrFail(auth()->user()->id)->book()->create($request->all());

        return response()->json(
            [
                'message' => 'book created'
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $book = Book::findOrFail($id);
        return response()->json(
            [
                'message' => 'book info',
                'book' => $book
            ],
            200
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookRequest $request, $id)
    {
        $user = User::findOrFail(auth()->user()->id);
        $book = Book::findOrFail($id);
        if ($book->user_id != auth()->user()->id) {
            return response()->json(
                [
                    'message' => 'Unauthorized'
                ],
                401
            );
        }
        $user->book()->update($request->all());
        return response()->json(
            [
                'message' => 'book updated'
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail(auth()->user()->id);
        $book = Book::findOrFail($id);
        if ($book->user_id != auth()->user()->id) {
            return response()->json(
                [
                    'message' => 'Unauthorized'
                ],
                401
            );
        }
        $user->book()->delete();
        return response()->json(
            [
                'message' => 'book deleted'
            ],
            200
        );
    }
}
