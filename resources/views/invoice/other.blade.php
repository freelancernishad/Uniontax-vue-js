@php

$khatlist = $row->amount_deails;
        $khatlist = json_decode($khatlist);
        $total = $khatlist->tredeLisenceFee;
        $amount = ($total*$khatlist->vatAykor)/100;

        $totalAmount = $khatlist->pesaKor+$total+$amount;

    $html = "

    <table class='table ' style='width:100%;' cellspacing='0' cellpadding='0' border='1' >
  <thead>
    <tr>

      <th scope='col'>খাত/আদায়ের বিবরণ</th>
      <th scope='col'>বিগত বছরের বকেয়া (যদিথাকে) টাকা </th>
      <th scope='col'>বর্তমানে পরিশোধকৃত টাকা </th>
      <th scope='col'>মোট টাকার পরিমাণ</th>
      <th scope='col'>কর নির্ধারণী তালিকার ক্রমিক নং</th>
    </tr>
  </thead>
  <tbody>

    <tr>

      <td>".int_en_to_bn($row->khat)."</td>
      <td>".int_en_to_bn($row->last_years_money)."</td>
      <td>".int_en_to_bn($row->currently_paid_money)."</td>

      <td>".int_en_to_bn($row->total_amount)."</td>
      <td>".int_en_to_bn($row->applicant_holding_tax_number)."</td>
    </tr>


  </tbody>
</table>



    ";
    echo $html;
@endphp
