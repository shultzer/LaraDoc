<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Completter extends Model {

    protected $fillable = [
      'number',
      'date',
      'doc',
      'company',
      'volume',
      'reason',
      'user_id'
    ];

    public function spaletters() {

      return $this->belongsTo('App\Spaletter');

    }
    public function users(){

      return $this->belongsTo('App\User');

    }
    public function propertys(){

      return $this->belongsToMany('App\Property');

    }
  }
