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

    public static $propertylist = [

      'vl110'     => 'ВЛ110кВ',
      'vl35'      => 'ВЛ35кВ',
      'vl10'      => 'ВЛ10кВ',
      'vl6'       => 'ВЛ6кВ',
      'v04'       => 'ВЛ0,4кВ',
      'teploset'  => 'Тепловые сети',
      'building'  => 'Здание',
      'equipment' => 'Оборудование',

    ];

    public function index() {

      $companyletters = Completter::latest('created_at')->paginate(5);
      $spaletters     = Spaletter::latest('created_at')->paginate(5);
      $orders         = Order::latest('created_at')->paginate(5);
      return view('index', [
        'companyletters' => $companyletters,
        'spaletters'     => $spaletters,
        'orders'         => $orders,
      ]);

    }

  }
