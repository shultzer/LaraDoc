<table>
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
    @foreach(\App\Http\Controllers\IndexController::getcompanies() as $key => $value)
        <tr>
            <th colspan="10">{{ $value }}</th>
        </tr>
        @if(isset($ar[$key]) && is_array($ar[$key]))
            @foreach($ar[$key] as $completter)

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
    @endforeach







    {{--<tr>
        <th colspan="3">Итого по Белэнерго</th>
        <td>{{ $completter['comletter']->sum('volume') }}</td>
        <th colspan="6"></th>
    </tr>--}}
    </tbody>
</table>
