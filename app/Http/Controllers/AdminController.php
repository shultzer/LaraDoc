<?php

  namespace App\Http\Controllers;

  use App\Completter;
  use App\Property;
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
      $item = $property->pluck('name', 'id');
      return view('addcompletter', ['item' => $item]);
    }
  }