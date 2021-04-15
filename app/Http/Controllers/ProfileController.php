<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;
use Image;
use Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $detailUser = UserDetail::where('user_id',Auth::user()->id)->get();
        return view('profiles.index',compact('detailUser'));
    }
    public function update_avatar(Request $request)
    {
        if($request->hasFile('avatar')){
            $avatar = $request->file('avatar');
            $filename = time().'.' .$avatar->getClientOriginalExtension();
            Image::make($avatar)->resize(300,300)->save(public_path('/images/users/').$filename);
            $detailUser = UserDetail::where('user_id',Auth::user()->id)->get();

            $user = Auth::user();
            $user->avatar = $filename;
            $user->save();
            return view('profile',compact('detailUser'));
        }
        return 'false';
    }
    public function updateinfo(Request $request, $id)
    {
        
        request()->validate([
            'Name' => 'required',
            'Sex' => 'required',
            'Date_of_birth' => 'required',
            'Certificate' => 'required',
            'Address' => 'required',
            'Phone' => 'numeric',
            ]);
            $input = $request->all();
            // dd($input);
            $detailUser = UserDetail::where('user_id',$id)->first();
            
            $detailUser->update($input);
            return redirect()->route('profiles.update')->with('success', 'Product updated successfully');
    }
}