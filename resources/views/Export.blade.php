<table>
    <thead>
        <tr>
            <th>তারিখ</th>
            <th>সনদের ধরণ</th>
            <th>টাকা</th>
        </tr>
    </thead>
    <tbody>
        @php
            $total = 0;
        @endphp
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
            @php
            $total += $Product->amount;
        @endphp
        @endforeach

        <tr>

            <td colspan="2" style="text-align: right">মোট</td>


            <td>{{ $total }}</td>




        </tr>

    </tbody>
</table>
