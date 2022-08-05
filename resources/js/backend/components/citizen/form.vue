<template>
    <div>

<div class="breadcrumbs-area">
    <h3>Citizen Form</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Citizen Form</li>
    </ul>
</div>

    <form class="row" @submit.stop.prevent="onSubmit">


        <div class="form-group col-md-6">
          <label for="">নাম</label>
          <input type="text" v-model="form.name" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">পিতার নাম</label>
          <input type="text" v-model="form.fathername" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">মাতার নাম</label>
          <input type="text" v-model="form.mothername" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">জেলা</label>

          <select v-model="form.district" class="form-control">
            <option selected value="বরিশাল">বরিশাল</option>
          </select>

        </div>


        <div class="form-group col-md-6">
          <label for="">উপজেলা</label>

          <select v-model="form.thana" class="form-control">
            <option selected value="বরিশাল সদর">বরিশাল সদর</option>
          </select>

        </div>

<!--
        <div class="form-group col-md-6">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">নির্বাচন করুন</option>
            <option value="tungibaria">টুঙ্গীবাড়িয়া</option>
          </select>

        </div> -->


        <div class="form-group col-md-6">
          <label for="">পোস্ট অফিস</label>
          <input type="text" v-model="form.post" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">গ্রাম</label>
          <input type="text" v-model="form.vill" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">ওয়ার্ড নং</label>
          <select v-model="form.word" class="form-control">
            <option value="">নির্বাচন করুন</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
          </select>
        </div>





        <div class="form-group col-md-6">
          <label for="">জাতীয় পরিচয় পত্রের নাম্বার</label>
          <input type="text" v-model="form.nidno" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">জন্ম নিবন্ধনের নাম্বার</label>
          <input type="text" v-model="form.dobno" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">জন্ম তারিখ</label>
          <input type="date" v-model="form.dob" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">হোল্ডিং নাম্বার</label>
          <input type="text" v-model="form.holding" class="form-control" placeholder="" aria-describedby="helpId">
        </div>




        <div class="col-md-12">
    <button class="btn btn-info" type="submit">Submit</button>
</div>
    </form>


    </div>
</template>

<script>
export default {
    data(){
        return {
            form:{
                unioun_name:null,
                name:null,
                fathername:null,
                mothername:null,
                word:null,
                vill:null,
                post:null,
                district:'বরিশাল',
                thana:'বরিশাল সদর',
                nidno:null,
                dobno:null,
                dob:null,
                holding:null,
            }
        }
    },
    methods:{

        async getsonodById(){
           var id =  this.$route.params.id;
            var res = await this.callApi('get', `/api/citizen/show/${id}`, []);
            this.form = res.data;
        },


        async onSubmit() {
            this.form['unioun_name'] = this.Users.unioun;
            var res = await this.callApi('post', '/api/citizen/submit', this.form);
             this.$router.push({ name: 'citizenlist'})
            Notification.customSuccess('Citizen Update Success');

        }
    },
    mounted(){
        if(this.$route.params.id){

            this.getsonodById();
        }
        }
}
</script>
