<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Completter extends Model {

    protected $fillable = [
      'number',
      'date',
      'doc',
      'company',
      'property',
      'volume',
      'reason',
    ];

    public function spaletters() {

      return $this->belongsTo('App\Spaletter');

    }
    public function users(){

      $this->belongsTo('App\User');

    }
    public function propertys(){

      $this->belongsToMany('App\Property');

    }
  }
