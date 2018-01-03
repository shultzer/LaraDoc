<?php

    namespace App\Http\Controllers;

    use App\Completter;
    use App\Order;
    use App\Property;
    use App\Report;
    use App\Spaletter;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Gate;
    use ZipArchive;

    class SpaController extends Controller {

        public function dashboard () {
            return view('admin.dashboard');
        }

        public function addspaletter (Property $property, Completter $completter, Order $order, Report $report) {
            $spaletter                    = new Spaletter();
            $item                         = $property->pluck('name', 'id');
            $complettersWhithoutspaletter = Completter::whereIn('spaletters_id', [
              NULL,
              0,
            ])->get();

            return view('addspaletter', [
              'item'        => $item,
              'completters' => $complettersWhithoutspaletter,
              'spaletter'   => $spaletter,
              'completter'  => $completter,
              'order'       => $order,
              'report'      => $report,
            ]);
        }

        public function storespaletter (Request $request) {
            $spaletter = new Spaletter();
            if ( Gate::denies('create', $spaletter) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }
            $this->validate($request, [
              'number' => 'required|unique:spaletters|max:10',
              'date'   => 'required',
              'doc'    => 'required',
            ]);
            $user              = Auth::user();
            $doc               = $request->file('doc');
            $fileName          = time() . '_' . $doc->getClientOriginalName();
            $r                 = $doc->storeAs('spaletters', $fileName, [ 'disk' => 'docs' ]);
            $storedoc          = 'docs/' . $r;
            $spalet            = $user->spaletters()->create([
              'doc'    => $storedoc,
              'number' => $request->number,
              'date'   => $request->date,
            ]);
            $assoc_completters = Completter::whereIn('number', $request->company)
                                           ->get();
            foreach ( $assoc_completters as $assoc_completter ) {
                $res = $assoc_completter->spaletters()->associate($spalet);
                $res->save();
            }
            $request->session()->flash('status', 'Запись внесена!!!');

            return redirect('/');
        }

        public function noncompleteletters ($orderId) {

            //$order   = Order::where('number', $orderId)->first();
            $letters = Completter::where('order_id', $orderId)->get();
            return response()->json($letters);

        }

        public function noncompleteorders () {
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
            return response()->json($orderswhithoutreports);

        }

        public function addreport () {
            $completter = new Completter;
            $spaletter  = new Spaletter;
            $order      = new Order;
            $report     = new Report;


            return ( view('addreport', [

              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]) );
        }

        public function storereport (Request $request) {
            $report = new Report();
            //dd($request);


            if ( Gate::denies('create', $report) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }
            $this->validate($request, [
              'number' => 'required|unique:reports|max:10',
              'date'   => 'required',
              'doc'    => 'required',
            ]);

            $user     = Auth::user();
            $doc      = $request->file('doc');
            $fileName = time() . '_' . $doc->getClientOriginalName();
            $r        = $doc->storeAs('reports', $fileName, [ 'disk' => 'docs' ]);
            $storedoc = 'docs/' . $r;

            $report = $user->reports()->create([
              'doc'    => $storedoc,
              'number' => $request->number,
              'date'   => $request->date,
            ]);

            $assoc_completters = Completter::whereIn('id', $request->company)
                                           ->get();
            //dd($assoc_completters);
            foreach ( $assoc_completters as $assoc_completter ) {
                $res = $assoc_completter->reports()->associate($report);
                $res->save();
            }

            $report->orders()->attach($request->get('order'));
            $request->session()->flash('status', 'Запись внесена!!!');

            return redirect('/');
        }

        public function makeletterform (Property $property, Completter $completter, Spaletter $spaletter, Order $order, Report $report) {
            if ( Gate::denies('create', $spaletter) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }
            $item                         = $property->pluck('name', 'id');
            $complettersWhithoutspaletter = Completter::whereIn('spaletters_id', [
              NULL,
              0,
            ])->get();

            return view('spa.makeletter', [
              'item'        => $item,
              'completters' => $complettersWhithoutspaletter,
              'completter'  => $completter,
              'spaletter'   => $spaletter,
              'order'       => $order,
              'report'      => $report,
            ]);
        }

        public function makeletter (Request $request) {


            //TODO: use many templates
            if ( count($request->company) > 1 ) {
                $template = 'templateformany.docx';

                $str = '';
                foreach ( $request->company as $item ) {

                    $company = Completter::where('number', $item)
                                         ->first()->company;
                    $date    = Completter::where('number', $item)
                                         ->first()->date;
                    $number  = Completter::where('number', $item)
                                         ->first()->number;

                    $str .= "$company от $date № $number, ";
                }

            }
            else {
                $template = 'templatefor1.docx';
                $company  = Completter::where('number', $request->company)
                                      ->first()->company;
                $date     = Completter::where('number', $request->company)
                                      ->first()->date;
                $number   = Completter::where('number', $request->company)
                                      ->first()->number;
                $owner    = Completter::where('number', $request->company)
                                      ->first()->owner;
                $str      = "$company от $date № $number";
            }


            $zip = new ZipArchive;
            copy($template, 'doc.docx');
            if ( $zip->open('doc.docx') === TRUE ) {
                /*открываем наш шаблон для чтения (он находится вне документа)
                и помещаеем его содержимое в переменную $content*/
                $zip->extractTo('doc');
                $handle  = fopen("doc/word/document.xml", "r");
                $content = fread($handle, filesize("doc/word/document.xml"));
                fclose($handle);
                /*Далее заменяем все что нам нужно  */
                if ( isset($owner) ) {
                    $content = str_replace([ 'str', 'owner' ], [
                      $str,
                      $owner,
                    ], $content);

                }
                else {
                    $content = str_replace('str', $str, $content);
                }


                /*Удаляем имеющийся в архиве document.xml*/
                $zip->deleteName('word/document.xml');
                /*Пакуем созданный нами ранее и закрываем*/
                $zip->addFromString('word/document.xml', $content);
                $zip->close();
            }
            // Отдаём вордовский файл
            header("Cache-Control: public");
            //header ("Content-Description: File Transfer");
            $fileName = "doc.docx";
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/msword");
            header("Content-Transfer-Encoding: binary");
            readfile($fileName);
        }

        public function make_lease_form (Completter $completter, Spaletter $spaletter, Order $order, Report $report) {
            /*if ( Gate::denies('create', $spaletter) ) {
                return redirect()
                  ->route('main')
                  ->with([ 'message' => 'у вас нет  прав' ]);
            }*/
            return view('spa.makelease', [
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]);
        }

        public function make_lease_letter (Request $request) {

            $template   = '';
            $type       = $request->type;
            $contractor = $request->contractor;
            $period     = $request->period;
            $address    = $request->address;
            $target     = $request->target;
            $wall       = $request->wall;
            $cont       = $request->cont;
            $date       = $request->date;
            $number     = $request->number;
            $mov        = $request->mov;
            $dog        = $request->dog;

            $property = str_replace([
              'нежилое',
              'помещение',
              'здание',
              'часть',
              'оборудование',
            ],
              [
                'нежилого',
                'помещения',
                'здания',
                'части',
                'оборудования',
              ], $request->property);

            $filial      = $request->filial;
            $arendodatel = $request->arendodatel;
            if ( isset($filial) ) {
                $filial = str_replace('филиал', 'филиала', $filial);
                $owner  = $filial . ' ' . $arendodatel;
            }
            else {
                $owner = $arendodatel;
            }

            $this->buildfilename ($dog, $mov, $type, $cont, $wall, $contractor, $template);

            $zip = new ZipArchive;
            copy($template, 'arenda.docx');
            if ( $zip->open('arenda.docx') === TRUE ) {
                /*открываем наш шаблон для чтения (он находится вне документа)
                и помещаеем его содержимое в переменную $content*/
                $zip->extractTo('doc');
                $handle = fopen("doc/word/document.xml", "r");


                $content = fread($handle, filesize("doc/word/document.xml"));

                fclose($handle);

                /*
                 * Далее заменяем все что нам нужно
                 *
                 * */


                $content = str_replace([
                  'contractor',
                  'period',
                  'date',
                  'number',
                  'property',
                  'owner',
                  'address',
                  'company',
                  'target',
                ],
                  [
                    $contractor,
                    $period,
                    $date,
                    $number,
                    $property,
                    $owner,
                    $address,
                    $arendodatel,
                    $target,
                  ], $content);
                //dd($content);
                /*Удаляем имеющийся в архиве document.xml*/
                $zip->deleteName('word/document.xml');
                /*Пакуем созданный нами ранее и закрываем*/
                $zip->addFromString('word/document.xml', $content);
                $zip->close();
            }
            //$fileName = "doc.docx";
            $fileName = "arenda.docx";
            // Отдаём вордовский файл
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header('X-Accel-Redirect: ' . $fileName);
            header('Content-Type: application/octet-stream');
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/msword");
            header("Content-Transfer-Encoding: binary");
            readfile($fileName);

        }

        public function buildfilename ($dog, $mov, $type, $cont, $wall, $contractor, &$template) {
            $template = '';
            switch ( $dog ) {
                case 'new':
                    $template .= 'new';
                    break;
                case 'old':
                    $template .= 'old';
                    break;

            }
            switch ( $mov ) {
                case 'movable':
                    $template .= '_movable';
                    break;
                case 'nomovable':
                    $template .= '_nomovable';
                    break;
                case 'mix':
                    $template .= '_mix';
                    break;
                case 'vehicle':
                    $template .= '_vehicle';
                    break;

            }
            switch ( $type ) {
                case 'pay':
                    $template .= '_pay';
                    break;
                case 'free':
                    $template .= '_free';
                    break;
                case 'mix':
                    $template .= '_mix';
                    break;
            }
            switch ( $contractor ) {
                case TRUE:
                    $template .= '_contractor';
                    break;
                case FALSE:
                    $template .= '_nocontractor';
                    break;

            }
            switch ( $cont ) {
                case 'mounthly':
                    $template .= '_mounthly';
                    break;
                case 'hourly':
                    $template .= '_hourly';
                    break;
            }
            switch ( $wall ) {
                case 'true':
                    $template .= '_walls';
                    break;
                case 'false':
                    $template .= '_nowalls';
                    break;
                case 'mix':
                    $template .= '_mix';
                    break;
            }
            $template .= '.docx';
        }
    }
