<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Tweet;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tweets = Tweet::getAllOrderByUpdated_at();
        return response()->view('tweet.index', compact('tweets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('tweet.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // バリデーション
        $validator = Validator::make($request->all(), [
            'tweet' => 'required | max:191',
            'description' => 'required',
        ]);

        // バリデーションエラー
        if ($validator->fails()) {
            return redirect()
                ->route('tweet.create')
                ->withInput()
                ->withErrors($validator);
        }

        $result = Tweet::create($request->all());
        return redirect()->route('tweet.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tweet = Tweet::find($id);
        return response()->view('tweet.show', compact('tweet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tweet = Tweet::find($id);
        return response()->view('tweet.edit', compact('tweet'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //バリデーション
        $validator = Validator::make($request->all(), [
            'tweet' => 'required | max:191' ,
            'description' => 'required',
        ]);

        // バリデーションエラー
        if ($validator->fails()) {
            return redirect()
                ->route('tweet.edit', $id)
                ->withInput()
                ->withErrors($validator);
        }

        // データ更新処理
        $result = Tweet::find($id)->update($request->all());
        return redirect()->route('tweet.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Tweet::find($id)->delete();
        return redirect()->route('tweet.index');
    }
}
