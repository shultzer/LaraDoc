<?php

    namespace App\Http\Controllers;

    use App\Completter;
    use App\Order;
    use App\Report;
    use App\Spaletter;
    use App\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Gate;

    class AdminController extends Controller {


        public function dashboard (Completter $completter, Spaletter $spaletter, Order $order, Report $report) {
            if ( Gate::denies('create', $spaletter) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }
            return view('admin.dashboard', [
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]);
        }
        public function userslist () {
            $users = User::with('roles')->get();
            return response()->json($users);
        }

        public function find ($id) {
            $username = User::with('roles')->find($id);
            return response()->json($username);
        }

        public function adduser (Request $request) {
            $user = User::create([
              'name'     => $request->name,
              'email'    => $request->email,
              'organization'    => $request->organization,
              'password' => bcrypt($request->password),
            ]);
            $user->roles()->attach($request->role);
            return response()->json($request);
        }

        public function updateuser (Request $request) {
            $id = $request->id;
            $user = $request->user;
            $email = $request->email;
            $password = $request->password;
            $role = $request->role;

            $item = User::find($id);
            $item->roles()->sync($role);
            $item->update([
              'name'     => $user,
              'email'    => $email,
              'password' => bcrypt($password),
            ]);


            return $request;
        }

        public function destroy ($id) {
            User::destroy($id);
        }
    }
