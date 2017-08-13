@include('header')
<div class="box-content">
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white user"></i><span class="break"></span>Документооборот</h2>
                <div class="box-icon">
                    <a href="#" class="btn-setting"><i class="halflings-icon white wrench"></i></a>
                    <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
                    <a href="#" class="btn-close"><i class="halflings-icon white remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                    <thead>
                    <tr>
                        <th colspan="4">Ходатайство Организации</th>
                        <th colspan="2">Письмо ГПО "Белэнерго"</th>
                        <th colspan="2">Приказ Минэнерго</th>
                        <th rowspan="2" colspan="2">Отчет о приемке</th>
                    </tr>
                    <tr>
                        <th>№</th>
                        <th>Дата</th>
                        <th>Имущество</th>
                        <th>Длинна, метры</th>
                        <th>№</th>
                        <th>Дата</th>
                        <th>№</th>
                        <th>Дата</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><th colspan="10">Брестэнерго</th></tr>
                    @if(isset($ar['brest']) && is_array($ar['brest']))
                        @foreach($ar['brest'] as $completter)
                            {{--@php(dd($completter['comletter']->propertys))--}}
                            <tr>
                                <td><a href="{{ $completter['comletter']->doc }}"> {{ $completter['comletter']->number }}</a></td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>@foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                        @endforeach
                                </td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>@if(isset($completter['spaletter']->number))
                                        {{ $completter['spaletter']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>@if(isset($completter['order']->number))
                                        {{ $completter['order']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        {{ $completter['report']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    <tr><th colspan="10">Витебскэнерго</th> </tr>
                    @if(isset($ar['vitebsk']) && is_array($ar['vitebsk']))
                    @foreach($ar['vitebsk'] as $completter)
                        <tr>
                            <td>{{ $completter['comletter']->number }}</td>
                            <td>{{ $completter['comletter']->date }}</td>
                            <td>@foreach($completter['comletter']->propertys as $property)
                                    {{ $property->name }} <br>
                                @endforeach</td>
                            <td>{{ $completter['comletter']->volume }}</td>
                            <td>@if(isset($completter['spaletter']->number))
                                    {{ $completter['spaletter']->number }}
                                @else {{ '' }}
                                @endif
                            </td>
                            <td>@if(isset($completter['spaletter']->date))
                                    {{ $completter['spaletter']->date }}
                                @else {{ '' }}
                                @endif
                            </td>

                            <td>@if(isset($completter['order']->number))
                                    {{ $completter['order']->number }}
                                @else {{ '' }}
                                @endif
                            </td>
                            <td>@if(isset($completter['order']->date))
                                    {{ $completter['order']->date }}
                                @else {{ '' }}
                                @endif
                            </td>
                            <td>@if(isset($completter['report']->number))
                                    {{ $completter['report']->number }}
                                @else {{ '' }}
                                @endif
                            </td>
                            <td>@if(isset($completter['report']->date))
                                    {{ $completter['report']->date }}
                                @else {{ '' }}
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    @endif
                    <tr><th colspan="10">Гродноэнерго</th> </tr>
                    @if(isset($ar['grodno']) && is_array($ar['grodno']))
                        @foreach($ar['grodno'] as $completter)
                            <tr>
                                <td>{{ $completter['comletter']->number }}</td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>@foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                    @endforeach</td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>@if(isset($completter['spaletter']->number))
                                        {{ $completter['spaletter']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>@if(isset($completter['order']->number))
                                        {{ $completter['order']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        {{ $completter['report']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    <tr><th colspan="10">Гомельэнерго</th> </tr>
                    @if(isset($ar['gomel']) && is_array($ar['gomel']))
                        @foreach($ar['gomel'] as $completter)
                            <tr>
                                <td>{{ $completter['comletter']->number }}</td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>@foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                    @endforeach</td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>@if(isset($completter['spaletter']->number))
                                        {{ $completter['spaletter']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>@if(isset($completter['order']->number))
                                        {{ $completter['order']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        {{ $completter['report']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    <tr><th colspan="10">Могилевэнерго</th></tr>
                    @if(isset($ar['mogilev']) && is_array($ar['mogilev']))
                        @foreach($ar['mogilev'] as $completter)
                            <tr>
                                <td>{{ $completter['comletter']->number }}</td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>@foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                    @endforeach</td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>@if(isset($completter['spaletter']->number))
                                        {{ $completter['spaletter']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>@if(isset($completter['order']->number))
                                        {{ $completter['order']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        {{ $completter['report']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    <tr><th colspan="10">Минскэнерго</th> </tr>
                    @if(isset($ar['minsk']) && is_array($ar['minsk']))
                        @foreach($ar['minsk'] as $completter)
                            <tr>
                                <td>{{ $completter['comletter']->number }}</td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>@foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                    @endforeach</td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>@if(isset($completter['spaletter']->number))
                                        {{ $completter['spaletter']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>@if(isset($completter['order']->number))
                                        {{ $completter['order']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        {{ $completter['report']->number }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div><!--/span-->

    </div>
</div>
@include('footer')