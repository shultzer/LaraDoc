<?php

    namespace App\Http\Controllers;

    use App\Completter;
    use App\Order;
    use App\Report;
    use App\Spaletter;
    use Illuminate\Http\Request;
    use Maatwebsite\Excel\Facades\Excel;
    use function Sodium\crypto_box_publickey_from_secretkey;

    class IndexController extends Controller {

        public static $companylist = [
          'brestenergo'        => 'РУП «Брестэнерго»',
          'vitebskenergo'      => 'РУП «Витебскэнерго»',
          'grodnoenergo'       => 'РУП «Гродноэнерго»',
          'gomelenergo'        => 'РУП «Гомельэнерго»',
          'minskenergo'        => 'РУП «Минскэнерго»',
          'mogilevenergo'      => 'РУП «Могилевэнерго»',
          'belenergostroy'     => 'РУП «Белэнергострой»',
          'beltei'             => 'РУП «БелТЭИ»',
          'belnipi'            => 'РУП «Белнипиэнергопром»',
          'belenergosetproekt' => 'РУП «Белэнергосетьпроект»',
        ];

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index () {
            $completter = new Completter;
            $spaletter  = new Spaletter;
            $order      = new Order;
            $report     = new Report;

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
            $complettersWhithoutspaletter = $completter->complettersWhithoutspaletter();
            $complettersWhithoutorder     = Completter::WhereHas('spaletters')
                                                      ->whereIn('order_id', [
                                                        NULL,
                                                        0,
                                                      ])
                                                      ->take(5)->get();

            $complettersWhithoutreports = Completter::with('orders', 'reports')
                                                    ->whereHas('orders')
                                                    ->whereIn('report_id', [
                                                      NULL,
                                                      0,
                                                    ])
                                                    ->get();

            if ( $complettersWhithoutreports->count() != 0 ) {

                foreach ( $complettersWhithoutreports as $item ) {

                    foreach ( $item->orders()->get() as $i ) {
                        $orderswhithoutreports [] = $i;
                    }

                }
                $orderswhithoutreports = array_unique($orderswhithoutreports);
            }
            else {
                $orderswhithoutreports = [];
            }
            //$orderswhithoutreports = $order->orderswithoutreports();
            //dump($user->roles);


            return view('index', [
              'companyletters'               => $companyletters,
              'spaletters'                   => $spaletters,
              'orders'                       => $orders,
              'complettersWhithoutspaletter' => $complettersWhithoutspaletter,
              'complettersWhithoutorder'     => $complettersWhithoutorder,
              'numletters'                   => $numletters,
              'orderswhithoutreports'        => $orderswhithoutreports,
              'completter'                   => $completter,
              'spaletter'                    => $spaletter,
              'order'                        => $order,
              'report'                       => $report,
            ]);

        }

        public function table () {
            $completter = new Completter;
            $spaletter  = new Spaletter;
            $order      = new Order;
            $report     = new Report;
            $ar         = [];

            /*
             * Получаем из базы жадной загрузкой коллекцию писем Бреста со всеми связями
             *
             * */

            $brestcompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                             ->where([ 'company' => 'РУП «Брестэнерго»' ])
                                             ->get();

            /*
             * формируем массив данных для передачи во вьюху
             * */
            foreach ( $brestcompanyletters as $item ) {
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
                if ( isset($item->spaletters) ) {

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

                if ( isset($item->orders) ) {

                    $ar[ 'brest' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'brestvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'brest' ][ $item->number ][ 'order' ] = '';
                }

                /*
                 * если есть связанные отчеты - дабавляем в массив
                 * */
                if ( isset($item->reports) ) {

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
            $vitebskcompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                               ->where([ 'company' => 'РУП «Витебскэнерго»' ])
                                               ->get();
            foreach ( $vitebskcompanyletters as $item ) {

                $ar[ 'vitebsk' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'vitebskvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'vitebskvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'vitebskvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
            $grodnokcompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                               ->where([ 'company' => 'РУП «Гродноэнерго»' ])
                                               ->get();
            foreach ( $grodnokcompanyletters as $item ) {

                $ar[ 'grodno' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'grodnovolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'grodnovolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'grodno' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'grodnovolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'grodno' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
            $gomelcompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                             ->where([ 'company' => 'РУП «Гомельэнерго»' ])
                                             ->get();

            foreach ( $gomelcompanyletters as $item ) {

                $ar[ 'gomel' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'gomelvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'gomelvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'gomel' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'gomelvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'gomel' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
            $mogilevcompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                               ->where([ 'company' => 'РУП «Могилевэнерго»' ])
                                               ->get();
            foreach ( $mogilevcompanyletters as $item ) {

                $ar[ 'mogilev' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'mogilevvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'mogilevvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'mogilev' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'mogilevvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'mogilev' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
            $minskcompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                             ->where([ 'company' => 'РУП «Минскэнерго»' ])
                                             ->get();
            foreach ( $minskcompanyletters as $item ) {

                $ar[ 'minsk' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'minskvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'minskvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'minsk' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'minskvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'minsk' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

                    $ar[ 'minsk' ][ $item->number ][ 'report' ] = $item->reports;
                    $ar[ 'minskvolume' ][ 'reportvolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'minsk' ][ $item->number ][ 'report' ] = '';
                }
            }//endforeach

            /*
             * Получаем из базы жадной загрузкой коллекцию писем Белтэи со всеми связями
             *
             * */
            $belteicompanyletters = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                              ->where([ 'company' => 'РУП «БелТЭИ»' ])
                                              ->get();
            /*
             * формируем массив данных для передачи во вьюху
             * */
            foreach ( $belteicompanyletters as $item ) {
                /*
                 * кладем в массив письма Белтэи
                 * и длинну сетей
                 *
                 * */
                $ar[ 'beltei' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'belteivolume' ][ 'volume' ][]             = $item->volume;

                /*
                 * если есть связанные письма Белэнерго - дабавляем в массив
                 *
                 * */
                if ( isset($item->spaletters) ) {

                    $ar[ 'beltei' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'belteivolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {
                    $ar[ 'beltei' ][ $item->number ][ 'spaletter' ] = '';
                }

                /*
                 * если есть связанные приказы - дабавляем в массив
                 *
                 * */

                if ( isset($item->orders) ) {

                    $ar[ 'beltei' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'belteivolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'beltei' ][ $item->number ][ 'order' ] = '';
                }

                /*
                 * если есть связанные отчеты - дабавляем в массив
                 * */
                if ( isset($item->reports) ) {

                    $ar[ 'beltei' ][ $item->number ][ 'report' ] = $item->reports;
                    $ar[ 'belteivolume' ][ 'reportvolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'beltei' ][ $item->number ][ 'report' ] = '';
                }

            }//endforeach
            //dd($ar);

            return view('table', [
              'ar'         => $ar,
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]);

            //TODO: add other companies
        }

        public function exportUserList () {
            $ar = [];
            /*
             * Получаем из базы жадной загрузкой коллекцию писем Бреста со всеми связями
             *
             * */
            $brestcompanyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                             ->where([ 'company' => 'РУП «Брестэнерго»' ])
                                             ->get();
            /*
             * формируем массив данных для передачи во вьюху
             * */
            foreach ( $brestcompanyletters as $item ) {
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
                if ( isset($item->spaletters) ) {

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

                if ( isset($item->orders) ) {

                    $ar[ 'brest' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'brestvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'brest' ][ $item->number ][ 'order' ] = '';
                }

                /*
                 * если есть связанные отчеты - дабавляем в массив
                 * */
                if ( isset($item->reports) ) {

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
                                               ->where([ 'company' => 'РУП «Витебскэнерго»' ])
                                               ->get();
            foreach ( $vitebskcompanyletters as $item ) {

                $ar[ 'vitebsk' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'vitebskvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'vitebskvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'vitebsk' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'vitebskvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'vitebsk' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
                                               ->where([ 'company' => 'РУП «Гродноэнерго»' ])
                                               ->get();
            foreach ( $grodnokcompanyletters as $item ) {

                $ar[ 'grodno' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'grodnovolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'grodnovolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'grodno' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'grodno' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'grodnovolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'grodno' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
                                             ->where([ 'company' => 'РУП «Гомельэнерго»' ])
                                             ->get();
            foreach ( $gomelcompanyletters as $item ) {

                $ar[ 'gomel' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'gomelvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'gomelvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'gomel' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'gomel' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'gomelvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'gomel' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
                                               ->where([ 'company' => 'РУП «Могилевэнерго»' ])
                                               ->get();
            foreach ( $mogilevcompanyletters as $item ) {

                $ar[ 'mogilev' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'mogilevvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'mogilevvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'mogilev' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'mogilev' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'mogilevvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'mogilev' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

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
                                             ->where([ 'company' => 'РУП «Минскэнерго»' ])
                                             ->get();
            foreach ( $minskcompanyletters as $item ) {

                $ar[ 'minsk' ][ $item->number ][ 'comletter' ] = $item;
                $ar[ 'minskvolume' ][ 'volume' ][]             = $item->volume;
                if ( isset($item->spaletters) ) {

                    $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                    $ar[ 'minskvolume' ][ 'spavolume' ][]          = $item->volume;
                }
                else {

                    $ar[ 'minsk' ][ $item->number ][ 'spaletter' ] = '';
                }
                if ( isset($item->orders) ) {

                    $ar[ 'minsk' ][ $item->number ][ 'order' ] = $item->orders;
                    $ar[ 'minskvolume' ][ 'ordervolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'minsk' ][ $item->number ][ 'order' ] = '';
                }
                if ( isset($item->reports) ) {

                    $ar[ 'minsk' ][ $item->number ][ 'report' ] = $item->reports;
                    $ar[ 'minskvolume' ][ 'reportvolume' ][]    = $item->volume;
                }
                else {

                    $ar[ 'minsk' ][ $item->number ][ 'report' ] = '';
                }
            }//endforeach

            Excel::create('table', function ($excel) use ($ar) {

                $excel->sheet('New sheet', function ($sheet) use ($ar) {
                    $sheet->setWidth([
                      'A' => 16,
                      'B' => 16,
                      'C' => 16,
                      'D' => 16,
                      'E' => 16,
                      'F' => 16,
                      'G' => 16,
                      'H' => 16,
                      'I' => 16,
                    ]);
                    $sheet->loadView('tableforexcel', [ 'ar' => $ar, ]);

                });

            })->download('xlsx');
        }

        public function searchform () {
            $completter     = new Completter;
            $spaletter      = new Spaletter;
            $order          = new Order;
            $report         = new Report;
            $companyletters = Completter::all();
            foreach ( $companyletters as $item ) {
                $ar[] = $item->number;
            }

            return view('letterwayform', [
              'ar'         => $ar,
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]);
        }

        public function searchway (Request $request) {
            $completter = new Completter;
            $spaletter  = new Spaletter;
            $order      = new Order;
            $report     = new Report;
            $ar         = [];
            $this->validate($request, [
              'number' => 'required|max:10',
            ]);
            $number         = $request->number;
            $companyletters = Completter::with('spaletters.orders', 'orders.reports', 'propertys')
                                        ->where('number', $number)->get();
            $spaletter      = Spaletter::with('orders.reports')
                                       ->where('number', $number)->first();
            $orders         = Order::with('reports')
                                   ->where('number', $number)->first();
            if ( isset($companyletters) ) {
                foreach ( $companyletters as $item ) {
                    $ar[ $item->number ][ 'comletter' ] = $item;
                    if ( isset($item->spaletters) ) {
                        $ar[ $item->number ][ 'spaletter' ] = $item->spaletters;
                    }
                    else {
                        $ar[ $item->number ][ 'spaletter' ] = '';
                    }
                    if ( isset($item->orders) ) {
                        $ar[ $item->number ][ 'order' ] = $item->orders;
                    }
                    else {
                        $ar[ $item->number ][ 'order' ] = '';
                    }
                    if ( isset($item->reports) ) {
                        $ar[ $item->number ][ 'report' ] = $item->reports;
                    }
                    else {
                        $ar[ $item->number ][ 'report' ] = '';
                    }
                }//endforeach
            }
            if ( isset($spaletter) ) {
                $completters = Completter::where('spaletters_id', $spaletter->id)
                                         ->get();
                foreach ( $completters as $item ) {
                    $ar[ $item->number ][ 'comletter' ] = $item;
                    if ( isset($item->spaletters) ) {
                        $ar[ $item->number ][ 'spaletter' ] = $item->spaletters;
                    }
                    else {
                        $ar[ $item->number ][ 'spaletter' ] = '';
                    }
                    if ( isset($item->orders) ) {
                        $ar[ $item->number ][ 'order' ] = $item->orders;
                    }
                    else {
                        $ar[ $item->number ][ 'order' ] = '';
                    }
                    if ( isset($item->reports) ) {
                        $ar[ $item->number ][ 'report' ] = $item->reports;
                    }
                    else {
                        $ar[ $item->number ][ 'report' ] = '';
                    }
                }//endforeach
            }
            if ( isset($orders) ) {
                $completters = Completter::where('order_id', $orders->id)
                                         ->get();
                foreach ( $completters as $item ) {
                    $ar[ $item->number ][ 'comletter' ] = $item;
                    if ( isset($item->spaletters) ) {
                        $ar[ $item->number ][ 'spaletter' ] = $item->spaletters;
                    }
                    else {
                        $ar[ $item->number ][ 'spaletter' ] = '';
                    }
                    if ( isset($item->orders) ) {
                        $ar[ $item->number ][ 'order' ] = $item->orders;
                    }
                    else {
                        $ar[ $item->number ][ 'order' ] = '';
                    }
                    if ( isset($item->reports) ) {
                        $ar[ $item->number ][ 'report' ] = $item->reports;
                    }
                    else {
                        $ar[ $item->number ][ 'report' ] = '';
                    }
                }//endforeach
            }
            return view('searchresult', [
              'ar'         => $ar,
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,

            ]);
        }


    }


    /*class UserListExport extends \Maatwebsite\Excel\Files\NewExcelFile {

        public function getFilename () {
            return 'filename';
        }
    }*/

