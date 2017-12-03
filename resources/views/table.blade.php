@include('header')

<div class="box-content">
    @if(session('status') !== NULL)
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <div class="row-fluid">
        <div class="box span12">
            <div class="box-header" data-original-title>
                <h2><i class="halflings-icon white user"></i><span class="break"></span>Документооборот</h2>
            </div>
            <div class="box-content">
                <a href="{{ route('toexcel') }}">Выгрузить</a>
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                    <thead>
                    <tr>
                        <th colspan="4">Ходатайство Организации</th>
                        <th colspan="2">Письмо ГПО "Белэнерго"</th>
                        <th colspan="2">Приказ Минэнерго</th>
                        <th colspan="2" rowspan="2">Отчет о приемке</th>
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
                    <tr>
                        <th colspan="10">Брестэнерго</th>
                    </tr>
                    @if(isset($ar['brestenergo']) && is_array($ar['brestenergo']))
                        @foreach($ar['brestenergo'] as $completter)

                            <tr>
                                <td>
                                    <a href="{{ $completter['comletter']->doc }}"
                                       target="_blank"> {{ $completter['comletter']->number }}</a>
                                </td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>
                                    @foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                    @endforeach
                                </td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>
                                    @if(isset($completter['spaletter']->number))
                                        <a href="{{ $completter['spaletter']->doc }}"
                                           target="_blank">{{ $completter['spaletter']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>
                                    @if(isset($completter['order']->number))
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['report']->number))
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank"> {{ $completter['report']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        {{--<tr>
                            <th colspan="3">Итого</th>
                            <td>@if(isset($ar['brestvolume']['volume'])){{ array_sum($ar['brestvolume']['volume']) }}@endif
                            <td>
                            <td>@if(isset($ar['brestvolume']['spavolume'])){{ array_sum($ar['brestvolume']['spavolume']) }}@endif
                            <td>
                            <td>@if(isset($ar['brestvolume']['ordervolume'])){{ array_sum($ar['brestvolume']['ordervolume']) }}@endif
                            <td>
                            <td>@if(isset($ar['brestvolume']['reportvolume'])){{ array_sum($ar['brestvolume']['reportvolume']) }}@endif</td>
                        </tr>--}}
                    @endif
                    <tr>
                        <th colspan="10">Витебскэнерго</th>
                    </tr>
                    @if(isset($ar['vitebsk']) && is_array($ar['vitebsk']))
                        @foreach($ar['vitebsk'] as $completter)
                            @php($ar['vitebsk']['volume'][] = $completter['comletter']->volume)
                            <tr>
                                <td><a href="{{ $completter['comletter']->doc }}"
                                       target="_blank">{{ $completter['comletter']->number }}</a></td>
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
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank">{{ $completter['report']->number }}</a>
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
                        {{--<tr>
                            <th colspan="3">Итого</th>
                            <td>@if(isset($ar['vitebskvolume']['volume'])){{ array_sum($ar['vitebskvolume']['volume']) }}@endif
                            <td>
                            <td>@if(isset($ar['vitebskvolume']['spavolume'])){{ array_sum($ar['vitebskvolume']['spavolume']) }}@endif
                            <td>
                            <td>@if(isset($ar['vitebskvolume']['ordervolume'])){{ array_sum($ar['vitebskvolume']['ordervolume']) }}@endif
                            <td>
                            <td>@if(isset($ar['vitebskvolume']['reportvolume'])){{ array_sum($ar['vitebskvolume']['reportvolume']) }}@endif</td>
                        </tr>--}}
                    @endif
                    <tr>
                        <th colspan="10">Гродноэнерго</th>
                    </tr>
                    @if(isset($ar['grodno']) && is_array($ar['grodno']))
                        @foreach($ar['grodno'] as $completter)
                            @php($ar['grodno']['volume'][] = $completter['comletter']->volume)
                            <tr>
                                <td><a href="{{ $completter['comletter']->doc }}"
                                       target="_blank">{{ $completter['comletter']->number }}</a></td>
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
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
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
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank">{{ $completter['report']->date }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endif
                    {{--<tr>
                        <th colspan="3">Итого</th>
                        <td>@if(isset($ar['grodnovolume']['volume'])){{ array_sum($ar['grodnovolume']['volume']) }}@endif
                        <td>
                        <td>@if(isset($ar['grodnovolume']['spavolume'])){{ array_sum($ar['grodnovolume']['spavolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['grodnovolume']['ordervolume'])){{ array_sum($ar['grodnovolume']['ordervolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['grodnovolume']['reportvolume'])){{ array_sum($ar['grodnovolume']['reportvolume']) }}@endif</td>
                    </tr>--}}
                    <tr>
                        <th colspan="10">Гомельэнерго</th>
                    </tr>
                    @if(isset($ar['gomel']) && is_array($ar['gomel']))
                        @foreach($ar['gomel'] as $completter)
                            @php($ar['gomel']['volume'][] = $completter['comletter']->volume)
                            <tr>
                                <td><a href="{{ $completter['comletter']->doc }}"
                                       target="_blank">{{ $completter['comletter']->number }}</a></td>
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
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank">{{ $completter['report']->number }}</a>
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
                    {{--<tr>
                        <th colspan="3">Итого</th>
                        <td>@if(isset($ar['gomelvolume']['volume'])){{ array_sum($ar['gomelvolume']['volume']) }}@endif
                        <td>
                        <td>@if(isset($ar['gomelvolume']['spavolume'])){{ array_sum($ar['gomelvolume']['spavolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['gomelvolume']['ordervolume'])){{ array_sum($ar['gomelvolume']['ordervolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['gomelvolume']['reportvolume'])){{ array_sum($ar['gomelvolume']['reportvolume']) }}@endif</td>
                    </tr>--}}
                    <tr>
                        <th colspan="10">Могилевэнерго</th>
                    </tr>
                    @if(isset($ar['mogilev']) && is_array($ar['mogilev']))
                        @foreach($ar['mogilev'] as $completter)
                            @php($ar['mogilev']['volume'][] = $completter['comletter']->volume)
                            <tr>
                                <td><a href="{{ $completter['comletter']->doc }}"
                                       target="_blank">{{ $completter['comletter']->number }}</a></td>
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
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank">{{ $completter['report']->number }}</a>
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
                    {{--<tr>
                        <th colspan="3">Итого</th>
                        <td>@if(isset($ar['mogilevvolume']['volume'])){{ array_sum($ar['mogilevvolume']['volume']) }}@endif
                        <td>
                        <td>@if(isset($ar['mogilevvolume']['spavolume'])){{ array_sum($ar['mogilevvolume']['spavolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['mogilevvolume']['ordervolume'])){{ array_sum($ar['mogilevvolume']['ordervolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['mogilevvolume']['reportvolume'])){{ array_sum($ar['mogilevvolume']['reportvolume']) }}@endif</td>
                    </tr>--}}
                    <tr>
                        <th colspan="10">Минскэнерго</th>
                    </tr>
                    @if(isset($ar['minsk']) && is_array($ar['minsk']))
                        @foreach($ar['minsk'] as $completter)
                            @php($ar['minsk']['volume'][] = $completter['comletter']->volume)
                            <tr>
                                <td><a href="{{ $completter['comletter']->doc }}"
                                       target="_blank">{{ $completter['comletter']->number }}</a></td>
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
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>@if(isset($completter['report']->number))
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank">{{ $completter['report']->number }}</a>
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
                    <tr>
                        <th colspan="10">Белтэи</th>
                    </tr>
                    @if(isset($ar['beltei']) && is_array($ar['beltei']))
                        @foreach($ar['beltei'] as $completter)
                            <tr>
                                <td>
                                    <a href="{{ $completter['comletter']->doc }}"
                                       target="_blank"> {{ $completter['comletter']->number }}</a>
                                </td>
                                <td>{{ $completter['comletter']->date }}</td>
                                <td>
                                    @foreach($completter['comletter']->propertys as $property)
                                        {{ $property->name }} <br>
                                    @endforeach
                                </td>
                                <td>{{ $completter['comletter']->volume }}</td>
                                <td>
                                    @if(isset($completter['spaletter']->number))
                                        <a href="{{ $completter['spaletter']->doc }}"
                                           target="_blank">{{ $completter['spaletter']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['spaletter']->date))
                                        {{ $completter['spaletter']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>

                                <td>
                                    @if(isset($completter['order']->number))
                                        <a href="{{ $completter['order']->doc }}"
                                           target="_blank">{{ $completter['order']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['order']->date))
                                        {{ $completter['order']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['report']->number))
                                        <a href="{{ $completter['report']->doc }}"
                                           target="_blank"> {{ $completter['report']->number }}</a>
                                    @else {{ '' }}
                                    @endif
                                </td>
                                <td>
                                    @if(isset($completter['report']->date))
                                        {{ $completter['report']->date }}
                                    @else {{ '' }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        {{--<tr>
                            <th colspan="3">Итого</th>
                            <td>@if(isset($ar['brestvolume']['volume'])){{ array_sum($ar['brestvolume']['volume']) }}@endif
                            <td>
                            <td>@if(isset($ar['brestvolume']['spavolume'])){{ array_sum($ar['brestvolume']['spavolume']) }}@endif
                            <td>
                            <td>@if(isset($ar['brestvolume']['ordervolume'])){{ array_sum($ar['brestvolume']['ordervolume']) }}@endif
                            <td>
                            <td>@if(isset($ar['brestvolume']['reportvolume'])){{ array_sum($ar['brestvolume']['reportvolume']) }}@endif</td>
                        </tr>--}}
                    @endif
                    {{--<tr>
                        <th colspan="3">Итого</th>
                        <td>@if(isset($ar['minskvolume']['volume'])){{ array_sum($ar['minskvolume']['volume']) }}@endif
                        <td>
                        <td>@if(isset($ar['minskvolume']['spavolume'])){{ array_sum($ar['minskvolume']['spavolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['minskvolume']['ordervolume'])){{ array_sum($ar['minskvolume']['ordervolume']) }}@endif
                        <td>
                        <td>@if(isset($ar['minskvolume']['reportvolume'])){{ array_sum($ar['minskvolume']['reportvolume']) }}@endif</td>
                    </tr>--}}
                    {{--TODO: add other companies--}}
                    {{--<tr>
                        <th colspan="3">Итого по Белэнерго</th>
                        <td>{{ $completter['comletter']->sum('volume') }}</td>
                        <th colspan="6"></th>
                    </tr>--}}
                    </tbody>
                </table>
            </div>
        </div><!--/span-->
    </div>
</div>
@include('footer')