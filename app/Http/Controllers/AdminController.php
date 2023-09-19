<?php

namespace App\Http\Controllers;

use App\Mail\AdminWelcomeEmail;
use App\Models\Admin;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
// use Str;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //SELECT * FROM admins;
        $admins = Admin::with('roles')->get();
        return response()->view('cms.admins.index', ['admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = Role::where('guard_name', '=', 'admin')->get();
        $cities = City::where('active', '=', true)->get();
        return response()->view('cms.admins.create', ['cities' => $cities, 'roles' => $roles]);
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
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'name' => 'required|string|min:3',
            'email' => 'required|string|unique:admins,email',
            'active' => 'required|boolean',
        ]);

        if (!$validator->fails()) {
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $password = Str::password(10);
            $admin->password = Hash::make($password);
            $admin->city_id = $request->input('city_id');
            $admin->active = $request->input('active');
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->assignRole($request->input('role_id'));
                // Mail::to([$admin])->send(new AdminWelcomeEmail($admin, $password));
            }
            return response()->json([
                'message' => $isSaved ? 'Saved successfully' : 'Save failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
        $cities = City::Where('active', '=', true)->get();
        $roles = Role::where('guard_name', '=', 'admin')->get();
        $currentRole = $admin->roles[0];
        return response()->view('cms.admins.edit', ['admin' => $admin, 'cities' => $cities, 'roles' => $roles, 'currentRole' => $currentRole]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $validator = Validator($request->all(), [
            'role_id' => 'required|numeric|exists:roles,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'active' => 'required|boolean',
        ]);

        if (!$validator->fails()) {
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->active = $request->input('active');
            $admin->city_id = $request->input('city_id');
            $isSaved = $admin->save();
            if ($isSaved) {
                $admin->syncRoles(Role::findById($request->input('role_id'), 'admin'));
            }
            return response()->json(
                ['message' => $isSaved ? 'Saved successfully' : 'Save failed!'],
                $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        $deleted = $admin->delete();
        return response()->json([
            'icon' => $deleted ? 'success' : 'error',
            'title' => $deleted ? 'Deleted successfully' : 'Delete failed!',
            'message' => $deleted ? 'Item deleted permenantly' : 'Item delete failed!'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}

// <!-- <?php

// namespace App\Http\Controllers;

// use App\Models\Admin;
// use Illuminate\Http\Request;

// class AdminController extends Controller
// {
//     // public function __construct() {
//     //     $this->middleware('auth:admin');
//     // }
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         //
//     }

//     /**
//      * Show the form for creating a new resource.
//      */
//     public function create()
//     {
//         //
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(Request $request)
//     {
//         //
//     }

//     /**
//      * Display the specified resource.
//      */
//     public function show(Admin $admin)
//     {
//         //
//     }

//     /**
//      * Show the form for editing the specified resource.
//      */
//     public function edit(Admin $admin)
//     {
//         //
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(Request $request, Admin $admin)
//     {
//         //
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(Admin $admin)
//     {
//         //
//     }
// } -->
