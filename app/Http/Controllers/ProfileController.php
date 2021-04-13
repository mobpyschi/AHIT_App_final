<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile');
    }
    public function update_avatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time().'.' .$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/images/users/').$filename);

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
            return view('profile');
        }
        return 'false';
    }
}
