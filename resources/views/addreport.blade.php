@include('header')
<div class="row-fluid sortable">

    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Внесение отчета организации об
                исполнении приказа
            </h2>
            <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post" action="{{ route('storereport') }}"
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
                        <label class="control-label" for="typeahead">Номер отчета</label>
                        <div class="controls">
                            <input type="text" name="number" class="span6 typeahead" id="typeahead">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="date01">Дата отчета</label>
                        <div class="controls">
                            <input type="text" name="date" class="input-xlarge datepicker" id="date01" value="">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="selectError">Приказ Минэнерго</label>
                        <div class="controls">
                            <select id="selectError" name="order[]" data-rel="chosen" multiple>
                                <option name="" hidden selected></option>
                                @if(isset($order))
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}">{{ $order->number }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="selectError">Ходатайстов организации</label>
                            <div class="controls">
                                <select name="company[]" multiple>
                                    @foreach($order->completters as $completter)
                                        <option value="{{ $completter->number }}">№{{ $completter->number }}
                                            , {{ $completter->company }}</option>
                                    @endforeach
                                </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="doc">Прикрепите документ</label>
                        <div class="controls">
                            <input class="input-file uniform_on" name="doc" id="doc" type="file">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-large btn-info">Сохранить</button>
                        <button type="reset" class="btn btn-large btn-danger">отмена</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->

@include('footer')