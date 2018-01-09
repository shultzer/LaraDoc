<?php

    namespace App;

    use Illuminate\Notifications\Notifiable;
    use Illuminate\Foundation\Auth\User as Authenticatable;

    class User extends Authenticatable {

        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
          'name',
          'email',
          'organization',
          'password',
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
          /*'password',*/
          'remember_token',
        ];

        public function completters () {
            return $this->hasMany('App\Completter');
        }

        public function spaletters () {
            return $this->hasMany('App\Spaletter');
        }

        public function orders () {

            return $this->hasMany('App\Order');
        }

        public function reports () {

            return $this->hasMany('App\Report');
        }

        public function roles () {
            return $this->belongsToMany('App\Role');
        }

        public function isAdmin () {
            if ( $this->roles()->first()->roles == 'admnin' ) {
                return TRUE;
            }
            else {
                return FALSE;
            }

        }
    }
