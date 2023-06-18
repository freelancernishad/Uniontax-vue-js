<template>
    <div>
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>
        <form @submit.stop.prevent="Search">

            <div class="row">

                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">union</label>
                        <input type="text" v-model="form.union" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="">taxid</label>
                        <input type="test" v-model="form.holdingTax" class="form-control">
                    </div>
                </div>

            </div>

            <button type="submit" class="btn btn-info">Search</button>
        </form>




        <pre v-html="result"></pre>






    </div>
</template>

<script>
export default {
    data(){
        return {
            preLooding:false,
            form:{
                trnx_id:'',
                trans_date:'',
            },
            result:{}
        }
    },
    methods: {

        async Search(){
            this.preLooding = true
            var res = await this.callApi('post',`/api/get/holding/tax`,this.form);
            this.result = res.data
            this.preLooding = false
        },




    },
}
</script>
