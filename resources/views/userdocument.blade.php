<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>



</head>

<body style="font-family: 'bangla', sans-serif;">

    <div class="pdfhead" style="text-align:center">
    <div style=":center;"  >
        <img width="70px" src="{{ base64('backend/bd-logo.png') }}" />
    </div>

    <div style="width:300px;margin:0 auto;" ><p style="margin-bottom:0 !important;font-size:16px">  গণপ্রজাতন্ত্রী বাংলাদেশ <br>{{ $uniouninfo->full_name }} <br>
        উপজেলা:  {{ $uniouninfo->thana }}, জেলা:  {{ $uniouninfo->district }} ।

    </p></div>

    <p style="text-align:center" >   <span style="margin-bottom:0px !important; font-size:40px;color:red;" >অভিনন্দন !</span>  <br> <p style="font:size:16px;color:blue;margin-bottom:0px !important;">ইউনিয়ন পরিষদ ডিজিটাল সেবা সিস্টেমে আপনার আবেদনটি যথাযথভাবে দাখিল হয়েছে।</p>

    </div>

            <p>
            সেবার ধরণ :  {{ $row->sonod_name }} <br>
        আবেদনের ক্রমিক নং	: {{ int_en_to_bn($row->sonod_Id) }} <br>
        আবেদনের তারিখ	: {{ int_en_to_bn(date("d/m/Y", strtotime($row->created_at))) }} <br>
        আবেদনকারীর নাম	: {{ $row->applicant_name }} <br>
        এনআইডি নং	: {{ int_en_to_bn($row->applicant_national_id_number) }} <br>
        পিতা/স্বামীর নাম	: {{ $row->applicant_father_name }} <br>

        বর্তমান ঠিকানা	: হোল্ডিং নং- {{ $row->applicant_holding_tax_number }}, গ্রাম: {{ $row->applicant_present_village }}, ডাকঘর: {{ $row->applicant_present_post_office }}, উপজেলা: {{ $row->applicant_present_Upazila }} , জেলা: {{ $row->applicant_present_district }}। <br>

        মোবাইল নম্বর	: {{ int_en_to_bn($row->applicant_mobile) }} <br>

        </p>


    <p style="text-align:center" >শীগ্রই আপনার আবেদনটি কর্তৃপক্ষ কর্তৃক যথাযথ প্রক্রিয়ায় অনুমোদন করা হবে। <br>
    ইউনিয়ন পরিষদ ডিজিটাল সেবা সিস্টেমের সাথে জন্য ধনব্যাদ।
    </p>


    </div>




</body>

</html>
