<?php

    namespace App\Policies;

    use App\User;
    use App\Order;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class OrderPolicy {

        use HandlesAuthorization;

        /**
         * Determine whether the user can view the order.
         *
         * @param  \App\User $user
         * @param  \App\Order $order
         *
         * @return mixed
         */
        public function view (User $user, Order $order) {
            //
        }

        /**
         * Determine whether the user can create orders.
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
            return FALSE;

        }

        public function create (User $user) {
            foreach ( $user->roles as $role ) {
                if ( $role->role == 'min' ) {
                    return TRUE;
                }
            }
            return FALSE;
        }

        /**
         * Determine whether the user can update the order.
         *
         * @param  \App\User $user
         * @param  \App\Order $order
         *
         * @return mixed
         */
        public function update (User $user, Order $order) {
            //
        }

        /**
         * Determine whether the user can delete the order.
         *
         * @param  \App\User $user
         * @param  \App\Order $order
         *
         * @return mixed
         */
        public function delete (User $user, Order $order) {
            //
        }
    }
