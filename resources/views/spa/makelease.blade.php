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
                <h2><i class="halflings-icon white edit"></i><span class="break"></span>Аренда
                </h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
                </div>
            </div><div class="box-content">

                <form class="form-horizontal" method="post" action="{{ route('make_lease_letter') }}" enctype="multipart/form-data">
                    <fieldset>
                        {{ csrf_field() }}
                        <div class="control-group">
                            <label class="control-label">Категория имущества</label>
                            <div class="controls">
                                <label class="radio">
                                    <span class="checked">
                                        <input type="radio" value="nomovable" name="mov" class="radio">
                                    </span>
                                    недвижимое
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked">
                                        <input type="radio" name="mov" value="movable" class="radio">
                                    </span>
                                    движимое
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked">
                                        <input type="radio" name="mov" value="mixed" class="radio">
                                    </span>
                                    смешанное
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked">
                                        <input type="radio" name="mov" value="vehicle" class="radio">
                                    </span>
                                    транспортное средство
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Новый договор?</label>
                            <div class="controls">
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="dog" value="new"
                                                                 class="radio"></span>
                                    новый договор
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="dog" value="old"
                                                                 class="radio"></span>
                                    дополнительное соглашение
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Вид аренды</label>
                            <div class="controls">
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="type" value="pay"
                                                                 class="radio"></span>
                                    возмездно
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="type" value="free"
                                                                 class="radio"></span>
                                    безвозмездно
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                            <span class="checked"><input type="radio" name="type" value="payfree"
                                                         class="radio"></span>
                                    смешанное
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Период аренды</label>
                            <div class="controls">
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="cont" value="mounthly"
                                                                 class="radio"></span>
                                    Длительная
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                            <span class="checked"><input type="radio" name="cont" value="hourly"
                                                         class="radio"></span>
                                    Почасовая
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Наличие стен, потолка</label>
                            <div class="controls">
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="wall" value="true"
                                                                 class="radio"></span>
                                    Eсть
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="wall" value="false"
                                                                 class="radio"></span>
                                    Нет
                                </label>
                                <div style="clear:both"></div>
                                <label class="radio">
                                    <span class="checked"><input type="radio" name="wall" value="mix" class="radio"></span>
                                    смешанное
                                </label>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="typeahead">Номер письма организации</label>
                            <div class="controls">
                                <input type="text" name="number" class="input-xlarge datepicker" id="typeahead">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="date01">Дата письма организации</label>
                            <div class="controls">
                                <input type="text" name="date" class="input-xlarge datepicker" id="date01"
                                       placeholder="xx.xx.xxxx">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="period">на срок по</label>
                            <div class="controls">
                                <input type="text" name="period" class="input-xlarge datepicker" id="period"
                                       placeholder="xx.xx.xxxx">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="property">Имущество</label>
                            <div class="controls">
                                <input type="text" name="property" class="input-xlarge datepicker" id="property">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="arendodatel">Арендодатель:</label>
                            <div class="controls">
                                <input type="text" name="filial" class="input-xlarge datepicker" id="arendodatel"
                                       placeholder="филиал">
                                <input type="text" name="arendodatel" class="input-xlarge datepicker" id=""
                                       placeholder="организация">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="address">Расположенной:</label>
                            <div class="controls">
                                <input type="text" name="address" class="input-xlarge datepicker" id="address"
                                       placeholder="адрес">
                            </div>
                        </div>
                        <example-component></example-component>

                        <div class="control-group">
                            <label class="control-label" for="target">Для размещения:</label>
                            <div class="controls">
                                <input type="text" name="target" class="input-xlarge datepicker" id="target"
                                       placeholder="цель">
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit"  class="btn btn-large btn-info">Создать</button>
                            <button type="reset" class="btn btn-large btn-danger">отмена</button>
                        </div>
                    </fieldset>
                </form>
            </div>

        </div><!--/span-->
    </div><!--/row-->


@endsection()