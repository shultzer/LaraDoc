<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Property extends Model {

        protected $table = 'propertys';
        protected $fillable = [
          'name', 'slug'
        ];
        public function completters () {

            return $this->belongsToMany('App\Completter');

        }
    }
