<?php

    namespace App\Http\Controllers;

    use App\Companies;
    use Excel;
    use App\Completter;
    use App\Order;
    use App\Report;
    use App\Spaletter;
    use Illuminate\Http\Request;
    //use Maatwebsite\Excel\Facades\Excel;
    use function Sodium\crypto_box_publickey_from_secretkey;

    class IndexController extends Controller {

        /**
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */


        static function getcompanies ($key = NULL) {
            $list = [];
            foreach ( Companies::all() as $item ) {
                $list [ $item->slug ] = $item->name;
            }
            if ( $key == NULL ) {
                return $list;
            }
            else {
                return $list[ $key ];
            }
        }

        public function index () {

            $completter = new Completter;
            $spaletter  = new Spaletter;
            $order      = new Order;
            $report     = new Report;
            //dd(IndexController::$companylist);

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

                foreach ( $orderswhithoutreports as $orderswhithoutreport ) {

                    $ord[ $orderswhithoutreport->number ] = $orderswhithoutreport->completters->where('report_id', 0);

                }
            }
            else {
                $ord = [];
            }


            //dump($ord);


            return view('index', [
              'companyletters'               => $companyletters,
              'spaletters'                   => $spaletters,
              'orders'                       => $orders,
              'complettersWhithoutspaletter' => $complettersWhithoutspaletter,
              'complettersWhithoutorder'     => $complettersWhithoutorder,
              'numletters'                   => $numletters,
              'orderswhithoutreports'        => $ord,
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
            $ar         = $this->build_array($this->getcompanies());
            //dd($ar);
            return view('table', [
              'ar'         => $ar,
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]);

        }

        public function exportUserList () {
            $ar         = $this->build_array($this->getcompanies());

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

        public function build_array ($companies) {

            $ar = [];
            foreach ( $companies as $key => $company ) {

                $query = Completter::with('spaletters.orders', 'reports', 'orders.reports', 'propertys')
                                   ->where([ 'company' => $company ])
                                   ->get();
                foreach ( $query as $item ) {
                    /*
                     * кладем в массив письма бреста
                     * и длинну сетей
                     *
                     * */

                    $ar[ $key ][ $item->number ][ 'comletter' ] = $item;
                    //$ar[ $key ][ 'volume' ][]             = $item->volume;

                    /*
                     * если есть связанные письма Белэнерго - дабавляем в массив
                     *
                     * */
                    if ( isset($item->spaletters) ) {

                        $ar[ $key ][ $item->number ][ 'spaletter' ] = $item->spaletters;
                        //$ar[ $key ][ 'spavolume' ][]          = $item->volume;
                    }
                    else {
                        $ar[ $key ][ $item->number ][ 'spaletter' ] = '';
                    }

                    /*
                     * если есть связанные приказы - дабавляем в массив
                     *
                     * */

                    if ( isset($item->orders) ) {

                        $ar[ $key ][ $item->number ][ 'order' ] = $item->orders;
                        //$ar[ $key ][ 'ordervolume' ][]    = $item->volume;
                    }
                    else {

                        $ar[ $key ][ $item->number ][ 'order' ] = '';
                    }

                    /*
                     * если есть связанные отчеты - дабавляем в массив
                     * */
                    if ( isset($item->reports) ) {

                        $ar[ $key ][ $item->number ][ 'report' ] = $item->reports;
                        //$ar[ $key ][ 'reportvolume' ][]    = $item->volume;
                    }
                    else {

                        $ar[ $key ][ $item->number ][ 'report' ] = '';
                    }

                }//endsubforeach
            }//endmainforeach
            return $ar;

        }


    }

