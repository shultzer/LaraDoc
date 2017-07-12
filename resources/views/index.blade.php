@include('header')
<div class="box-content">
    <h1>Приложение для контроля оборота документов по вопросам распоряжения государственным имуществом</h1>

    <table style="border: solid">
        <b>
            <caption>Последние письма организаций</caption>
        </b>
        <tr>
            <th>Наименование организации</th>
            <th>Категория имущества</th>
            <th>Дата письма</th>
            <th>Ссылка</th>
            <th>Номер письма</th>
        </tr>

        @foreach($companyletters as $row)
            <tr>
                <td><?=$row->company?></td>
                <td>@foreach($row->propertys as $property)
                    <?=$property->name?>
                    @endforeach
                </td>
                <td><?=$row->date?></td>
                <td><a href="<?=$row->doc?>"><img src="img/doc_pic.jpg"></a></td>
                <td><?=$row->number?></td>
            </tr>
        @endforeach
    </table>

    <table style=" float: right; border: solid">
        <b>
            <caption>Последние приказы</caption>
        </b>
        <tr>

            <th>Дата приказа</th>
            <th>Ссылка</th>
            <th>Номер приказа</th>
        </tr>

        @foreach($orders as $row)
            <tr>

                <td><?=$row->date?></td>
                <td><a href="<?=$row->doc?>"><img src="img/doc_pic.jpg"></a></td>
                <td><?=$row->number?></td>
            </tr>
        @endforeach
    </table>

</div>
@include('footer')