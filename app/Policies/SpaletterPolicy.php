<?php

    namespace App\Policies;

    use App\User;
    use App\Spaletter;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class SpaletterPolicy {

        use HandlesAuthorization;

        /**
         * Determine whether the user can view the spaletter.
         *
         * @param  \App\User $user
         * @param  \App\Spaletter $spaletter
         *
         * @return mixed
         */
        public function view (User $user, Spaletter $spaletter) {
            foreach ( $user->roles as $role ) {
                if ( $role->role == 'spa' ) {
                    return TRUE;
                }
            }
            return FALSE;
        }

        /**
         * Determine whether the user can create spaletters.
         *
         * @param  \App\User $user
         *
         * @return mixed
         */

        public function before (User $user) {
            foreach ( $user->roles as $role ) {
                if ( $role->role == 'admin' ) {
                    return TRUE;
                }
            }


        }

        public function create (User $user) {
            foreach ( $user->roles as $role ) {
                if ( $role->role == 'spa' ) {
                    return TRUE;
                }
            }
            return FALSE;
        }

        /**
         * Determine whether the user can update the spaletter.
         *
         * @param  \App\User $user
         * @param  \App\Spaletter $spaletter
         *
         * @return mixed
         */
        public function update (User $user, Spaletter $spaletter) {
            //
        }

        /**
         * Determine whether the user can delete the spaletter.
         *
         * @param  \App\User $user
         * @param  \App\Spaletter $spaletter
         *
         * @return mixed
         */
        public function delete (User $user, Spaletter $spaletter) {
            //
        }
    }
