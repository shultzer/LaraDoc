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
            $spalet            = $user->spaletters()
                                      ->create([
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

        public function addreport () {
            $completter = new Completter;
            $spaletter  = new Spaletter;
            $order      = new Order;
            $report     = new Report;
            //TODO: incorrect logic orders without reports




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
            return ( view('addreport', [
              'orders'     => $orderswhithoutreports,
              'completter' => $completter,
              'spaletter'  => $spaletter,
              'order'      => $order,
              'report'     => $report,
            ]) );
        }

        public function storereport (Request $request) {
            $report = new Report();

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

            $report            = $user->reports()->create([
              'doc'    => $storedoc,
              'number' => $request->number,
              'date'   => $request->date,
            ]);
            $assoc_completters = Completter::whereIn('number', $request->company)
                                           ->get();
            foreach ( $assoc_completters as $assoc_completter ) {
                $res = $assoc_completter->reports()->associate($report);
                $res->save();
            }

            $report->orders()->attach($request->get('order'));
            $request->session()->flash('status', 'Запись внесена!!!');

            return redirect('/');
        }

        public function makeletterform (Property $property, Completter $completter, Spaletter $spaletter, Order $order, Report $report) {
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
            //dd($request->company);

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
            header("Content-Description: File Transfer");
            $fileName = "doc.docx";
            header("Content-Disposition: attachment; filename=$fileName");
            header("Content-Type: application/msword");
            header("Content-Transfer-Encoding: binary");
            readfile($fileName);
        }
    }
