<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::with('question','comment')
            ->get();
        //return Inertia::render('Admin/User/UserList')->with(['data'=>$data]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::where('id',$id)->first();
       // return Inertia::render('Admin/User/EditUser')->with('user',$user);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role' => 'required',
        ]);
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];
        if($request->hasFile('newImage')){
            $newFile = $request->file('newImage');
            $newFileName = uniqid().'-'.$newFile->getClientOriginalName();

            //get old file
            $oldFileName = User::where('id',$id)->value('image');
            if(!empty($oldFileName)){
                if(File::exists(public_path().'/uploads/users/'.$oldFileName)){
                    File::delete(public_path().'/uploads/users/'.$oldFileName);
                }
                $newFile->move(public_path().'/uploads/users/',$newFileName);
                $updateData['image'] = $newFileName;
            }else{
                $newFile->move(public_path().'/uploads/users/',$newFileName);
                $updateData['image'] = $newFileName;
            }
        }
        User::where('id',$id)->update($updateData);
        return redirect()->route('admin.userList')->with('message','User Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
