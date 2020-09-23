<?php

namespace App\Http\Controllers;

use App\Client;
use App\Ressource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use response;

class RessourceController extends Controller
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
        $ressources = Ressource::all()->where('etat', '!=', '-1');
        return view('ressource.index')->with('ressources', $ressources)
                                        ->with('ress_nav', 'active');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all()->where('etat', '!=', '-1');

        return view('ressource.create')->with('clients', $clients)
                                        ->with('ress_nav', 'active');
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
            $options = array(
                'name' => $request->name,
                'description' => $request->description,
                'detail' => $request->detail,

                'creer_par' => Auth::user()->username,
                'client_id' => $request->client_id,
            );
            // dd($request->detail);

            //  Store data in database
            if (Ressource::create($options))
            {
                return redirect()->route('ressource.index')
                                    ->with('success', 'Ressource a bien été crée');
            }
            else
            {
                return back()->with('warning', 'Une erreur s\'est produite, veuillez reessayer.');
            }
        }
        else
        {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function show(Ressource $ressource)
    {
        return view('ressource.detail')->with('ressource', $ressource)
                                        ->with('ress_nav', 'active');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function edit(Ressource $ressource)
    {
        $clients = Client::all()->where('etat', '!=', '-1');

        return view('ressource.update')->with('ressource', $ressource)
                                       ->with('clients', $clients)
                                       ->with('ress_nav', 'active');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ressource $ressource)
    {
        if ($request->isMethod('PATCH'))
        {
            $ressource->client_id = $request->client_id;
            $ressource->name = $request->name;
            $ressource->description = $request->description;
            $ressource->detail = $request->detail;

            if($ressource->save())
                return redirect()->route('ressource.index')->with('success', 'Ressource a bien été modifié.');
            else
                return back()->with('warning', 'Une erreur s\'est ptoduite, veuillez reessayer.');
        }
        else
        {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ressource $ressource)
    {
        $ressource->etat = -1;

        if($ressource->save())
            return redirect()->route('ressource.index')->with('success', 'Ressource a bien été supprimée.');
        else
            return back()->with('warning', 'Une erreur s\'est ptoduite, veuillez reessayer.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ressource  $ressource
     * @return \Illuminate\Http\Response
     */
    public function etat(Ressource $ressource)
    {
        if ($ressource->etat == 1){
            $ressource->etat = 0;
            $etat = "Desactivée.";
        }else {
            $ressource->etat = 1;
            $etat = "Activée.";
        }

        if($ressource->save())
            return redirect()->route('ressource.index')->with('success', 'Ressource a bien été '.$etat);
        else
            return back()->with('warning', 'Une erreur s\'est ptoduite, veuillez reessayer.');
    }

    public  function sendMail(Request $request)
    {
        return response()->json($request);
        # code...
    }
}
