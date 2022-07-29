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
        </div>


        <div class="form-group col-md-6">
          <label for="">সনদের ইংলিশ নাম</label>
          <input type="text" v-model="form.email" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">সনদের ফি</label>
          <input type="text" v-model="form.password" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">সনদের ফি</label>
          <input type="text" v-model="form.phone" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">সনদের আইকন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">নির্বাচন করুন</option>
            <option value="tungibaria">টুঙ্গীবাড়িয়া</option>
          </select>
        </div>




        <div class="form-group col-md-6">
          <label for="">সনদের আইকন</label>
          <input type="text" v-model="form.full_unioun_name" class="form-control" placeholder="" aria-describedby="helpId">
        </div>






        <div class="form-group col-md-6">
          <label for="">সনদের বিবরন</label>
          <textarea v-model="form.template" class="form-control" cols="30" rows="10" style="height: 100px;
    background: #DFDFDF;
    resize: none;"></textarea>
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
                gram:null,
                word:null,
                description:null,
                image:null,
                status:null,
                role:null,
                remember_token:null,
                created_at:null,
                updated_at:null,
            }
        }
    },
    methods:{

        async getsonodById(){
           var id =  this.$route.params.id;
            var res = await this.callApi('get', `/api/update/sonodname/${id}`, []);
            this.form = res.data;
        },


        async onSubmit() {

            var res = await this.callApi('post', '/api/update/sonodname', this.form);
             this.$router.push({ name: 'sonodlist'})
            Notification.customSuccess('Sonod Name Update Success');

        }
    },
    mounted(){
        if(this.$route.params.id){

            this.getsonodById();
        }
        }
}
</script>
