<?php

  namespace App\Http\Controllers;

  use App\Completter;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;

  class AdminController extends Controller {

    public function storecompletter(Request $request) {

      $user   = Auth::user();
      $comlet = $user->completters()->create($request->except('_token'));
      $comlet->propertys()->attach($request->get('property'));
    }
  }
