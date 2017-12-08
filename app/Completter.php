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
          'owner',
          'user_id',
          'spaletter_id',
        ];

        public function orders () {

            return $this->belongsTo('App\Order', 'order_id');

        }

        public function spaletters () {

            return $this->belongsTo('App\Spaletter');

        }

        public function users () {

            return $this->belongsTo('App\User');

        }

        public function propertys () {

            return $this->belongsToMany('App\Property');
        }

        public function reports () {

            return $this->belongsTo('App\Report', 'report_id');
        }

        public function complettersWhithoutspaletter () {
            return $this->whereIn('spaletters_id', [
                          NULL,
                          0,
                        ])->latest('created_at')->take(5)->get();
        }
    }
