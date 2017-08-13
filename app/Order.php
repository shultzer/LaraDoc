<?php

  namespace App;

  use Illuminate\Database\Eloquent\Model;

  class Order extends Model {

    protected $fillable = [
      'number',
      'date',
      'doc',
      'user_id'
    ];
    public function completters() {

      return $this->hasMany('App\Completter');

    }
    public function spaletters() {

      return $this->hasMany('App\Spaletter');

    }
    public function users(){

      return $this->belongsTo('App\User');

    }
    public function reports() {

      return $this->belongsToMany('App\Report', 'order_report', 'order_id','report_id');

    }
  }
