<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
   public function  __construct()
   {
       $this->middleware(['permission:users_read'])->only('index');
       $this->middleware(['permission:users_create'])->only('create');
       $this->middleware(['permission:users_update'])->only('update');
       $this->middleware(['permission:users_edit'])->only('edit')->except(['role:admin']);
       $this->middleware(['permission:users_delete'])->only('destroy');
   }
    public function index(Request $request)
    {
        $users = User::whereRoleIs('admin')->when($request->search, function ($query) use($request){
            return $query->where('name','like','%' .$request->search . '%')
                ->orWhere('email','like' , '%' . $request->search . '%');
        })->paginate(10);

        return view('dashboard.users.index',compact('users'));
    } // End of Index


    public function create()
    {
        return view('dashboard.users.create');
    } // End of create

    public function store(Request $request)
    {
            $request->validate([
                'name' => 'required',
                'email' => 'required|unique:users',
            'image' => 'image',
                'password' => 'required|confirmed',
                'permissions' => 'required|min:1'
            ]);

            $request_data = $request->except(['_token','_method','password', 'password_confirmation', 'permissions', 'image']);
            $request_data['password'] = bcrypt($request->password);


        if ($request->image) {

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_image/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of if

            $user = User::create($request_data);
            $user->attachRole('admin');
            $user->syncPermissions($request->permissions);
        session()->flash('success', __('site.added_successfully'));
            return redirect()->route('dashboard.users.index');




    } // End of store


    public function edit( User $user)
    {



        return view('dashboard.users.edit',compact('user'));
    }

    public function update(Request $request, User $user)
    {
//        return $request;
        $request->validate([
            'name' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($user->id),],
            'image' => 'image',
            'permissions' => 'required|min:1'
        ]);

        $request_data = $request->except(['permissions', 'image','_token','_method']);

        if ($request->image) {

            if ($user->image != 'default.png') {

                Storage::disk('uploads')->delete('/user_image/' . $user->image);

            }//end of inner if

            Image::make($request->image)
                ->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })
                ->save(public_path('uploads/user_image/' . $request->image->hashName()));

            $request_data['image'] = $request->image->hashName();

        }//end of external if

        $user->update($request_data);

        $user->syncPermissions($request->permissions);
//        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function destroy(User $user)
    {
        if($user->image != 'avatar5.png'){
            Storage::disk('uploads')->delete('/user_image/' .$user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }
}
