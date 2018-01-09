<?php

    namespace App\Http\Controllers;

    use App\Companies;
    use App\Completter;
    use App\Property;
    use App\Spaletter;
    use App\Order;
    use App\Report;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;


    class RupController extends Controller {


        public function addcompletter (Property $property, Completter $completter, Spaletter $spaletter, Order $order, Report $report) {

            $slug_org = Auth::user()->organization;
            $name_org = Companies::where('slug', $slug_org)->first()->name;
            $org = [$slug_org, $name_org];


            $item = $property->pluck('name', 'id');
            return view('addcompletter', [
              'item'       => $item,
              'org'       => $org,
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
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
              'second_side_form'  => 'required',
              'typeofdeal'  => 'required',


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
                                   'owner'   => $request->owner,
                                   'typeofdeal'  => $request->typeofdeal,
                                   'second_side_form'  => $request->second_side_form,
                                 ]);
                $comlet->propertys()->attach($request->get('property'));
            }
            $request->session()->flash('status', 'Запись внесена!!!');
            return redirect('/');
        }

    }
