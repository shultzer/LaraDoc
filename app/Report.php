<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Report extends Model {
    protected $fillable = [
      'number',
      'date',
      'doc'
    ];
    public function orders() {

      return $this->belongsToMany('App\Order');

    }
  }
