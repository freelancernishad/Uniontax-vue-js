<template>
    <div>


           <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40"
           objectbg="#999793" opacity="80" name="circular"></loader>
    <div class="container my-4">
        <div class="container">
            <div class="row justify-content-center py-8 px-8 py-md-27 px-md-0">
                <div class="col-md-12 p-sm-0">


                    <form id="msform">
                        <!-- progressbar -->
                        <ul id="progressbar">
                            <li :class="{ active: aplication }" id="account"><strong>আবেদন জমা হয়েছে</strong></li>
                            <li :class="{ active: payment }" id="personal"><strong>পেমেন্ট</strong></li>
                            <li :class="{ active: sec }" id="payment"><strong>সেক্রেটারি</strong></li>
                            <li :class="{ active: chair }" id="confirm"><strong>চেয়ারম্যান</strong></li>
                            <li :class="{ active: complate }" id="confirm"><strong>কমপ্লিট</strong></li>

                        </ul>
                    </form>




                    <div class="d-flex justify-content-between">


                        <div class="col-md-12 p-sm-0">



                            <div class="text-right mb-2 no-print" v-if="row.renew_able">
                                <button type="button" @click="RenewSonod(row.renew_link)" class="btn btn-sm btn-success">Renew Sonod</button>
                            </div>

                            <div class="text-right mb-2 no-print" v-else>

                                <div v-if="Number(row.renewed)">
                                    <a :href="'/sonod/d/'+row.renewed_id" v-if="row.payment_status=='Paid'" target="_blank" class="btn btn-sm btn-success">Renewed Sonod Download</a>
                                </div>
                                <div v-else>

                                    <a :href="'/sonod/d/'+row.id" v-if="row.payment_status=='Paid'" target="_blank" class="btn btn-sm btn-success">Download</a>

                                    <a :href="'/sonod/d/'+row.id" v-if="row.payment_status=='Unpaid'" target="_blank" class="btn btn-sm btn-success">Pay</a>
                                </div>

                            </div>



                            <div class="border">
                                <div class="row m-0 mt-2">
                                    <div class="logo-img col-md-3 col-sm-12 text-right hide-mobile">
                                        <img :src="$asseturl+'assets/img/bd-logo.png'" />
                                    </div>
                                    <div class="header-text col-md-6 col-sm-12 text-center">
                                        <p>Government of the People's Republic of Bangladesh</p>
                                        <p>Local Government Division</p>
                                    </div>
                                    <div class="header-right-logo col-md-3 col-sm-12 text-left hide-mobile">
                                        <img :src="$asseturl+'assets/img/mujib100.75b35add.png'" />
                                    </div>
                                </div>
                                <div class="verification-sec text-center mt-2 mb-2">
                                    <h2>Verification Successful !</h2>
                                    <h2 v-if="row.payment_status=='Paid'">This Certificate is Valid.</h2>
                                    <h2 v-if="row.payment_status=='Unpaid'" style="color:red">This Certificate is Unpaid.</h2>
                                </div>
                            </div>




                            <div>
                                <div class="row m-0">
                                    <div class="col-md-5 p-0">
                                        <div class="beneficiary text-center p-2">
                                            <h3>Beneficiary Details (সনদ গ্রহণকারীর বিবরণ)</h3>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Certificate No:<br />সার্টিফিকেট নং:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                    {{ row.sonod_Id }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    NID Number:<br />জাতীয় পরিচয়পত্র নং:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                     {{ row.applicant_national_id_number }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Passport/Birth Registration:<br />পাসপোর্ট/জন্ম নিবন্ধন:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                    {{ row.applicant_passport_number }} {{ row.applicant_birth_certificate_number }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Country/Nationality:<br />দেশ/জাতীয়তা:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                    Bangladeshi
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Name:<br />নাম:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                    {{ row.applicant_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Date of Birth:<br />জন্ম তারিখ:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                    {{ row.applicant_date_of_birth }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Gender:<br />লিঙ্গ:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                      {{ row.applicant_gender }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7 p-0">
                                        <div class="beneficiary text-center p-2">
                                            <h3>Certificate Details (সনদ প্রদানের বিবরণ)</h3>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Date of Certificate Issue):<br />সনদ প্রদানের
                                                    তারিখ :
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                    {{ dateformatGlobal(row.created_at)[4] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Name of Certificate:<br />সনদের নাম:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                     {{ row.sonod_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Date of Certificate Renew:<br />সনদ নবায়নের তারিখ:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Payment Status:<br />লেনদেনের অবস্থা:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                      {{ row.payment_status }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Certification Union:<br />সনদ প্রদানের ইউনিয়ন:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                      {{ row.unioun_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Certifier By:<br />সনদ প্রদানকারী:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                      {{ row.unioun_name }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row m-0">
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-right cert-verify-content-div">
                                                    Total Certificate Given:<br />মোট সনদ সংখ্যা:
                                                </div>
                                            </div>
                                            <div class="col-6 border-dash">
                                                <div class="beneficiary-details-left cert-verify-content-div">
                                                   1
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <h3 v-if="row.sonod_name=='ওয়ারিশান সনদ'" class='mt-3'>ওয়ারিশগনের তালিকা নিম্নরুপঃ</h3>


                            <table v-if="row.sonod_name=='ওয়ারিশান সনদ'" width='100%' class='table'>
                                <thead>
                                    <tr>
                                        <th>ক্রমিক নং</th>
                                        <th>নাম</th>
                                        <th>সম্পর্ক</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(item,index) in successor_list" :key="`successor_list`+index">
                                        <td>{{ int_en_to_bn(index+1) }}</td>
                                        <td>{{ item.w_name }}</td>
                                        <td>{{ item.w_relation }}</td>
                                    </tr>
                                </tbody>
                            </table>





                            <!-- <div class="p-2 text-center border">
                                For any further assistance, please visit www.dghs.gov.bd or
                                e-mail: info@dghs.gov.bd <br />(প্রয়োজনে www.dghs.gov.bd ওয়েব
                                সাইটে ভিজিট করুন অথবা ইমেইল করুনঃ info@dghs.gov.bd)
                            </div>
                            <div class="beneficiary text-center p-2">
                                <h3>In Cooperation With</h3>
                            </div>
                            <div class="credit-Logo text-center p-2 mb-3 footer-cert-verify-img border">
                                <img :src="$asseturl+'assets/img/bnict.jpeg'" alt="ict logo" />
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
export default {
    data(){
        return{
            aplication: false,
            payment: false,
            sec: false,
            chair: false,
            complate: false,
            cancel: false,
            preLooding: false,
            row:{},
            successor_list:{}
        }
    },
    methods:{


        async RenewSonod(url){
            Swal.fire({
                title: 'আপনি কি নিশ্চিত?',
                text: `আবেদনটি রিনিউ করতে চান!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `হা নিশ্চিত`,
                cancelButtonText: `বাতিল`
            }).then(async (result) => {

                if (result.isConfirmed) {
                    this.preLooding = true;
                    var res = await this.callApi('get', `${url}`, []);
                    Notification.customSuccess(`আবেদনটি রিনিউ হয়েছে!`);

                    window.location.href = res.data;



                } else {
                    this.preLooding = false;
                }
            })
        },





        async sonodVerifiy(){







            if(this.$route.query.sonod_name && this.$route.query.sonod_Id){
                var sonod_name = this.$route.query.sonod_name;
                var sonod_Id = this.$route.query.sonod_Id;
                var res = await this.callApi('get',`/api/sonod/verify/get?sonod_name=${sonod_name}&sonod_Id=${sonod_Id}`);

            }else{
                var id =  this.$route.params.id;
                var res = await this.callApi('get',`/api/sonod/single/${id}`,[])

            }




            this.row = res.data
            this.successor_list = JSON.parse(this.row.successor_list)



                if (res.data.stutus == 'Pending' && res.data.payment_status == 'Unpaid') {
                    console.log('Unpaid');
                    this.aplication = true
                    this.payment = false
                    this.sec = false
                    this.chair = false
                    this.complate = false
                } else if (res.data.stutus == 'Pending' && res.data.payment_status == 'Paid') {
                    console.log('Paid');
                    this.aplication = true
                    this.payment = true
                    this.sec = false
                    this.chair = false
                    this.complate = false
                } else if (res.data.stutus == 'Secretary_approved' && res.data.payment_status == 'Paid') {
                    this.aplication = true
                    this.payment = true
                    this.sec = true
                    this.chair = false
                    this.complate = false
                } else if (res.data.stutus == 'approved' && res.data.payment_status == 'Paid') {
                    this.aplication = true
                    this.payment = true
                    this.sec = true
                    this.chair = true
                    this.complate = true
                }else {
                    console.log('nothing')
                }





        }



    },
    mounted() {







        this.sonodVerifiy()
    },
}
</script>
<style>
.border-dash {
  border: 1px dashed #dee2e6;
}

.logo-img img {
  width: 70px;
}

.header-right-logo img {
  width: 100px;
}

.header-text {
  font-size: 16px;
  line-height: 70px;
}
.header-text p:first-child {
  font-weight: 500;
  line-height: 18px;
  margin-bottom: 0px;
  margin-top: 18px;
}
.header-text p:last-child {
  line-height: 18px;
}

.verification-sec h2:first-child {
  font-size: 30px;
  color: green;
  font-weight: bold;
}
.verification-sec h2:last-child {
  font-size: 22px;
  color: green;
  font-weight: 350;
}

.beneficiary {
  background-color: #eeeeee;
  border: 1px solid #dee2e6;
}

.beneficiary h3 {
  text-align: center;
  font-size: 14px;
  font-weight: bold;
}

.beneficiary-details-right {
  font-size: 13px;
  text-align: right;
  padding: 5px;
  overflow-wrap: break-word;
}

.beneficiary-details-left {
  font-size: 13px;
  text-align: left;
  padding: 5px;
  overflow-wrap: break-word;
}

.lower-does-1 h3 {
  font-size: 13px;
  text-align: right;
  padding: 5px;
  font-weight: bold;
}
.lower-does-2 h3 {
  font-size: 13px;
  text-align: center;
  padding: 5px;
  font-weight: bold;
}
.lower-does-3 h3 {
  font-size: 13px;
  text-align: left;
  padding: 5px;
  font-weight: bold;
}

.lower-does-part-1 h3 {
  font-size: 13px;
  text-align: right;
  padding: 5px;
  overflow-wrap: break-word;
  text-transform: capitalize;
}
.lower-does-part-2 h3 {
  font-size: 13px;
  text-align: center;
  padding: 5px;
  overflow-wrap: break-word;
}
.lower-does-part-3 h3 {
  font-size: 13px;
  text-align: left;
  padding: 5px;
  overflow-wrap: break-word;
}

.credit-Logo img {
  max-width: 80%;
}

</style>
