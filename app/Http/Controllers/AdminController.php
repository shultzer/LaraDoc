<?php

  namespace App\Http\Controllers;

  use App\Completter;
  use App\Order;
  use App\Property;
  use App\Spaletter;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class AdminController extends Controller {

    public function addcompletter(Property $property) {
      $item = $property->pluck('name', 'id');
      return view('addcompletter', ['item' => $item]);
    }

    public function storecompletter(Request $request) {
      $user = Auth::user();

      if ($request->hasFile('doc')) {
        $doc = $request->file('doc');

        $fileName = time() . '_' . $doc->getClientOriginalName();
        $r        = $doc->storeAs('completters', $fileName, ['disk' => 'docs']);
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

    public function addspaletter(Property $property) {
      $item                         = $property->pluck('name', 'id');
      $complettersWhithoutspaletter = Completter::whereIn('spaletters_id', [
        NULL,
        0,
      ])->get();
      return view('addspaletter', [
        'item'        => $item,
        'completters' => $complettersWhithoutspaletter,
      ]);
    }

    public function storespaletter(Spaletter $spaletter, Request $request) {
      $user              = Auth::user();
      $doc               = $request->file('doc');
      $fileName          = time() . '_' . $doc->getClientOriginalName();
      $r                 = $doc->storeAs('spaletters', $fileName, ['disk' => 'docs']);
      $storedoc          = 'docs/' . $r;
      $spalet            = $user->spaletters()
                                ->create([
                                  'doc'    => $storedoc,
                                  'number' => $request->number,
                                  'date'   => $request->date,
                                ]);
      $assoc_completters = Completter::whereIn('number', $request->company)
                                     ->get();
      foreach ($assoc_completters as $assoc_completter) {
        //dd($assoc_completter);
        $res = $assoc_completter->spaletters()->associate($spalet);
        $res->save();
      }
      $request->session()->flash('status', 'Запись внесена!!!');

      return redirect('/');
    }

    public function addorder() {

      $complettersWhithoutorder = Completter::has('spaletters')->whereIn('order_id', [0, NULL])
                                            ->get();
      dump(Completter::has('spaletters')->whereIn('order_id', [0, NULL])->get());
      return view('addorder', [
        'completters' => $complettersWhithoutorder,
      ]);
    }

    public function storeorder(Request $request) {
      $user     = Auth::user();
      $doc      = $request->file('doc');
      $fileName = time() . '_' . $doc->getClientOriginalName();
      $r        = $doc->storeAs('orders', $fileName, ['disk' => 'docs']);
      $storedoc = 'docs/' . $r;
      $order             = $user->orders()->create([
        'doc'    => $storedoc,
        'number' => $request->number,
        'date'   => $request->date,
      ]);
      $assoc_completters = Completter::whereIn('number', $request->company)
                                     ->get();
      foreach ($assoc_completters as $assoc_completter) {
        $res = $assoc_completter->orders()->associate($order);
        $res->save();
      }
      $request->session()->flash('status', 'Запись внесена!!!');

      return redirect('/');
    }

    public function addreport(Order $order) {
      $ordersWhithoutreport = $order->with('completters.orders')->doesntHave('reports')->get();

      return (view('addreport', [
        'orders' => $ordersWhithoutreport,
      ]));
    }

    public function storereport(Request $request) {
      $user     = Auth::user();
      $doc      = $request->file('doc');
      $fileName = time() . '_' . $doc->getClientOriginalName();
      $r        = $doc->storeAs('reports', $fileName, ['disk' => 'docs']);
      $storedoc = 'docs/' . $r;
      $report   = $user->reports()->create([
        'doc'    => $storedoc,
        'number' => $request->number,
        'date'   => $request->date,
        'company' => $request->company
      ]);
      $assoc_completters = Completter::whereIn('number', $request->company)
                                     ->get();
      foreach ($assoc_completters as $assoc_completter) {
        $res = $assoc_completter->reports()->associate($report);
        $res->save();
      }

      $report->orders()->attach($request->get('order'));
      $request->session()->flash('status', 'Запись внесена!!!');

      return redirect('/');
    }
  }