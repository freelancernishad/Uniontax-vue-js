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
          <label for="">সনদের বাংলা নাম</label>
          <input type="text" v-model="form.bnname" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">সনদের ইংলিশ নাম</label>
          <input type="text" v-model="form.enname" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">সনদের ফি</label>
          <input type="text" v-model="form.sonod_fee" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">সনদের আইকন</label>
          <input type="file"  class="form-control" placeholder="" @change="FileSelected($event, 'icon')"   aria-describedby="helpId">

         <b-img thumbnail fluid v-if="form.icon!=null"  :src="form.icon" alt="Image"></b-img>

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
                bnname:null,
                enname:null,
                sonod_fee:null,
                icon:null,
                template:null,
            }
        }
    },
    methods:{

	FileSelected($event, parent_index){



			let file = $event.target.files[0];
			if (file.size > 5048576) {
				Notification.image_validation();
			} else {
				let reader = new FileReader;
				reader.onload = event => {
					this.form[parent_index] = event.target.result
					// console.log(event.target.result);
				};
				reader.readAsDataURL(file)
			}
                    //   console.log($event.target.result);
		},


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
