<template>
        <form v-on:submit.prevent="formsubmit">
    <div class="row">


  <div class="col-md-4">
    <div class="form-group">
        <label for="pesaKor">পেশা কর </label>
        <input id="pesaKor" @keyup="totalAmount()" class="form-control" type="text" v-model="form.pesaKor">
    </div>
</div>

  <div class="col-md-4">
    <div class="form-group">
        <label for="tredeLisenceFee">ট্রেড লাইসেন্স ফি </label>
        <input id="tredeLisenceFee" @keyup="totalAmount()"  class="form-control" type="text" v-model="form.tredeLisenceFee">
    </div>
</div>

  <div class="col-md-4">
    <div class="form-group">
        <label for="vatAykor">ভ্যাট ও আয়কর </label>
        <input id="vatAykor" @keyup="totalAmount()"  class="form-control" type="text" v-model="form.vatAykor">
    </div>
</div>

  <div class="col-md-6">
    <div class="form-group">
        <label for="amounta">মোট </label>
        <input id="amounta" class="form-control" type="text" v-model="form.amounta">
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
},
    data() {
        return {
            form:{
            pesaKor:'0',
            tredeLisenceFee:'0',
            vatAykor:'3',
            amounta:'',
            approveData:'',
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
          this.$root.$emit('bv::hide::modal', 'info-modal')
                this.$emit('event-name')
                 Notification.customSuccess(`Your data has been Approved`);

            }

    },
    mounted() {



    }


}
</script>
