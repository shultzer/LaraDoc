<?php

  namespace App\Http\Controllers;

  use App\Completter;
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
      $user   = Auth::user();
      $comlet = $user->completters()->create($request->except('_token'));
      $comlet->propertys()->attach($request->get('property'));
      return redirect('/');
    }

    public function addspaletter(Property $property) {
      $item        = $property->pluck('name', 'id');
      $completters = Completter::all();
      return view('addspaletter', [
        'item'        => $item,
        'completters' => $completters,
      ]);
    }

    public function storespaletter(Spaletter $spaletter, Request $request) {
      $user   = Auth::user();
      $spalet = $user->spaletters()->create($request->except('_token'));
      //dd($spalet);
      $assoc_completters = Completter::where('number', $request->company)
                                     ->get();
      //$user->account()->associate($account);
      foreach ($assoc_completters as $assoc_completter){
      $res = $assoc_completter->spaletters()->associate($spalet);
      $res->save();
      }
      //$assoc_completters->save();
      return redirect('/');
    }

  }