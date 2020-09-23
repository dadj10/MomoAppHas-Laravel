<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Créer une nouvelle instance de contrôleur.
     *
     * Ce controller est accessible uniquement en se connctant.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::user()->role->name);
        // Je recupere tous les utilisateurs, de role inferieur
        $users = User::all()->where('creer_par', Auth::user()->username)
                            ->where('etat', '!=', '-1');

        return view('user.index')->with('users', $users)
                                    ->with('user_nav', 'active');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // je recupere la liste des roles
        $roles = Role::all()->where('id', '>', Auth::user()->role_id);

        return view('user.create')->with('roles', $roles)
                                    ->with('user_nav', 'active');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->isMethod('POST'))
        {
            // Form validation
            $validator = $this->validate($request, [
                // 'name' => 'required',
                'username' => 'required|max:15',
                'role_id'=>'required',
                'password' => 'required',
                'password_confirmation' => 'required',
            ]);

            // Je recherche le username poster
            $where = User::where('username', '=', "$request->username")->first();
            // dd($where);

            if (is_null($where))
            {
                if ($request->password == $request->password_confirmation)
                {
                    $options = array(
                        'name' => $request->name,
                        'username' => $request->username,
                        'password' => Hash::make($request->password),
                        'creer_par' => Auth::user()->username,
                        'role_id' => $request->role_id,
                    );
                    //  Store data in database
                    $user = User::create($options);

                    if ($user)
                    {
                        return redirect()->route('users.index')->with('success', 'Utilisateur a bien été crée');
                    }
                    else
                    {
                        return back()->with('warning', 'Une erreur s\'est produite, veuillez reessayer.');
                    }
                }
                else
                {
                    return back()->with('warning', 'Mot de passe non conforme');
                }
            }
            else
            {
                return back()->with('warning', 'Le username "'.$request->username.'" est déja utilié');
            }
            // return back()->with('success', 'L\'utilisateur a bien été crée.');
        }
        else
        {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Je recherche le username poster
        return User::where('id', $id)->firstOrFail();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        // je recupere la liste des roles
        $roles = Role::all()->where('id', '>', Auth::user()->role_id)
                            ->where('etat', '!=', 1);

        return view('user.update')->with('user', $user)
                                  ->with('roles', $roles)
                                  ->with('user_nav', 'active');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($request->isMethod('PATCH'))
        {
            // Je recherche le username poster
            $user = $this->show($request->id);

            if (!is_null($user))
            {
                $status = TRUE;

                $user->name = $request->name;
                $user->role_id = $request->role_id;

                if ($request->password)
                {
                    if ($request->password == $request->password_confirmation)
                    {
                        $user->password = Hash::make($request->password);
                    }
                    else
                    {
                        $status = FALSE;
                    }
                }

                if($status)
                {
                    //  Store data in database
                    $user = $user->save();

                    if($user)
                        return redirect()->route('users.index')->with('success', 'Utilisateur a bien été modifié.');
                    else
                        return back()->with('warning', 'Une erreur s\'est ptoduite, veuillez reessayer.');
                }
                else
                {
                    return back()->with('warning', 'Mot de passe non conforme.');
                }
            }
            else
            {
                return back();
            }
        }
        else
        {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->etat = -1;

        if($user->save())
            return redirect()->route('users.index')->with('success', 'Utilisateur a bien été supprimé.');
        else
            return back()->with('warning', 'Une erreur s\'est ptoduite, veuillez reessayer.');
    }
}
