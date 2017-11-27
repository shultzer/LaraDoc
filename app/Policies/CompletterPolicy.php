<?php

    namespace App\Policies;

    use App\User;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class CompletterPolicy {

        use HandlesAuthorization;

        /**
         * Create a new policy instance.
         *
         * @return void
         */
        public function __construct () {
            //
        }

        public function create (User $user) {
            foreach ( $user->roles as $role ) {
                if ( $role->role == 'rup' ) {
                    return TRUE;
                }
            }
            return FALSE;
        }
    }
