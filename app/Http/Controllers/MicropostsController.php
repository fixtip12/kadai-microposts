<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Micropost;
use App\User;

class MicropostsController extends Controller
{
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $microposts = $user->feed_microposts()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'microposts' => $microposts,
            ];
        }
        return view('welcome', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->create([
            'content' => $request->content,
        ]);

        return back();
    }

    public function edit(Request $request,$id)
    {
        $micropost = Micropost::find($id);
        $user = \Auth::user();
        if (\Auth::id() === $micropost->user_id) {
            return view('microposts.edit', compact('micropost', 'user'));
        }
        
        return redirect('/');
    }

    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'content' => 'required|max:191',
        ]);

        $request->user()->microposts()->where('id',$id)->update([
            'content' => $request->content,
        ]);

        return redirect('/');
    }

    public function destroy($id)
    {
        $micropost = \App\Micropost::find($id);

        if (\Auth::id() === $micropost->user_id) {
            $micropost->delete();
        }

        return back();
    }
}