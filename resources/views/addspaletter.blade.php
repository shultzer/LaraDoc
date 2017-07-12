@include('header')
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Внесение ходатайства ГПО "Белэнерго"
            </h2>
            <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post" action="{{ route('storespaletter') }}"
                  enctype="multipart/form-data">
                <fieldset>
                    {{-- <div class="control-group">
                         <label class="control-label" for="typeahead">Номер письма</label>
                         <div class="controls">
                             <input type="text" class="span6 typeahead" id="typeahead"  data-provide="typeahead"
                             data-items="4" data-source='["Alabama","Alaska","Arizona","Arkansas","California","Colorado",
                             "Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas",
                             "Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi",
                             "Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York",
                             "North Dakota","North Carolina","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island",
                             "South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington",
                             "West Virginia","Wisconsin","Wyoming"]'>
                             <p class="help-block">Start typing to activate auto complete!</p>
                         </div>
                     </div>--}}
                    {{ csrf_field() }}
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Номер письма</label>
                        <div class="controls">
                            <input type="text" name="number" class="span6 typeahead" id="typeahead">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="date01">Дата письма</label>
                        <div class="controls">
                            <input type="text" name="date" class="input-xlarge datepicker" id="date01" value="">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="selectError">Наименование организаций</label>
                        <div class="controls">
                            <select id="selectError" name="company" data-rel="chosen">
                                <option name="" selected></option>
                                @foreach(\App\Http\Controllers\IndexController::$companylist as $key=>$value)
                                    <option name="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="doc">Прикрепите документ</label>
                        <div class="controls">
                            <input class="input-file uniform_on" name="doc" id="doc" type="file">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <button type="reset" class="btn">отмена</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->

@include('footer')