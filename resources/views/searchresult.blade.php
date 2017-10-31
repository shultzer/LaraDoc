@include('header')
<div class="row-fluid sortable">
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
        </div>
    </div><!--/span-->
    @if(isset($companyletters))
        @php(dd($companyletters))
    @endif
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
        @if(isset($ar))
            {{--@php(dd($ar))--}}
            @foreach($ar as $completter)

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
                @endif
        </tbody>
    </table>

</div><!--/row-->

@include('footer')