@include('header')
<div class="row-fluid sortable">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Аренда
            </h2>
            <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post" action="{{ route('make_lease_letter') }}"
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
                        <label class="control-label" for="typeahead">Номер письма организации</label>
                        <div class="controls">
                            <input type="text" name="number" class="span6 typeahead" id="typeahead">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="date01">Дата письма организации</label>
                        <div class="controls">
                            <input type="text" name="date" class="input-xlarge datepicker" id="date01" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="period">на срок по</label>
                        <div class="controls">
                            <input type="text" name="period" class="input-xlarge datepicker" id="period" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="property">Имущество</label>
                        <div class="controls">
                            <input type="text" name="property" class="input-xlarge datepicker" id="property" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="arendodatel">Арендодатель:</label>
                        <div class="controls">
                            <input type="text" name="filial" class="input-xlarge datepicker" id="arendodatel" placeholder="филиал">
                            <input type="text" name="arendodatel" class="input-xlarge datepicker" id="arendodatel" placeholder="организация">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="addres">Расположенной:</label>
                        <div class="controls">
                            <input type="text" name="addres" class="input-xlarge datepicker" id="addres" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="contractor">Арендатору:</label>
                        <div class="controls">
                            <input type="text" name="contractor" class="input-xlarge datepicker" id="contractor" value="">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="target">Для размещения:</label>
                        <div class="controls">
                            <input type="text" name="target" class="input-xlarge datepicker" id="target" value="">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-large btn-info">Создать</button>
                        <button type="reset" class="btn btn-large btn-danger">отмена</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->

@include('footer')