<template>
<div>
 <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

<div class="breadcrumbs-area">
    <h3>Charges</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Charges</li>
    </ul>
</div>

  <form @submit.stop.prevent="onSubmit" class="form-horizontal">

      <div class="card-body">

 <div class="row">

  <div class="col-md-6">
          <div class="form-group">
              <label class="control-label col-form-label">ভ্যাট (%)</label>

                  <input type="number" class="form-control" id="full_name" v-model="form.vat"  />

          </div>
          </div>



          <div class="col-md-6">
          <div class="form-group">
              <label class="control-label col-form-label">ট্যাক্স (%)</label>

                  <input type="number" class="form-control"  id="short_name_b" v-model="form.tax"  />

          </div>
          </div>

          <div class="col-md-6">

          <div class="form-group">
              <label class="control-label col-form-label">সফটওয়্যার ফী</label>

                  <input type="number" class="form-control"  id="thana" v-model="form.service"  />

          </div>
          </div>



        </div>



      </div>
      <div class="border-top">
          <div class="card-body">
              <button type="submit" class="btn btn-primary">
                  Submit
              </button>
          </div>
      </div>
  </form>

</div>


</template>



<script>
import axios from 'axios';
export default {
    created() {

    },
    data() {
        return {
             preLooding:true,
             form: {
                vat:null,
                tax:null,
                service:null,

             },
        }
    },
    methods: {


      async getunionInfo(){

                this.preLooding = false
                var district = this.getUsers.district
                var thana = this.getUsers.thana

                this.form['district'] = district
                this.form['thana'] = thana

            var res = await this.callApi('post',`/api/vattax/get`,this.form);
            if(res.data==0){
                this.form= {
                    vat:null,
                    tax:null,
                    service:null,
                    }
            }else{
                this.form = res.data
            }
                this.preLooding = false







        },


        async onSubmit() {


       this.preLooding = true
                var district = this.getUsers.district
                var thana = this.getUsers.thana

                this.form['district'] = district
                this.form['thana'] = thana

            var res =  this.callApi('post',`/api/vattax/submit`,this.form);
                this.preLooding = false

    this.getunionInfo();
    Notification.customSuccess('Union Info Update Successfuly Done');


        }
    },
    mounted() {
         setTimeout(() => {
        this.getunionInfo();
            }, 2000);
    }
}
</script>
