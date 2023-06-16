<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>অনলাইন দরপত্র দাখিল সিস্টেমে স্বাগতম</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <style>

*{
    margin:0;
    padding: 0;
}
p {
    margin-bottom: 2px;
}
#Header {
margin-bottom: 62px;
position: relative;
width: 100%;
height: 110px;
z-index: 1;
text-align: center;
}
.wrapper {
    margin: 0 auto;
    position: relative;
    width: 920px;
    z-index: 1;
    text-align: center;
    margin-top: 20px;
}
#Header img {
    width: 370px;
}


.countdown.styled {
    display: flex;
    justify-content: center;
    margin: 21px 13px;
    padding: 9px 2px;
    background: #076633;
    border-radius: 6px;
    flex-wrap: wrap;
}
.countdown.styled div {
    margin: 8px 6px;
    border: 1px solid white;
    padding: 9px;
    color: white;
    font-size: 15px;
    border-radius: 6px;
}
.footer {
    margin-top: 30px;
}
.form-control {
    border: 1px solid #076633 !important;
}

/*
.countdown.styled div {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: red;
    padding: 14px 25px;
    border-top-right-radius: 25px;
    border-bottom-left-radius: 25px;
    max-width: 130px;
    min-width: 130px;
    margin: 10px;
}

.countdown.styled div span {
    color: white;
    font-size: 24px;
} */
@media(max-width:420px){
    #Header img {
    width: 80%;
    }

}

    </style>


</head>
<body>





<div id="Header">

        {{-- <h1>Orange</h1> --}}

        <img src="{{ asset('assets/img/mail_logo-01.png') }}" alt="">
        <br>
        <img src="{{ asset('es-01.png') }}" alt="">
        <br>
        <br>


    </div>
    <div id="Content">
        <div class="countdown styled">
            <div>দরপত্র দাখিলের শেষ সময়</div>

        <div>
            <span id="days">000</span> <span>days</span>
        </div>
        <div>
            <span id="hrs">00</span> <span>hrs</span>
        </div>
        <div>
            <span id="min">00</span> <span>min</span>
        </div>
        <div>
            <span id="sec">00</span> <span>sec</span>
        </div>
    </div>

    </div>










    <div class="container">


        @if(Session::has('Smessage'))

            <div class="alert alert-success" role="alert">
                {{ Session::get('Smessage') }}
              </div>
        @endif

        @if(Session::has('Fmessage'))

            <div class="alert alert-danger" role="alert">
                 {{ Session::get('Fmessage') }}
          </div>
        @endif





    <form method="POST" enctype="multipart/form-data" action="/form/submit">
        @csrf


        <input type="hidden" name="tender_id" value="{{ $tender_list->id }}">

        <div class="row">

        <div class="col-md-12 mt-3 d-none">
        <div class="form-group">
          <label class="mb-1" for="dorId">দাখিলকৃত দরপত্র নম্বর</label>
          <input type="hidden" class="form-control" id="dorId" value="{{ $dorId }}" name="dorId" required>
        </div>
    </div>

    <div class="col-md-12 mt-3 my-3">

        {{-- <p>দাখিলকৃত দরপত্র নম্বর: {{ $dorId }}</p> --}}
        <p>বিজ্ঞপ্তির তারিখ: {{ int_en_to_bn(date('d/m/Y', strtotime($tender_list->created_at))) }}</p>
        <p>স্মারক নং-১২০</p>
        <p>নিলামের বিবরণ- {{ $tender_list->description }}</p>

    </div>




{{--
    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="email">ইমেইল</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
    </div> --}}


    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="applicant_orgName">দরপত্র দাখিলকারীর নাম</label>
          <input type="text" class="form-control" id="applicant_orgName" name="applicant_orgName" required>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="applicant_org_fatherName">পিতার নাম</label>
          <input type="text" class="form-control" id="applicant_org_fatherName" name="applicant_org_fatherName" required>
        </div>
    </div>



    <div class="col-md-12 mt-3 ">
        <div class="form-group">
          <label class="mb-1" for="address">ঠিকানা</label>
        </div>



<div class="row">
    <div class="col-md-3 mt-3">
        <div class="form-group">
          <label class="mb-1" for="vill">গ্রাম</label>
          <input type="text" class="form-control" id="addvilless" name="vill" required>
        </div>
    </div>


    <div class="col-md-3 mt-3">
        <div class="form-group">
          <label class="mb-1" for="postoffice">ডাকঘর</label>
          <input type="text" class="form-control" id="postoffice" name="postoffice" required>
        </div>
    </div>


    <div class="col-md-3 mt-3">
        <div class="form-group">
          <label class="mb-1" for="thana">উপজেলা</label>
          <input type="text" class="form-control" id="thana" name="thana" required>
        </div>
    </div>

    <div class="col-md-3 mt-3">
        <div class="form-group">
          <label class="mb-1" for="distric">জেলা</label>
          <input type="text" class="form-control" id="distric" name="distric" required>
        </div>
    </div>
</div>
</div>


    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="mobile">মোবাইল নম্বর</label>
          <input type="text" class="form-control" id="mobile" name="mobile" required>
        </div>
    </div>

    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="DorAmount">দাখিলকৃত দরের পরিমাণ (টাকা)</label>
          <input type="number" min="{{ $tender_list->govt_price+1 }}"  class="form-control" id="DorAmount" name="DorAmount" required>
        </div>
    </div>


    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="DorAmountText">কথায়</label>
          <input type="text" class="form-control" id="DorAmountText" name="DorAmountText" required>
        </div>
    </div>


    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="depositAmount">৩০% জামানত হিসেবে ব্যাংক ড্রাফট/পে অর্ডারের পরিমাণ (টাকা)</label>
          <input type="text" class="form-control" id="depositAmount" name="depositAmount" required>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="bank_draft_image">ব্যাংক ড্রাফট/পে-অর্ডারের ছবি আপলোড করুন</label>
          <input type="file" class="form-control" id="bank_draft_image" name="bank_draft_image" required>
        </div>
    </div>
    <div class="col-md-12 mt-3">
        <div class="form-group">
          <label class="mb-1" for="deposit_details">দরপত্র সিডিউলের ছবি আপলোড করুন</label>
          <input type="file" class="form-control" id="deposit_details" name="deposit_details" required>
        </div>
    </div>


    </div>

        <button type="submit" class="btn btn-info mt-5">দরপত্র দাখিল করুন</button>
      </form>




      <div class="footer" style="text-align: center">


        <img width="100%" src="{{ asset('footer-01.png') }}" alt="">


    </div>


    </div>




<script>
    // Set the date we're counting down to
    var countDownDate = new Date("<?php echo $tender_list->tender_end; ?>").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Display the result in the element with id="countdown-timer"
        document.getElementById("days").innerHTML = days;
        document.getElementById("hrs").innerHTML = hours;
        document.getElementById("min").innerHTML = minutes;
        document.getElementById("sec").innerHTML = seconds;

        // document.getElementById("countdown-timer").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            console.log('expired');
            window.location.reload();

            document.getElementById("countdown-timer").innerHTML = "EXPIRED";
        }
    }, 1000);
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@if(Session::has('Smessage'))
<script>
    Swal.fire({
      icon: 'success',
      title: "<?php echo Session::get('Smessage') ?>",
    })
    </script>

@endif

@if(Session::has('Fmessage'))
<script>
    Swal.fire({
      icon: 'error',
      title: "<?php echo Session::get('Fmessage') ?>",
    })
    </script>
@endif


</body>
</html>
