<?php

    namespace App\Http\Controllers;

    use App\Completter;
    use App\Property;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;


    class RupController extends Controller {


        public function addcompletter (Property $property) {
            $completter = new Completter();

            $item = $property->pluck('name', 'id');
            return view('addcompletter', [
              'item'       => $item,
              'completter' => $completter,
            ]);
        }

        public function storecompletter (Request $request) {
            $completter = new Completter();
            if ( Gate::denies('create', $completter) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }
            $this->validate($request, [
              'number'  => 'required|unique:completters|max:10',
              'date'    => 'required',
              'doc'     => 'required',
              'company' => 'required',
              'reason'  => 'required',
            ]);
            $user = Auth::user();

            if ( $request->hasFile('doc') ) {
                $doc = $request->file('doc');

                $fileName = time() . '_' . $doc->getClientOriginalName();
                $r        = $doc->storeAs('completters', $fileName, [ 'disk' => 'docs' ]);
                $storedoc = 'docs/' . $r;
                $comlet   = $user->completters()
                                 ->create([
                                   'doc'     => $storedoc,
                                   'number'  => $request->number,
                                   'date'    => $request->date,
                                   'company' => $request->company,
                                   'volume'  => $request->volume,
                                   'reason'  => $request->reason,
                                 ]);
                $comlet->propertys()->attach($request->get('property'));
            }
            $request->session()->flash('status', 'Запись внесена!!!');
            return redirect('/');
        }

    }