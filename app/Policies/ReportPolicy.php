<?php

    namespace App\Policies;

    use App\User;
    use App\Report;
    use Illuminate\Auth\Access\HandlesAuthorization;

    class ReportPolicy {

        use HandlesAuthorization;

        /**
         * Determine whether the user can view the report.
         *
         * @param  \App\User $user
         * @param  \App\Report $report
         *
         * @return mixed
         */
        public function view (User $user, Report $report) {
            //
        }

        /**
         * Determine whether the user can create reports.
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
         * Determine whether the user can update the report.
         *
         * @param  \App\User $user
         * @param  \App\Report $report
         *
         * @return mixed
         */
        public function update (User $user, Report $report) {
            //
        }

        /**
         * Determine whether the user can delete the report.
         *
         * @param  \App\User $user
         * @param  \App\Report $report
         *
         * @return mixed
         */
        public function delete (User $user, Report $report) {
            //
        }
    }
