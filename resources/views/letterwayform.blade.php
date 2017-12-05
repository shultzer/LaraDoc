@extends('layouts.test')

@section('content')
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
            <h2><i class="halflings-icon white edit"></i><span class="break"></span>Поиск документа
            </h2>
            <div class="box-icon">
                <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post" action="{{ route('search') }}"
                  enctype="multipart/form-data">
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="typeahead">Номер письма</label>
                        <div class="controls">
                            <input type="text" class="span6 typeahead" name="number" id="typeahead">

                        </div>
                    </div>
                    {{ csrf_field() }}

                    {{-- <div class="control-group">
                         <label class="control-label" for="date01">Дата письма</label>
                         <div class="controls">
                             <input type="text" name="date" class="input-xlarge datepicker" id="date01" value="">
                         </div>
                     </div>--}}
                    <div class="form-actions">
                        <button type="submit" class="btn btn-large btn-info">Поиск</button>
                        <button type="reset" class="btn btn-large btn-danger">Очистить</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div><!--/span-->

</div><!--/row-->

@endsection()