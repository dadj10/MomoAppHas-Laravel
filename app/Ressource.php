<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ressource extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'detail', 'creer_par', 'client_id',
    ];

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
