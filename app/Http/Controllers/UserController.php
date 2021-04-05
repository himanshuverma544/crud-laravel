<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
// use Exception;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    function create(Request $request) {

        $request->validate([
            'name' => "required|string|regex:/^[a-zA-Z ']+$/u|max:50",
            'email' => 'required|string|email|max:70|unique:users',
            'contact_no' => 'required|string|regex:/^[0-9]+$/u|min:10|max:10|unique:users',
            'address' => "required|string|regex:/^[a-zA-Z0-9 ,']+$/u|max:255",
        ]);
            // 'unique:users,email_address,',

        if($request->hasFile('image')) {
        $request->validate([
            'image' => 'mimes:jpg,jepg,png,gif,svg|max:5048'
        ]);     
        $request->file('image')->store('public/uploads'); // $request->file('image')->store('uploads', 'public');  
        }

        $user = new User;
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->contact_no = $request->contact_no;
        $user->address = $request->address;
        if($request->hasFile('image')) {
            $user->image = $request->file('image')->hashName();
        }
        $user->save();

        return redirect('dashboard')->with('success','Record Added Successfully.');
    }

    function delete(Request $request) {

        $user = User::find($request->id);

        $imagePath = public_path().'/storage/uploads/'.$user->image;

        if(file_exists($imagePath)) {
            unlink($imagePath);
        }    
        $user->delete();
        
        return redirect('dashboard')->with('success','Record Deleted Successfully.');
    }

    function showData($id) {

        $user = User::find($id);
        return view('create_update',['data'=>$user]);
    }

    function update(Request $request) {

        $request->validate([
            'name' => "required|string|regex:/^[a-zA-Z ']+$/u|max:50",
            'email' => 'required|string|email|max:70|'.Rule::unique('users')->ignore($request->id),
            'contact_no' => 'required|string|regex:/^[0-9]+$/u|min:10|max:10|'.Rule::unique('users')->ignore($request->id),
            'address' => "required|string|regex:/^[a-zA-Z0-9 ,']+$/u|max:255",
        ]);
        // Rule::unique('users')->ignore($request->id, 'id')
        
        if($request->hasFile('image')) {
            $request->validate([
                'image' => 'mimes:jpg,jepg,png,gif,svg|max:5048'
            ]);     
            $request->file('image')->store('public/uploads');
        }

        $user = User::find($request->id);
        
        $user->name = $request->name;
        $user->email = $request->email; 
        $user->contact_no = $request->contact_no;
        $user->address = $request->address;

        $imagePath = public_path().'/storage/uploads/'.$user->image;

        if(file_exists($imagePath) && $user->image != null) {
            unlink($imagePath);
        }    
        if($request->hasFile('image')) {
            $user->image = $request->file('image')->hashName();
        }
        // try {
        $user->save();
        return redirect()->route('dashboard')->with('success','Record Updated Successfully.');
        // }
        // catch(Exception $e) {
        //   //  return back()->with('update_failed',"The email has already been taken.");
        // }
    }
    
    function show() {

        // $data = User::all();
         $data = User::orderBy('id','DESC')->paginate(5);   // $data = User::orderBy('id','DESC')->get();

        return view('dashboard',['users'=>$data]);
    }
}
