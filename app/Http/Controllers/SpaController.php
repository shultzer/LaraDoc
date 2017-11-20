<?php

    namespace App\Http\Controllers;

    use App\Completter;
    use App\Property;
    use Illuminate\Http\Request;
    use ZipArchive;

    class SpaController extends Controller {

        public function makeletterform  (Property $property) {
            $item                         = $property->pluck('name', 'id');
            $complettersWhithoutspaletter = Completter::whereIn('spaletters_id', [
              NULL,
              0,
            ])->get();
            return view('spa.makeletter', [
              'item'        => $item,
              'completters' => $complettersWhithoutspaletter,
            ]);
        }
        public function makeletter (Request $request){
            $company = Completter::where('number', $request->company)
                                 ->first()->company;
            $date    = Completter::where('number', $request->company)
                                 ->first()->date;
            $number  = Completter::where('number', $request->company)
                                 ->first()->number;


            $zip = new ZipArchive;
            copy('template.docx', 'doc.docx');
            if ( $zip->open('doc.docx') === TRUE ) {
                /*открываем наш шаблон для чтения (он находится вне документа)
                и помещаеем его содержимое в переменную $content*/
                $zip->extractTo('doc');
                $handle  = fopen("doc/word/document.xml", "r");
                $content = fread($handle, filesize("doc/word/document.xml"));
                fclose($handle);
                /*Далее заменяем все что нам нужно например так */
                $content = str_replace([
                  "company",
                  "date",
                  "number",
                ], [ "$company", "$date", "$number" ], $content);

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
