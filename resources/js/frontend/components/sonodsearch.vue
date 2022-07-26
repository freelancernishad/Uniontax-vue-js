<template>



<div class="row">
<div class="mainBody col-md-9 mt-3">




<form method="POST" @submit.stop.prevent="onSubmit">
	<div class="form-group">
		<label for="">সনদ</label>
		<select v-model="form.sonod_name" id="sonod"  class="form-control" required>
			<option value="">চিহ্নিত করুন</option>
			<option v-for="(sonod, r) in SonodNames" :key="'dropdown' + r" :value="sonod.bnname">{{ sonod.bnname }}</option>
		</select>
	</div>
	<div class="form-group">
		<label for="">সনদ নাম্বার</label>
		<input type="text" v-model="form.sonod_Id" id="sonodNo" class="form-control" required/>
	</div>
	<div class="form-group text-center">
		<input type="submit"  class="btn btn-info" value="Search" />
	</div>
</form>



    <table class="table" v-if="search && notfound==false">
            <tr><td colspan="2">
                <span v-if="sonoddata.payment_status=='Paid'">সনদ অনুমোদিত হয়েছে Download বাটন এ ক্লিক করে সনদ ডাউনলোড করুন <a :href="sonoddata.sonodUrl" class="btn btn-info">Download</a></span>
                <span v-else-if="sonoddata.payment_status=='Unpaid'">সনদ অনুমোদিত হয়েছে কিন্ত এখনও ফি জমা হয় নি। Pay বাটন এ ক্লিক করে ফি প্রদান করুন এবং সনদ ডাউনলোড করুন <a :href="sonoddata.paymentUrl" class="btn btn-info">Pay</a></span></td></tr>

            <tr><td>সেবার ধরণ</td><td>{{ sonoddata.sonod_name }}</td></tr>
            <tr><td>আবেদনের ক্রমিক নাম্বার</td><td>{{ sonoddata.sonod_Id }}</td></tr>
            <tr><td>আবেদনের তারিখ</td><td>{{ sonoddata.created_at }}</td></tr>
            <tr><td>আবেদনকারির নাম</td><td>{{ sonoddata.applicant_name }}</td></tr>
            <tr><td>পিতা/স্বামীর নাম</td><td>{{ sonoddata.applicant_father_name }}</td></tr>
            <tr><td>বর্তমান ঠিকানা</td><td> হোল্ডিং নং- {{ sonoddata.applicant_holding_tax_number }}, {{ sonoddata.applicant_present_village }}, {{ sonoddata.applicant_present_post_office }}, {{ sonoddata.applicant_present_Upazila }},  {{ sonoddata.applicant_present_district }}</td></tr>
            <tr><td>মোবাইল নাম্বার</td><td>{{ sonoddata.applicant_mobile }}</td></tr>
    </table>
    <div class="card text-center" v-else-if="search && notfound">
    <div class="card-body">
    <h1 style="color:red">দু:খিত !</h1>
<p>আপনার অনুসন্ধানকৃত নম্বরের কোন সনদ/প্রত্যয়নপত্র অত্র ইউনিয়ন পরিষদ থেকে ইস্যু/প্রদান করা হয়নি।</p>
    </div>
</div>
</div>



   <side-bar></side-bar>




</div>

</template>

<script>
export default {
    data(){
        return {
            form:{
                sonod_Id:null,
                sonod_name:null,
            },
            search:false,
            notfound:false,
            sonoddata:{
                payment_status:null,
                sonod_name:null,
                sonod_Id:null,
                created_at:null,
                applicant_name:null,
                applicant_father_name:null,
                applicant_holding_tax_number:null,
                applicant_present_Upazila:null,
                applicant_present_district:null,
                applicant_present_post_office:null,
                applicant_present_road_block_sector:null,
                applicant_present_village:null,
                applicant_present_word_number:null,
                applicant_mobile:null,
                sonodUrl:null,
                paymentUrl:null,

            }
        }
    },
watch: {
        '$route':  {
            handler(newValue, oldValue) {
                if(!this.$route.query.sonod_Id && !this.$route.query.sonod_name){
                        this.search = false
                        this.notfound = false
                        this.form ={
                            sonod_Id:null,
                            sonod_name:null,
                                    }
                }

            },
        deep: true



        }
    },

    methods:{
        async onSubmit(){
            var res = await this.callApi('post',`/api/sonod/search`,this.form);
            // console.log(res);

             if(this.$route.query.sonod_Id!=this.form.sonod_Id || this.$route.query.sonod_name!=this.form.sonod_name){
                this.$router.push({ name: 'sonodsearch', query: { sonod_name: this.form.sonod_name,sonod_Id: this.form.sonod_Id }})
                // console.log('dd')
             }

            if(res.data=='')
            {
                 this.search=true;
                this.notfound = true;
            }else{
            this.sonoddata = res.data
             this.search=true;
             this.notfound = false;
            }



             }
    },
    mounted(){

        console.log(this.$route.query)
        if(this.$route.query.sonod_Id && this.$route.query.sonod_name){
            this.search=true;
            this.form.sonod_Id = this.$route.query.sonod_Id
            this.form.sonod_name = this.$route.query.sonod_name

            // ?sonod=নাগরিকত্ব%20সনদ&sonod_id=7790812200002
            this.onSubmit();
        }


        }
}
</script>
