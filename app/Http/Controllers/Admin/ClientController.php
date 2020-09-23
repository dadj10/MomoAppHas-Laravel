<?php

namespace App\Http\Controllers\Admin;

use App\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
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
        //
        $clients = Client::all()->where('etat', '!=', '-1');
        return view('client.index')->with('clients', $clients)
                                    ->with('client_nav', 'active');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('client.create')->with('client_nav', 'active');
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
                'raison_sociale' => 'required|max:50',
                'contact'=>'required',
            ]);

            // Je recherche le username poster
            $where = Client::where('raison_sociale', '=', "$request->raison_sociale")->first();

            if (!$where)
            {
                $options = array(
                    'raison_sociale' => $request->raison_sociale,
                    'sigle' => $request->sigle,
                    'contact' => $request->contact,
                    'creer_par' => Auth::user()->username,
                );
                // dd($options);

                //  Store data in database
                if (Client::create($options))
                {
                    return redirect()->route('clients.index')->with('success', 'Client a bien été crée');
                }
                else
                {
                    return back()->with('warning', 'Une erreur s\'est produite, veuillez reessayer.');
                }
            }
            else
            {
                return back()->with('warning', 'Le client "'.$request->raison_sociale.'" est déja enregistré');
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
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Client::where('id', $id)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        // dd($client);
        return view('client.update')->with('client', $client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        if ($request->isMethod('PATCH'))
        {
            // Form validation
            $validator = $this->validate($request, [
                'raison_sociale' => 'required|max:50',
                'contact'=>'required',
            ]);

            $status = TRUE;

            if ($request->raison_sociale != $client->raison_sociale)
            {
                $where = Client::where('raison_sociale', $request->raison_sociale)->first();

                if ($where)
                    $status = FALSE;
                else
                    $status = TRUE;
            }

            if ($status)
            {
                $client->raison_sociale = $request->raison_sociale;
                $client->sigle = $request->sigle;
                $client->contact = $request->contact;
                // dd($client->raison_sociale);

                //  Update data in database
                if($client->save())
                    return redirect()->route('clients.index')->with('success', 'Client a bien été modifié.');
                else
                    return back()->with('warning', 'Une erreur s\'est ptoduite, veuillez reessayer.');
            }
            else
            {
                return back()->with('warning', 'Le client "'.$request->raison_sociale.'" est déja enregistré');
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
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        //
    }
}
