<template>
        <form v-on:submit.prevent="formsubmit">
    <div class="row">

            <div class="col-md-12"  style="display:none">
                <h5>আবেদনকৃত প্রত্যয়নের বিবরণ</h5>
                <p>{{ Details.prottoyon }}</p>
            </div>
            <div class="col-md-12"  style="display:none">
                <div class="form-group" >
                    <label for="amountab">প্রত্যয়ন প্রদানের বিবরণ </label>
                    <textarea v-model="form.sec_prottoyon" class="form-control"
                        style="height:100px;resize:none" :readonly="readonly"></textarea>
                </div>
            </div>




  <div class="col-md-4" v-if="Details.payment_status == 'Unpaid'">
    <div class="form-group">
        <label for="pesaKor">পেশা কর </label>
        <input id="pesaKor" @keyup="totalAmount()" class="form-control" type="number" v-model="form.pesaKor">
    </div>
</div>

  <div class="col-md-4" v-if="Details.payment_status == 'Unpaid'">
    <div class="form-group">
        <label for="tredeLisenceFee">ট্রেড লাইসেন্স ফি </label>
        <input id="tredeLisenceFee" @keyup="totalAmount()"  class="form-control" type="number" v-model="form.tredeLisenceFee">
    </div>
</div>

  <div class="col-md-4" v-if="Details.payment_status == 'Unpaid'">
    <div class="form-group">
        <label for="vatAykor">ভ্যাট ও আয়কর (%) </label>
        <input id="vatAykor" @keyup="totalAmount()"  class="form-control" type="number" v-model="form.vatAykor">
    </div>
</div>

  <div class="col-md-6" v-if="Details.payment_status == 'Unpaid'">
    <div class="form-group">
        <label for="amounta">মোট </label>
        <input id="amounta" class="form-control" type="number" v-model="form.amounta" disabled >
    </div>
</div>

<div class="col-md-12">

        <input id="submit" class="btn btn-info" type="submit"  value="Approve">

</div>

        </div>
        </form>
</template>

<script>


export default {

props: {
        ApproveData: {
            type: String,
            default: 'sec_approved'
        },
        SonodId: {
            type: String,
            default: '0'
        },

        'Details': {
            type: Object,
            default: {}
        },
},
    data() {
        return {
            readonly:true,
            form:{
            pesaKor:0,
            tredeLisenceFee:0,
            vatAykor:3,
            amounta:0,
            approveData:0,
            sec_prottoyon:'',
            }

        }
    },
    methods: {


            totalAmount(){
            var pesaKor;
            var tredeLisenceFee;
            var vatAykor;
            pesaKor = parseInt(this.form.pesaKor);
            tredeLisenceFee = parseInt(this.form.tredeLisenceFee);
            vatAykor = parseInt(this.form.vatAykor);


            var totalamount = pesaKor+tredeLisenceFee;

            var resultValue  =  (tredeLisenceFee*vatAykor)/100;


            //  tredeLisenceFee = parseInt(tredeLisenceFee);
            //  vatAykor = parseInt(vatAykor);

            this.form.amounta  =totalamount+resultValue;

            },
            async formsubmit(){
                this.form.approveData = this.ApproveData;
                var res = await this.callApi('post',`/api/sonod/sec/approve/${this.SonodId}`,this.form);
        //    this.$root.$emit('bv::hide::modal', this.infoModal.id, button)
          this.$root.$emit('bv::hide::modal', 'action-modal')
                this.$emit('event-name')
                 Notification.customSuccess(`Your data has been Approved`);

            }

    },
    mounted() {

            // this.readonly = true

            this.form.sec_prottoyon = `স্থানীয় সরকার (ইউনিয়ন পরিষদ) আইন, ২০০৯ ইং এর সংশ্লিষ্ট ধারা ও উপধারা অনুসারে (ট্রেড, প্রফেশন, কলিং ও বিজ্ঞাপন) ব্যবসা/পেশার  অনুমোদন পত্র উপরে বর্ণিত ব্যক্তি/প্রতিষ্ঠানের অনুকূলে দেওয়া হইল। যাহার মেয়াদ ${this.dateformatGlobal()[10]} ইং সনের 30 জুন পর্যন্ত কার্যকর থাকিবে।
<br/>
<br/>
            &nbsp; &nbsp; &nbsp; লাইসেন্সধারী এর নিকট হইতে সকল পাওনা বাবদ সর্বমোট ${this.Details.total_amount} টাকা (${this.Details.the_amount_of_money_in_words}) আদায় করা হইল। তার ব্যবসা/পেশা চালিয়ে যাওয়ার জন্য এই লাইসেন্স প্রদান করা হলো ।
            `;

    }


}
</script>
