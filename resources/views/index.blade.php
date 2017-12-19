@extends('layouts.test')

@section('content')
    <div class="box-content">
        @if(session('status') !== NULL)
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <div class="row-fluid">

            <div class="box span6">
                <div class="box-header">
                    <h2>Последние письма организаций</h2>
                </div>
                <div class="box-content">
                    <table class="table table-stripped">
                        <tr>
                            <th>Ссылка</th>
                            <th>Номер письма</th>
                            <th>Дата письма</th>
                            <th>Наименование организации</th>
                            <th>Категория имущества</th>
                        </tr>
                        @foreach($companyletters as $row)
                            <tr>
                                <td><a href="<?=$row->doc?>"><img src="img/doc_pic.jpg"></a></td>
                                <td><?=$row->number?></td>
                                <td><?=$row->date?></td>
                                <td><?=$row->company?></td>
                                <td>@foreach($row->propertys as $property)
                                        <?=$property->name?> <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Общее количество писем</td>
                            <td></td>
                            <td></td>
                            <td>{{ $numletters }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="box span6">
                <div class="box-header">
                    <h2>Не направленные ходатайства</h2>
                </div>
                <div class="box-content">
                    <table class="table table-stripped">
                        <tr>
                            <th>Ссылка</th>
                            <th>Номер ходатайства</th>
                            <th>дата письма</th>
                            <th>Наименование организации</th>
                        </tr>
                        @foreach($complettersWhithoutspaletter as $row)
                            <tr>
                                <td><a href="<?=$row->doc?>"><img src="img/doc_pic.jpg"></a></td>
                                <td><?=$row->number?></td>
                                <td><?=$row->date?></td>
                                <td><?=$row->company?></td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="box span6">
                <div class="box-header">
                    <h2> Неисполненные приказы</h2>
                </div>
                <div class="box-content">
                    <table class="table table-stripped">
                        <tr>
                            {{--<th>Ссылка</th>--}}
                            <th>Номер приказа</th>

                            <th>Неисполнители</th>

                        </tr>
                        @foreach($orderswhithoutreports as $prikaz => $rup)

                            <tr>
                                <td><?=$prikaz?></td>

                                <td>@foreach($rup as $item)

                                        <a href="{{ $item->doc }}">{{ $item->company }}, №{{ $item->number }}</a> <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="box span6">
                <div class="box-header">
                    <h2>Ходатайства без приказов</h2>
                </div>
                <div class="box-content">
                    <table class="table table-stripped">
                        <tr>
                            <th>Ссылка</th>
                            <th>Номер письма</th>
                            <th>дата письма</th>
                            <th>Наименование организации</th>
                            <th>Категория имущества</th>
                        </tr>
                        @foreach($complettersWhithoutorder as $row)
                            <tr>
                                <td><a href="<?=$row->doc?>"><img src="img/doc_pic.jpg"></a></td>
                                <td><?=$row->number?></td>
                                <td><?=$row->date?></td>
                                <td><?=$row->company?></td>
                                <td>@foreach($row->propertys as $property)
                                        <?=$property->name?> <br>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection