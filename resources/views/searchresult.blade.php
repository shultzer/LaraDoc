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

                @foreach($ar as $item)
                    {{-- @php(dd($item))--}}
                    <tr>
                        <td>
                            <a href="{{ $item['comletter']->doc }}"
                               target="_blank"> {{ $item['comletter']->number }}</a>
                        </td>
                        <td>{{ $item['comletter']->date }}</td>
                        <td>
                            @foreach($item['comletter']->propertys as $property)
                                {{ $property->name }} <br>
                            @endforeach
                        </td>
                        <td>{{ $item['comletter']->volume }}</td>
                        <td>
                            @if(isset($item['spaletter']->number))
                                <a href="{{ $item['spaletter']->doc }}"
                                   target="_blank">{{ $item['spaletter']->number }}</a>
                            @else {{ '' }}
                            @endif
                        </td>
                        <td>
                            @if(isset($item['spaletter']->date))
                                {{ $item['spaletter']->date }}
                            @else {{ '' }}
                            @endif
                        </td>

                        <td>
                            @if(isset($item['order']->number))
                                <a href="{{ $item['order']->doc }}"
                                   target="_blank">{{ $item['order']->number }}</a>
                            @else {{ '' }}
                            @endif
                        </td>
                        <td>
                            @if(isset($item['order']->date))
                                {{ $item['order']->date }}
                            @else {{ '' }}
                            @endif
                        </td>
                        <td>
                            @if(isset($item['report']->number))
                                <a href="{{ $item['report']->doc }}"
                                   target="_blank"> {{ $item['report']->number }}</a>
                            @else {{ '' }}
                            @endif
                        </td>
                        <td>
                            @if(isset($item['report']->date))
                                {{ $item['report']->date }}
                            @else {{ '' }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div><!--/span-->
</div><!--/row-->

@include('footer')