<template>
        <form v-on:submit.prevent="formsubmit">
           <div class="row" v-if="prottoyon">
           <div class="col-md-12">
            <h5>আবেদনকৃত প্রত্যয়নের বিবরণ</h5>
            <p>{{ sonodlist.prottoyon }}</p>
           </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="amountab">প্রত্যয়ন প্রদানের বিবরণ </label>

                        <textarea v-model="form.sec_prottoyon" class="form-control" style="height:100px;resize:none"></textarea>


                    </div>
                </div>



<div class="col-md-6" v-if="sonodlist.payment_status=='Unpaid'">
    <div class="form-group">
        <label for="khat">খাত  </label>
        <select v-model="form.khat" id="khat"  class="form-control" required>
		<option value="বসতবাড়ীর বাৎসরিক মূল্যের উপর কর ">বসতবাড়ীর বাৎসরিক মূল্যের উপর কর </option>
		<option value="ব্যবসা/পেশা/জীবিকার উপর কর">ব্যবসা/পেশা/জীবিকার উপর কর</option>
		<option value="সিনেমা/যাত্রা/থিয়েটার/ অন্যান্য বিনোদনমূলক অনুষ্ঠানের উপর কর">সিনেমা/যাত্রা/থিয়েটার/ অন্যান্য বিনোদনমূলক অনুষ্ঠানের উপর কর</option>
		<option value="লাইসেন্স ও পারমিট ফি">লাইসেন্স ও পারমিট ফি</option>
		<option value="হাট-বাজার/ফেরীঘাট/ জলমহাল/অন্যান্য ইজারা বাবদ">হাট-বাজার/ফেরীঘাট/ জলমহাল/অন্যান্য ইজারা বাবদ</option>
		<option value="ভূমি/ ইমারত ভাড়া/ রপ্তানী কর">ভূমি/ ইমারত ভাড়া/ রপ্তানী কর</option>
		<option value="নিলামে বিক্রয়লব্ধ আয়">নিলামে বিক্রয়লব্ধ আয়</option>
		<option value="জরিমানা (যদি থাকে)">জরিমানা (যদি থাকে)</option>
		<option value="অন্যান্য দাবী আদায় (যদি থাকে)">অন্যান্য দাবী আদায় (যদি থাকে)</option>
		<option value="পশু জবেহ ফিস">পশু জবেহ ফিস</option>
		<option value="যানবাহন ফিস">যানবাহন ফিস</option>
		<option value="ওয়ারিশান সনদ ফিস">ওয়ারিশান সনদ ফিস</option>
		<option value="বিবিধ সনদপত্র/প্রত্যয়ন পত্র ফিস">বিবিধ সনদপত্র/প্রত্যয়ন পত্র ফিস</option>
		<option value="বিবিধ ফিস">বিবিধ ফিস</option>
		</select>
    </div>
</div>










<div class="col-md-6" v-if="sonodlist.payment_status=='Unpaid'">
    <div class="form-group">
        <label for="amountab">বিগত বছরের  টাকা (অংকে) </label>
        <input id="amountab" class="form-control"  @keyup="totalAmount"  type="text" value="0" v-model="form.last_years_money" required>
    </div>
</div>





<div class="col-md-6" v-if="sonodlist.payment_status=='Unpaid'">
    <div class="form-group">
        <label for="amountabb">বর্তমানে পরিশোধকৃত টাকা  (অংকে) </label>
        <input id="amountabb" class="form-control"  @keyup="totalAmount" value="0" type="text" v-model="form.currently_paid_money" required>
    </div>
</div>



<div class="col-md-6" v-if="sonodlist.payment_status=='Unpaid'">
    <div class="form-group">
        <label for="amounta">মোট  (অংকে) </label>
        <input id="amounta" class="form-control" value="0" type="text" v-model="form.amounta" required>
    </div>
</div>





<div class="col-md-12">

        <input id="submit" class="btn btn-info" type="submit"  value="Approve">

</div>

           </div>
    <div class="row" v-else>


<div class="col-md-6">
    <div class="form-group">
        <label for="khat">খাত  </label>
        <select v-model="form.khat" id="khat"  class="form-control" required>
		<option value="বসতবাড়ীর বাৎসরিক মূল্যের উপর কর ">বসতবাড়ীর বাৎসরিক মূল্যের উপর কর </option>
		<option value="ব্যবসা/পেশা/জীবিকার উপর কর">ব্যবসা/পেশা/জীবিকার উপর কর</option>
		<option value="সিনেমা/যাত্রা/থিয়েটার/ অন্যান্য বিনোদনমূলক অনুষ্ঠানের উপর কর">সিনেমা/যাত্রা/থিয়েটার/ অন্যান্য বিনোদনমূলক অনুষ্ঠানের উপর কর</option>
		<option value="লাইসেন্স ও পারমিট ফি">লাইসেন্স ও পারমিট ফি</option>
		<option value="হাট-বাজার/ফেরীঘাট/ জলমহাল/অন্যান্য ইজারা বাবদ">হাট-বাজার/ফেরীঘাট/ জলমহাল/অন্যান্য ইজারা বাবদ</option>
		<option value="ভূমি/ ইমারত ভাড়া/ রপ্তানী কর">ভূমি/ ইমারত ভাড়া/ রপ্তানী কর</option>
		<option value="নিলামে বিক্রয়লব্ধ আয়">নিলামে বিক্রয়লব্ধ আয়</option>
		<option value="জরিমানা (যদি থাকে)">জরিমানা (যদি থাকে)</option>
		<option value="অন্যান্য দাবী আদায় (যদি থাকে)">অন্যান্য দাবী আদায় (যদি থাকে)</option>
		<option value="পশু জবেহ ফিস">পশু জবেহ ফিস</option>
		<option value="যানবাহন ফিস">যানবাহন ফিস</option>
		<option value="ওয়ারিশান সনদ ফিস">ওয়ারিশান সনদ ফিস</option>
		<option value="বিবিধ সনদপত্র/প্রত্যয়ন পত্র ফিস">বিবিধ সনদপত্র/প্রত্যয়ন পত্র ফিস</option>
		<option value="বিবিধ ফিস">বিবিধ ফিস</option>
		</select>
    </div>
</div>










<div class="col-md-6">
    <div class="form-group">
        <label for="amountab">বিগত বছরের  টাকা (অংকে) </label>
        <input id="amountab" class="form-control"  @keyup="totalAmount"  type="text" value="0" v-model="form.last_years_money" required>
    </div>
</div>





<div class="col-md-6">
    <div class="form-group">
        <label for="amountabb">বর্তমানে পরিশোধকৃত টাকা  (অংকে) </label>
        <input id="amountabb" class="form-control"  @keyup="totalAmount" value="0" type="text" v-model="form.currently_paid_money" required>
    </div>
</div>



<div class="col-md-6">
    <div class="form-group">
        <label for="amounta">মোট  (অংকে) </label>
        <input id="amounta" class="form-control" value="0" type="text" v-model="form.amounta" required>
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
            prottoyon:true,
            sonodlist:{},
            uniun:{},
            form:{
            sec_prottoyon:'',
            khat:'',
            last_years_money:'0',
            currently_paid_money:'0',
            amounta:'0',
            }

        }
    },
    methods: {


            totalAmount(){
                var amountab,amountabb;
                amountab = parseInt(this.form.last_years_money);
                amountabb = parseInt(this.form.currently_paid_money);
	            this.form.amounta=amountab+amountabb;
            },
            async formsubmit(){
                this.form.approveData = this.ApproveData;
                var res = await this.callApi('post',`/api/sonod/sec/approve/${this.SonodId}`,this.form);
                this.$root.$emit('bv::hide::modal', 'info-modal')
                this.$emit('event-name')
                 Notification.customSuccess(`Your data has been Approved`);

            },
            async Getsonod(){
                var res = await this.callApi('get',`/api/sonod/single/${this.SonodId}`,[])
                    this.sonodlist = res.data;
                if(res.data.sonod_name=='প্রত্যয়নপত্র' || res.data.sonod_name=='বিবিধ প্রত্যয়নপত্র'){
                    this.prottoyon = true
                }else{
                    this.prottoyon = false

                }

            },


    //  getunionInfo(){
    //     var unionname = undefined;
    //          setTimeout(() => {

    //             unionname = this.getUsers.unioun

    //         // var res =  this.callApi('post',`/api/union/info?union=${unionname}`,[]);

    //             axios.post(`/api/union/info?union=${unionname}`)
    //             .then((res)=>{
    //                 // console.log(unionname);
    //                 // console.log(res);
    //                 this.uniun = res.data

    //             })




    //         }, 2000);
    //     },


    },
    mounted() {

        this.Getsonod();
        // this.getunionInfo();

    }


}
</script>
