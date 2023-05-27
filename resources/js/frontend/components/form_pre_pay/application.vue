<template>
    <div>
        <form @submit.stop.prevent="finalSubmit">

<!-- <div class="panel-heading" style="font-weight: bold; font-size: 20px;background:#159513;text-align:center;color:white">{{ sonodnamedata.bnname }} </div> -->
<div class="panel-heading" style="font-weight: bold; font-size: 20px;background:#159513;text-align:center;color:white">{{ form.sonod_name }} </div>
<div class="form-pannel">



    <div class="row">
<div class="col-md-12"  v-if="sonodnamedata.enname == 'Trade license'">

    <h3 style="text-align:center;color:red"> ট্রেড লাইসেন্স এর জন্য প্রথমে নিচের ফর্মটা পূরণ করুন</h3>
</div>


    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">ব্যবসা, বৃত্তি, পেশা, বা শিল্প প্রতিষ্ঠানের শ্রেণী</label>
                            <select class="form-control" v-model="form.applicant_type_of_businessKhat" @change="GetKhatSubCate" required>
                                <option value="">নির্বাচন করুন</option>

                                <option v-for="(TradeLicensekat,indexs) in TradeLicenseKhat" :key="indexs" :value="TradeLicensekat.khat_id">{{ TradeLicensekat.name }}</option>

                            </select>
                        </div>
                    </div>




                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license' && businessType == true">
                        <div class="form-group">
                            <label for="" class="labelColor">মূলধন/ব্যবসার ধরন</label>
                            <select class="form-control" v-model="form.applicant_type_of_businessKhatAmount"   required>
                                <option value="">নির্বাচন করুন</option>

                                <option v-for="(TradeLicenseKhatAmout,indexs) in TradeLicenseKhatAmouts" :key="indexs" :value="TradeLicenseKhatAmout.khat_id">{{ TradeLicenseKhatAmout.name }}</option>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license' && form.applicant_type_of_businessKhatAmount && businessType == true" style="display: flex;justify-content: space-around;align-items: center;">
                        <div class="form-group">
                           <button type="button" class="btn btn-info" @click="GetKhatSubCateAmount">Calculate</button>
                        </div>
                    </div>

                </div>





    <h3 v-if="calculate" style="color:red;text-align: center;">{{ form.sonod_name }} এর আবেদন করার পূর্বে সনদের ফি প্রদান করুন । সনদ ফি প্রদান সফল হলে আপনাকে সনদ ফর্ম দেওয়া হবে। {{ form.sonod_name }} এর ফি {{
                    charages.totalamount
                    }} টাকা ।</h3>

    <div  v-if="calculate" style="display: flex;
    justify-content: space-around;">

        <div class="col-md-4">
            <div class="form-group">
                <label for="" class="labelColor">মোবাইল</label>
                <input type="tel" class="form-control" name="phone" minlength="11" maxlength="11" v-model="form.applicant_mobile" required>
            </div>
        </div>

    </div>

                    <div class="text-center" v-if="calculate">
                        <button class="btn btn-info" disabled v-if="submitLoad"><span >অপেক্ষা করুন...</span></button>
                        <button class="btn btn-info" v-else><span>ফি পরিশোধ করুন</span></button>
                    </div>



</div>
        </form>











<!--
        <Applicationform  v-if="nidService==0"/>
        <ApplicationformwitnNid v-else/> -->





    </div>
</template>

<script>

export default {
created() {
    this.checkNidService();
    this.sonodname();

    setTimeout(() => {
        if(this.form.sonod_name!='ট্রেড লাইসেন্স'){
        this.sonodFeeAsign();
        }
    }, 3000);

},
    data() {
        return {
            calculate:false,
            nidService:0,
            sonodnamedata:{},
            sonodnameFee:{},
            TradeLicenseKhatAmouts:{},
            businessType:false,
            submitLoad:false,
            pesaKor:0,
            charages: {
                sonod_fee: 0,
                vatAmount: 0,
                taxAmount: 0,
                service: 0,
                totalamount: 0,
            },
            form:{
                sonod_name:'',
                applicant_type_of_businessKhat:'',
                applicant_type_of_businessKhatAmount:'',
            }
        }
    },
    watch: {
        '$route': {
            handler(newValue, oldValue) {
                this.calculate = false;
                this.checkNidService();
                this.sonodname();
                setTimeout(() => {
                    if(this.form.sonod_name!='ট্রেড লাইসেন্স'){
                        this.sonodFeeAsign();
                        }
                }, 3000);
            },
            deep: true
        }
    },
    methods: {

        sonodFeeAsign(){
            var sonod_fee = 0
            var payment_type = this.getunionInfos.payment_type;
            if (payment_type == 'Prepaid') {
                var sonod_fee = Number(this.sonodnameFee.fees)
            }

            console.log(sonod_fee)
            var vat = Number(this.getvatTax.vat)
            var tax = Number(this.getvatTax.tax)
            var service = Number(this.getvatTax.service)
            var vatAmount = ((sonod_fee * vat) / 100);
            var taxAmount = ((sonod_fee * tax) / 100);
            // var totalamount = sonod_fee + vatAmount + taxAmount + service

            var tradeVat = 15;
            if(this.form.sonod_name=='ট্রেড লাইসেন্স'){
                var TradevatAmount =  ((sonod_fee * tradeVat) / 100);
                var totalamount = Number(this.pesaKor) + sonod_fee + TradevatAmount

            }else{

                var totalamount = sonod_fee
            }


            this.charages = {
                sonod_fee: sonod_fee,
                vatAmount: vatAmount,
                taxAmount: taxAmount,
                pesaKor: this.pesaKor,
                service: service,
                tradeVat: tradeVat,
                totalamount: totalamount,
            }
            this.calculate = true;
            this.form.unioun_name = this.getUnion.subdomainget

        },




        async checkNidService(){
            var res = await this.callApi('post',`/api/nid/service/${this.getUnion.subdomainget}`,[])
            this.nidService = res.data;
        },

        sonodname() {
            if (this.$route.params.name) {
                axios.get(`/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_', ' ')}&fees=1&unioun=${localStorage.getItem('unioun')}`)
                    .then(({ data }) => {
                        this.sonodnamedata = data.sonodname
                        this.sonodnameFee = data.sonodFee

						this.form.sonod_name = this.sonodnamedata.bnname;

                        window.scrollTo(0, 0);
                    })
                    .catch()
            }
        },



        async TradeLicenseKhatFun(){
            // var res = await this.callApi('get',`/api/tradeLicenseKhat?searhtype=main`,[]);
            this.TradeLicenseKhats = this.TradeLicenseKhat;
        },




        async GetKhatSubCate(){
            var res = await this.callApi('get',`/api/tradeLicenseKhat?searhtype=sub&main_khat_id=${this.form.applicant_type_of_businessKhat}`,[]);
            this.TradeLicenseKhatAmouts = res.data.tradeSub;

            if(res.data.tradeSub.length>0){
             this.businessType = true
            }else{
                this.GetKhatSubCateAmount('single')
                this.businessType = false

            }


            // this.form.applicant_type_of_business =  res.data.tradeMain.name;
        },

        async GetKhatSubCateAmount(type=''){
            var typeData = '';
            if(type=='single') typeData = '&dataget=single'
            var res = await this.callApi('get',`/api/tradeLicenseKhatFee?khat_id_1=${this.form.applicant_type_of_businessKhat}&khat_id_2=${this.form.applicant_type_of_businessKhatAmount}${typeData}`,[]);
            this.pesaKor = res.data.fee;
            this.sonodFeeAsign();

        },


        async finalSubmit() {
            this.submitLoad = true;
            var redirect;
            this.form.stutus = 'Prepaid';
            this.form['charages'] = this.charages;
            var res = await this.callApi('post', '/api/nagorik/pre/pay/inserts', this.form);
            var datas = res.data;
            redirect = `/sonod/payment/${datas.id}`
            this.waitForPayment = true;
            // this.checkPayment(datas.id);
            this.form['id'] = datas.id;
            // window.open(redirect, '_blank');
            window.location.href =redirect;


        },














    },
    mounted() {
        setTimeout(() => {
            this.form.sonod_name = this.sonodnamedata.bnname;
        }, 3000);
        this.form.year = new Date().getFullYear();
    },

}
</script>

<style scoped >
.app-heading {
    text-align: center;
    margin: 32px 0;
    font-size: 23px;
    border-bottom: 1px solid #159513;
    color: #ffffff;
    background: #255f95;
}
.form-pannel {
    border: 1px solid #159513;
    padding: 25px 25px 25px 25px;
}
.panel-heading {
    padding: 11px 0px;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
    margin-top: 20px;
}
.form-pannel {
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}
.dropdown-menu {
    z-index: 99999;
}
.labelColor {
    color: #493eff;
    font-weight: 600;
}
</style>
