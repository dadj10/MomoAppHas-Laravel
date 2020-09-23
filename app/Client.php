<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'raison_sociale', 'sigle', 'contact', 'creer_par',
    ];

    public function ressource()
    {
        return $this->hasMany('App\Ressource');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
