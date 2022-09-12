<table>
    <thead>
        <tr>
            <th>তারিখ</th>
            <th>সনদের ধরণ</th>
            <th>টাকা</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($Products as $Product)
            <tr>

                <td>{{ $Product->date }}</td>
                @if($Product->sonod_type=='holdingtax')
                <td>হোল্ডিং ট্যাক্স</td>
                @else
                <td>{{ $Product->sonod_type }}</td>
                @endif

                <td>{{ $Product->amount }}</td>




            </tr>
        @endforeach
    </tbody>
</table>
