<template>
    <div>
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>
        <!-- <form @submit.stop.prevent="Search">

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
        </form> -->




        <!-- <pre v-html="result"></pre> -->

        <div class='form-group'>
            <input type="date" class="form-control" v-model="filter_date">
            <button class="btn btn-info" @click="checkdata">Search Data</button>
        </div>

        <table width='100%' border="1">
            <tr>
                <td>id</td>
                <td>Sonod Id</td>
                <td>Sonod name</td>
                <td>applicant name</td>
                <td>trxids</td>

                <td>action</td>
            </tr>

            <tr v-for="row in rows">
                <td>{{ row.id }}</td>
                <td>{{ row.sonod_Id }}</td>
                <td>{{ row.sonod_name }}</td>
                <td>{{ row.applicant_name }}</td>
                <td>
                    <p v-for="trxid in row.payments" :key="`${row.id}${trxid.id}`">{{ trxid.trxId }}  <button @click="ReCallIpn(trxid.trxId)" class="btn btn-danger">Recall IPN</button> <br/></p>
                </td>

                <td><button type="button" @click="showDetial(row.payments,$event.target)" class="btn btn-info">Show</button></td>
            </tr>
        </table>




        <b-modal :id="infoModal.id" size="xl" >

            <pre>{{ infoModal.content }}</pre>
        </b-modal>



    </div>
</template>

<script>
export default {
    data(){
        return {
            preLooding:false,
            filter_date:'',
            form:{
                trnx_id:'',
                trans_date:'',
            },
            form2:{
                trnx_id:'',
                trans_date:'',
            },
            rows:{},
            infoModal: {
                id: 'info-modal',
                title: '',
                content: {},
                content_id: '',
            },
        }
    },
    methods: {

        checkdata(){

            if(this.filter_date){

                this.getData(this.filter_date);
            }else{
                alert('input a date');
            }
        },
        async getData(date=''){
            var q ='';
            if(date){
                q = `?date=${date}`;
            }
            this.preLooding = true
            var res = await this.callApi('get',`/api/get/prepaid/sonod${q}`,this.form);
            this.rows = res.data
            this.preLooding = false
        },


        showDetial(item,button){
            this.infoModal.content = item
            this.$root.$emit('bv::show::modal', this.infoModal.id, button)
        },
        async ReCallIpn(trxid=''){
            this.form2.trnx_id = trxid
            this.preLooding = true
            var res = await this.callApi('post',`/api/re/call/ipn`,this.form2);
            if(res.status==200){
                Notification.customSuccess('IPN sent success');
                // this.Search();
                if(this.filter_date){
                    this.getData(this.filter_date);
                }else{
                    this.getData();
                }
             

            }else{
                Notification.customError('Something want wrong');

            }

            this.preLooding = false

        }


    },
    mounted(){
        this.getData();
    }
}
</script>
