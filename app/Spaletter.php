<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spaletter extends Model
{
  protected $fillable = [
    'number',
    'date',
    'doc',
    'order_id'
  ];
    public function completters(){

      return $this->hasMany( 'App\Completter' );

    }
    public function  users(){

      return $this->belongsTo('App\User');
    }
  public function orders(){

    return $this->belongsTo( 'App\Order' );

  }

}
