<template>
    <div>

<div class="breadcrumbs-area">
    <h3>Sonod List</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Sonod List</li>
    </ul>
</div>

    <form class="row" @submit.stop.prevent="onSubmit">


        <div class="form-group col-md-6">
          <label for="">নাম</label>
          <input type="text" v-model="form.names" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">পদবি</label>

          <select v-model="form.position" class="form-control">
            <option value="">নির্বাচন করুন</option>
            <option value="District_admin">জেলা এডমিন</option>
            <option value="Thana_admin">উপজেলা এডমিন</option>
            <option value="Chairman">চেয়ারম্যান</option>
            <option value="Secretary">সচিব</option>
          </select>

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


        <div class="form-group col-md-6">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">নির্বাচন করুন</option>
            <option value="tungibaria">টুঙ্গীবাড়িয়া</option>
          </select>

        </div>



        <div class="form-group col-md-6">
          <label for="">ইমেইল</label>
          <input type="text" v-model="form.email" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">পাসওয়ার্ড</label>
          <input type="text" v-model="form.password" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">মোবাইল নাম্বার</label>
          <input type="text" v-model="form.phone" class="form-control" placeholder="" aria-describedby="helpId">
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
                id:null,
                unioun:null,
                names:null,
                email:null,
                phone:null,
                email_verified_at:null,
                password:null,
                position:null,
                full_unioun_name:null,
                district:'বরিশাল',
                thana:'বরিশাল সদর',
                gram:null,
                word:null,
                description:null,
                image:null,
                status:null,
                role:1,
                remember_token:null,
                created_at:null,
                updated_at:null,
            }
        }
    },
    methods:{

        async getsonodById(){
           var id =  this.$route.params.id;
            var res = await this.callApi('get', `/api/update/users/${id}`, []);
            this.form = res.data;
        },


        async onSubmit() {

            var res = await this.callApi('post', '/api/update/users', this.form);
             this.$router.push({ name: 'userlist'})
            Notification.customSuccess('User Update Success');

        }
    },
    mounted(){
        if(this.$route.params.id){

            this.getsonodById();
        }
        }
}
</script>
