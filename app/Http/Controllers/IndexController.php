<?php

  namespace App\Http\Controllers;

  use App\Completter;
  use App\Order;
  use App\Spaletter;
  use Illuminate\Http\Request;

  class IndexController extends Controller {

    public static $companylist = [

      'brestenergo'        => 'Брестэнерго',
      'vitebskenergo'      => 'Витебскэнерго',
      'grodnoenergo'       => 'Гродноэнерго',
      'gomelenergo'        => 'Гомельэнерго',
      'minskenergo'        => 'Минскэнерго',
      'mogilevenergo'      => 'Могилевэнерго',
      'belenergostroy'     => 'Белэнергострой',
      'beltei'             => 'БелТЭИ',
      'belnipi'            => 'Белнипиэнергопром',
      'belenergosetproekt' => 'Белэнергосетьпроект',
    ];

    public function index() {

      $companyletters               = Completter::latest('created_at')
                                                ->take(5)
                                                ->get();
      $numletters                   = Completter::all()->count();
      $spaletters                   = Spaletter::latest('created_at')
                                               ->paginate(5);
      $orders                       = Order::latest('created_at')->paginate(5);
      $complettersWhithoutspaletter = Completter::whereIn('spaletters_id', [
        NULL,
        0,
      ])->get();
      $complettersWhithoutorder     = Completter::whereIn('order_id', [
        NULL,
        0,
      ])->get();
      $orderswhithoutreports        = Order::doesntHave('reports')->get();

      return view('index', [
        'companyletters'               => $companyletters,
        'spaletters'                   => $spaletters,
        'orders'                       => $orders,
        'complettersWhithoutspaletter' => $complettersWhithoutspaletter,
        'complettersWhithoutorder'     => $complettersWhithoutorder,
        'numletters'                   => $numletters,
        'orderswhithoutreports'        => $orderswhithoutreports,
      ]);

    }

    public function table() {
      $ar             = [];
      $brestcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')->where(['company' => 'Брестэнерго'])->get();
      foreach ($brestcompanyletters as $item){
        $ar['brest'][$item->number]['comletter'] = $item;
        if (isset($item->spaletters)){

          $ar['brest'][$item->number]['spaletter'] = $item->spaletters;
        }else{

          $ar['brest'][$item->number]['spaletter'] = '';
        }
        if (isset($item->orders)){

          $ar['brest'][$item->number]['order'] = $item->orders;
        }else{

          $ar['brest'][$item->number]['order'] = '';
        }
        if (isset($item->reports)){

          $ar['brest'][$item->number]['report'] = $item->reports;
        }else{

          $ar['brest'][$item->number]['report'] = '';
        }

      }

      $vitebskcompanyletters = Completter::where(['company' => 'Витебскэнерго'])->get();
      foreach ($vitebskcompanyletters as $item){

        $ar['vitebsk'][$item->number]['comletter'] = $item;
        if (isset($item->spaletters)){

          $ar['vitebsk'][$item->number]['spaletter'] = $item->spaletters;
        }else{

          $ar['vitebsk'][$item->number]['spaletter'] = '';
        }
        if (isset($item->orders)){

          $ar['vitebsk'][$item->number]['order'] = $item->orders;
        }else{

          $ar['vitebsk'][$item->number]['order'] = '';
        }
        if (isset($item->reports)){

          $ar['vitebsk'][$item->number]['report'] = $item->reports;
        }else{

          $ar['vitebsk'][$item->number]['report'] = '';
        }
      }


      $grodnokcompanyletters = Completter::where(['company' => 'Гродноэнерго'])->get();
      foreach ($grodnokcompanyletters as $item){

        $ar['grodno'][$item->number]['comletter'] = $item;
        if (isset($item->spaletters)){

          $ar['grodno'][$item->number]['spaletter'] = $item->spaletters;
        }else{

          $ar['grodno'][$item->number]['spaletter'] = '';
        }
        if (isset($item->orders)){

          $ar['grodno'][$item->number]['order'] = $item->orders;
        }else{

          $ar['grodno'][$item->number]['order'] = '';
        }
        if (isset($item->reports)){

          $ar['grodno'][$item->number]['report'] = $item->reports;
        }else{

          $ar['grodno'][$item->number]['report'] = '';
        }
      }
      $gomelcompanyletters = Completter::where(['company' => 'Гомельэнерго'])->get();
      foreach ($gomelcompanyletters as $item){

        $ar['gomel'][$item->number]['comletter'] = $item;
        if (isset($item->spaletters)){

          $ar['gomel'][$item->number]['spaletter'] = $item->spaletters;
        }else{

          $ar['gomel'][$item->number]['spaletter'] = '';
        }
        if (isset($item->orders)){

          $ar['gomel'][$item->number]['order'] = $item->orders;
        }else{

          $ar['gomel'][$item->number]['order'] = '';
        }
        if (isset($item->reports)){

          $ar['gomel'][$item->number]['report'] = $item->reports;
        }else{

          $ar['gomel'][$item->number]['report'] = '';
        }
      }
      $mogilevcompanyletters = Completter::where(['company' => 'Могилевэнерго'])->get();
      foreach ($mogilevcompanyletters as $item){

        $ar['mogilev'][$item->number]['comletter'] = $item;
        if (isset($item->spaletters)){

          $ar['mogilev'][$item->number]['spaletter'] = $item->spaletters;
        }else{

          $ar['mogilev'][$item->number]['spaletter'] = '';
        }
        if (isset($item->orders)){

          $ar['mogilev'][$item->number]['order'] = $item->orders;
        }else{

          $ar['mogilev'][$item->number]['order'] = '';
        }
        if (isset($item->reports)){

          $ar['mogilev'][$item->number]['report'] = $item->reports;
        }else{

          $ar['mogilev'][$item->number]['report'] = '';
        }
      }
      $minskcompanyletters = Completter::where(['company' => 'Минскэнерго'])->get();
      foreach ($minskcompanyletters as $item){

        $ar['minsk'][$item->number]['comletter'] = $item;
        if (isset($item->spaletters)){

          $ar['minsk'][$item->number]['spaletter'] = $item->spaletters;
        }else{

          $ar['minsk'][$item->number]['spaletter'] = '';
        }
        if (isset($item->orders)){

          $ar['minsk'][$item->number]['order'] = $item->orders;
        }else{

          $ar['minsk'][$item->number]['order'] = '';
        }
        if (isset($item->reports)){

          $ar['minsk'][$item->number]['report'] = $item->reports;
        }else{

          $ar['minsk'][$item->number]['report'] = '';
        }
      }



      return view('table', [
        'ar'               => $ar
      ]);

    }

  }
