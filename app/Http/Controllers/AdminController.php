<?php

  namespace App\Http\Controllers;

  use App\Completter;
  use App\Order;
  use App\Property;
  use App\Spaletter;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Auth;
  use SoapClient;
  use ZipArchive;

  class AdminController extends Controller {

    public function __construct() {

      $this->middleware('auth');

    }

    public function addcompletter(Property $property) {
      $item = $property->pluck('name', 'id');
      return view('addcompletter', ['item' => $item]);
    }

    public function storecompletter(Request $request) {
      $this->validate($request, [
        'number'  => 'required|unique:completters|max:10',
        'date'    => 'required',
        'doc'     => 'required',
        'company' => 'required',
        'reason'  => 'required',
      ]);
      $user = Auth::user();

      if ($request->hasFile('doc')) {
        $doc = $request->file('doc');

        $fileName = time() . '_' . $doc->getClientOriginalName();
        $r        = $doc->storeAs('completters', $fileName, ['disk' => 'docs']);
        $storedoc = 'docs/' . $r;
        $comlet   = $user->completters()
                         ->create([
                           'doc'     => $storedoc,
                           'number'  => $request->number,
                           'date'    => $request->date,
                           'company' => $request->company,
                           'volume'  => $request->volume,
                           'reason'  => $request->reason,
                         ]);
        $comlet->propertys()->attach($request->get('property'));
      }
      $request->session()->flash('status', 'Запись внесена!!!');
      return redirect('/');
    }

    public function addspaletter(Property $property) {
      $item                         = $property->pluck('name', 'id');
      $complettersWhithoutspaletter = Completter::whereIn('spaletters_id', [
        NULL,
        0,
      ])->get();
      return view('addspaletter', [
        'item'        => $item,
        'completters' => $complettersWhithoutspaletter,
      ]);
    }

    public function storespaletter(Spaletter $spaletter, Request $request) {
      /* $this->validate($request, [
         'number' => 'required|unique:spaletters|max:10',
         'date'   => 'required',
         'doc'    => 'required',
       ]);
       $user              = Auth::user();
       $doc               = $request->file('doc');
       $fileName          = time() . '_' . $doc->getClientOriginalName();
       $r                 = $doc->storeAs('spaletters', $fileName, ['disk' => 'docs']);
       $storedoc          = 'docs/' . $r;
       $spalet            = $user->spaletters()
                                 ->create([
                                   'doc'    => $storedoc,
                                   'number' => $request->number,
                                   'date'   => $request->date,
                                 ]);
       $assoc_completters = Completter::whereIn('number', $request->company)
                                      ->get();
       foreach ($assoc_completters as $assoc_completter) {
         $res = $assoc_completter->spaletters()->associate($spalet);
         $res->save();
       }
       $request->session()->flash('status', 'Запись внесена!!!');*/
        $company = Completter::where('number', $request->company)->first()->company;
        $date = Completter::where('number', $request->company)->first()->date;
        $number = Completter::where('number', $request->company)->first()->number;


      $zip = new ZipArchive;
      copy('template.docx', 'doc.docx');
      if ($zip->open('doc.docx') === TRUE) {
        /*открываем наш шаблон для чтения (он находится вне документа)
        и помещаеем его содержимое в переменную $content*/
        $zip->extractTo('doc');
        $handle  = fopen("doc/word/document.xml", "r");
        $content = fread($handle, filesize("doc/word/document.xml"));
        fclose($handle);
        /*Далее заменяем все что нам нужно например так */
        $content = str_replace(["company", "date", "number"], ["$company","$date","$number"], $content);

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
      //return redirect('/');
    }

    public function addorder() {

      $complettersWhithoutorder = Completter::has('spaletters')
                                            ->whereIn('order_id', [0, NULL])
                                            ->get();
      return view('addorder', [
        'completters' => $complettersWhithoutorder,
      ]);
    }

    public function storeorder(Request $request) {
      $this->validate($request, [
        'number' => 'required|unique:orders|max:10',
        'date'   => 'required',
        'doc'    => 'required',
      ]);
      $user              = Auth::user();
      $doc               = $request->file('doc');
      $fileName          = time() . '_' . $doc->getClientOriginalName();
      $r                 = $doc->storeAs('orders', $fileName, ['disk' => 'docs']);
      $storedoc          = 'docs/' . $r;
      $order             = $user->orders()->create([
        'doc'    => $storedoc,
        'number' => $request->number,
        'date'   => $request->date,
      ]);
      $assoc_completters = Completter::whereIn('number', $request->company)
                                     ->get();
      foreach ($assoc_completters as $assoc_completter) {
        $res = $assoc_completter->orders()->associate($order);
        $res->save();
      }
      $request->session()->flash('status', 'Запись внесена!!!');

      return redirect('/');
    }

    public function addreport(Order $order) {
      $ordersWhithoutreport = $order->with('completters.orders')
                                    ->doesntHave('reports')
                                    ->get();

      return (view('addreport', [
        'orders' => $ordersWhithoutreport,
      ]));
    }

    public function storereport(Request $request) {
      $this->validate($request, [
        'number' => 'required|unique:reports|max:10',
        'date'   => 'required',
        'doc'    => 'required',
      ]);
      $user              = Auth::user();
      $doc               = $request->file('doc');
      $fileName          = time() . '_' . $doc->getClientOriginalName();
      $r                 = $doc->storeAs('reports', $fileName, ['disk' => 'docs']);
      $storedoc          = 'docs/' . $r;
      $report            = $user->reports()->create([
        'doc'     => $storedoc,
        'number'  => $request->number,
        'date'    => $request->date,
        'company' => $request->company,
      ]);
      $assoc_completters = Completter::whereIn('number', $request->company)
                                     ->get();
      foreach ($assoc_completters as $assoc_completter) {
        $res = $assoc_completter->reports()->associate($report);
        $res->save();
      }

      $report->orders()->attach($request->get('order'));
      $request->session()->flash('status', 'Запись внесена!!!');

      return redirect('/');
    }
  }