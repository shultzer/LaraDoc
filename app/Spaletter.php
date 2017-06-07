<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Spaletter extends Model
{
  protected $fillable = [
    'number',
    'date',
    'doc',
    'comletter_id'
  ];
    public function completters(){

      return $this->hasMany( 'App\Completter' );

    }
  public function orders(){

    return $this->belongsTo( 'App\Order' );

  }

}
