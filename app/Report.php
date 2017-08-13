<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Report extends Model {

    protected $fillable = [
      'number',
      'date',
      'doc',
      'user_id',
    ];

    public function orders() {

      return $this->belongsToMany('App\Order', 'order_report', 'report_id', 'order_id');

    }

    public function completters() {
      return $this->hasMany('App\Completter', 'report_id');
    }
  }
