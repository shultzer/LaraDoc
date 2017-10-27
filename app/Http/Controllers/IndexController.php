<?php

  namespace App\Http\Controllers;

  use App\Completter;
  use App\Order;
  use App\Spaletter;
  use Illuminate\Http\Request;
  use Maatwebsite\Excel\Facades\Excel;

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
                                               ->take(5)
                                               ->get();
      $orders                       = Order::latest('created_at')
                                           ->take(5)
                                           ->get();
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
      $ar = [];
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Бреста со всеми связями
       *
       * */
      $brestcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                       ->where(['company' => 'Брестэнерго'])
                                       ->get();
      /*
       * формируем массив данных для передачи во вьюху
       * */
      foreach ($brestcompanyletters as $item) {
        /*
         * кладем в массив письма бреста
         * и длинну сетей
         *
         * */
        $ar[ 'brest' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'brestvolume' ][ 'volume' ][]             = $item->volume;

        /*
         * если есть связанные письма Белэнерго - дабавляем в массив
         *
         * */
        if (isset($item->spaletters)) {

          $ar[ 'brest' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'brestvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {
          $ar[ 'brest' ][ $item->number ][ 'spaletter' ] = '';
        }

        /*
         * если есть связанные приказы - дабавляем в массив
         *
         * */

        if (isset($item->orders)) {

          $ar[ 'brest' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'brestvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'brest' ][ $item->number ][ 'order' ] = '';
        }

        /*
         * если есть связанные отчеты - дабавляем в массив
         * */
        if (isset($item->reports)) {

          $ar[ 'brest' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'brestvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'brest' ][ $item->number ][ 'report' ] = '';
        }

      }//endforeach

      /*
       * Получаем из базы жадной загрузкой коллекцию писем Витебска со всеми связями
       *
       * */
      $vitebskcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                         ->where(['company' => 'Витебскэнерго'])
                                         ->get();
      foreach ($vitebskcompanyletters as $item) {

        $ar[ 'vitebsk' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'vitebskvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'vitebskvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'vitebskvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'vitebsk' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'vitebskvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'vitebsk' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Гродно со всеми связями
       *
       * */
      $grodnokcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                         ->where(['company' => 'Гродноэнерго'])
                                         ->get();
      foreach ($grodnokcompanyletters as $item) {

        $ar[ 'grodno' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'grodnovolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'grodnovolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'grodno' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'grodnovolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'grodno' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'grodno' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'grodnovolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'grodno' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Гомеля со всеми связями
       *
       * */
      $gomelcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                       ->where(['company' => 'Гомельэнерго'])
                                       ->get();
      foreach ($gomelcompanyletters as $item) {

        $ar[ 'gomel' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'gomelvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'gomelvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'gomel' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'gomelvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'gomel' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'gomel' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'gomelvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'gomel' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Могилева со всеми связями
       *
       * */
      $mogilevcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                         ->where(['company' => 'Могилевэнерго'])
                                         ->get();
      foreach ($mogilevcompanyletters as $item) {

        $ar[ 'mogilev' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'mogilevvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'mogilevvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'mogilev' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'mogilevvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'mogilev' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'mogilev' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'mogilevvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'mogilev' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Минска со всеми связями
       *
       * */
      $minskcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                       ->where(['company' => 'Минскэнерго'])
                                       ->get();
      foreach ($minskcompanyletters as $item) {

        $ar[ 'minsk' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'minskvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'minskvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'minsk' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'minskvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'minsk' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'minsk' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'minskvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'minsk' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach


      return view('table', [
        'ar' => $ar,
      ]);

    }

    public function exportUserList() {
      $ar = [];
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Бреста со всеми связями
       *
       * */
      $brestcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                       ->where(['company' => 'Брестэнерго'])
                                       ->get();
      /*
       * формируем массив данных для передачи во вьюху
       * */
      foreach ($brestcompanyletters as $item) {
        /*
         * кладем в массив письма бреста
         * и длинну сетей
         *
         * */
        $ar[ 'brest' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'brestvolume' ][ 'volume' ][]             = $item->volume;

        /*
         * если есть связанные письма Белэнерго - дабавляем в массив
         *
         * */
        if (isset($item->spaletters)) {

          $ar[ 'brest' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'brestvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {
          $ar[ 'brest' ][ $item->number ][ 'spaletter' ] = '';
        }

        /*
         * если есть связанные приказы - дабавляем в массив
         *
         * */

        if (isset($item->orders)) {

          $ar[ 'brest' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'brestvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'brest' ][ $item->number ][ 'order' ] = '';
        }

        /*
         * если есть связанные отчеты - дабавляем в массив
         * */
        if (isset($item->reports)) {

          $ar[ 'brest' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'brestvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'brest' ][ $item->number ][ 'report' ] = '';
        }

      }//endforeach

      /*
       * Получаем из базы жадной загрузкой коллекцию писем Витебска со всеми связями
       *
       * */
      $vitebskcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                         ->where(['company' => 'Витебскэнерго'])
                                         ->get();
      foreach ($vitebskcompanyletters as $item) {

        $ar[ 'vitebsk' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'vitebskvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'vitebskvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'vitebskvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'vitebsk' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'vitebskvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'vitebsk' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Гродно со всеми связями
       *
       * */
      $grodnokcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                         ->where(['company' => 'Гродноэнерго'])
                                         ->get();
      foreach ($grodnokcompanyletters as $item) {

        $ar[ 'grodno' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'grodnovolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'grodnovolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'grodno' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'grodnovolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'grodno' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'grodno' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'grodnovolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'grodno' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Гомеля со всеми связями
       *
       * */
      $gomelcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                       ->where(['company' => 'Гомельэнерго'])
                                       ->get();
      foreach ($gomelcompanyletters as $item) {

        $ar[ 'gomel' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'gomelvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'gomelvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'gomel' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'gomelvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'gomel' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'gomel' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'gomelvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'gomel' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Могилева со всеми связями
       *
       * */
      $mogilevcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                         ->where(['company' => 'Могилевэнерго'])
                                         ->get();
      foreach ($mogilevcompanyletters as $item) {

        $ar[ 'mogilev' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'mogilevvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'mogilevvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'mogilev' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'mogilevvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'mogilev' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'mogilev' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'mogilevvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'mogilev' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach
      /*
       * Получаем из базы жадной загрузкой коллекцию писем Минска со всеми связями
       *
       * */
      $minskcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                       ->where(['company' => 'Минскэнерго'])
                                       ->get();
      foreach ($minskcompanyletters as $item) {

        $ar[ 'minsk' ][ $item->number ][ 'comletter' ] = $item;
        $ar[ 'minskvolume' ][ 'volume' ][]             = $item->volume;
        if (isset($item->spaletters)) {

          $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
          $ar[ 'minskvolume' ][ 'spavolume' ][]          = $item->volume;
        }
        else {

          $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = '';
        }
        if (isset($item->orders)) {

          $ar[ 'minsk' ][ $item->number ][ 'order' ] = $item->orders;
          $ar[ 'minskvolume' ][ 'ordervolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'minsk' ][ $item->number ][ 'order' ] = '';
        }
        if (isset($item->reports)) {

          $ar[ 'minsk' ][ $item->number ][ 'report' ] = $item->reports;
          $ar[ 'minskvolume' ][ 'reportvolume' ][]    = $item->volume;
        }
        else {

          $ar[ 'minsk' ][ $item->number ][ 'report' ] = '';
        }
      }//endforeach

      Excel::create('New file', function ($excel) use ($ar) {

        $excel->sheet('New sheet', function ($excel) use ($ar) {
          $excel->loadView('table', ['ar' => $ar,]);
        });
        //dd($excel);
      })->download('xlsx');
    }
  }

  class UserListExport extends \Maatwebsite\Excel\Files\NewExcelFile {

    public function getFilename() {
      return 'filename';
    }
  }

