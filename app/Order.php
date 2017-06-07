<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Order extends Model {

    protected $fillable = [
      'number',
      'date',
      'doc',
      'spaletter_id'
    ];
    public function spaletters() {

      return $this->hasMany('App\Spaletter');

    }

    public function reports() {

      return $this->belongsToMany('App\Report');

    }
  }
