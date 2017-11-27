<?php

    namespace App\Http\Controllers;

    use App\Order;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;

    class MinController extends Controller {



        public function addorder () {
            $order = new Order();

            $complettersWhithoutorder = Completter::has('spaletters')
                                                  ->whereIn('order_id', [
                                                    0,
                                                    NULL,
                                                  ])
                                                  ->get();
            return view('addorder', [
              'completters' => $complettersWhithoutorder,
                'order' => $order
            ]);
        }

        public function storeorder (Request $request) {
            $order = new Order();
            if ( Gate::denies('create', $order) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }
            $this->validate($request, [
              'number' => 'required|unique:orders|max:10',
              'date'   => 'required',
              'doc'    => 'required',
            ]);
            $user              = Auth::user();
            $doc               = $request->file('doc');
            $fileName          = time() . '_' . $doc->getClientOriginalName();
            $r                 = $doc->storeAs('orders', $fileName, [ 'disk' => 'docs' ]);
            $storedoc          = 'docs/' . $r;
            $order             = $user->orders()->create([
              'doc'    => $storedoc,
              'number' => $request->number,
              'date'   => $request->date,
            ]);
            $assoc_completters = Completter::whereIn('number', $request->company)
                                           ->get();
            foreach ( $assoc_completters as $assoc_completter ) {
                $res = $assoc_completter->orders()->associate($order);
                $res->save();
            }
            $request->session()->flash('status', 'Запись внесена!!!');

            return redirect('/');
        }
    }
