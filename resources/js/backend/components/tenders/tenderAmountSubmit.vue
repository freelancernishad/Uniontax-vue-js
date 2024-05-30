<template>
    <div>
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

        <div class="breadcrumbs-area">
    <h3>ফী প্রদান এর তালিকা</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>ফী প্রদান এর তালিকা</li>
    </ul>
</div>
    <div class="container mt-5">



        <div class="d-flex justify-content-center align-items-center">
            <button class="btn btn-info py-3 px-3" @click="showImage()">এই বাটন ক্লিক করে নির্বাচন করুন</button>
        </div>





<!--
        <div class="text-right">
            <a :href="'/pdf/sder/download/'+$route.params.tender_id" class="btn btn-info" target="_blank">Pdf Download</a>
        </div> -->

        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">ক্রমিক নং</th>
                <th scope="col">ধরন</th>
                <th scope="col">টাকা</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(list,index) in lists" :key="list.id">
                    <th scope="row">{{ index+1 }}</th>
                    <td>{{ list.khat }}</td>
                    <td>{{ list.amount }}</td>
                </tr>
            </tbody>

            <tfoot>
                <tr>

                    <td colspan="2" style="text-align: right;">মোট</td>
                    <td>{{ totalAmount }}</td>
                </tr>
            </tfoot>


            </table>
        </div>

    </div>

    <div class="overlay" v-if="popup">
        <form class="row fixed" @submit.stop.prevent="onPaySubmit">

            <div class="col-md-12 text-right" ><span style="padding: 7px 3px;background: red;color: white;border-radius: 7px;cursor: pointer;" @click="closePoup">Close</span></div>

            <div class="col-12">
                <div class="form-group">
                    <label for="">ধরন</label>
                    <input type="text" class="form-control" v-model="form.khat">
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <label for="">টাকার পরিমাণ</label>
                    <input type="tel" class="form-control" v-model="form.amount">
                </div>
            </div>


            <div class="col-12">
                <div class="form-group">
                    <label for="">অর্থ-বছর</label>
                    <select class="form-control" v-model="form.orthobochor">
                        <option value="">Select</option>
                        <option>2019-2020</option>
                        <option>2020-2021</option>
                        <option>2021-2022</option>
                        <option>2023-2024</option>
                        <option>2024-2025</option>
                    </select>
                </div>
            </div>


            <div class="col-12">
                <div class="form-group">

                    <button type="button" class="btn btn-info" v-if="bottonLoader" style="font-size: 18px;">Please Wait Until Redirect....</button>
                    <button type="submit" class="btn btn-info" v-else style="font-size: 18px;"> Pay Now</button>
                </div>
            </div>





    </form>
    </div>





    </div>




</template>
<script>
export default {
    name: "home",
    created() {
    },

    data() {
        return {

            lists:{},
            totalAmount:0,
            preLooding:false,
            bottonLoader:false,
            popup:false,
            poupitems:{},
            form:{
                khat:'',
                amount:'',
                orthobochor:'',
            }
        };
    },
    mounted() {
        this.getdatas();
    },
    methods: {





        async getdatas(){
            var tender_id = this.$route.params.tender_id
            var res = await this.callApi('get',`/api/tender/payment/${tender_id}`,[]);
            this.lists = res.data;
            res.data.forEach(e => {
                this.totalAmount += Number(e.amount)
                // console.log(e)

            });
        },

        async onPaySubmit() {

            this.bottonLoader = true
            this.preLooding = true

            var tender_id = this.$route.params.tender_id
            this.form['tanderid'] = tender_id;

                var res = await this.callApi('post', '/api/tander_invoices', this.form);
                if(res.status==201){
                    Notification.customSuccess('Success');
                    window.location.href = res.data.redirectutl
                    this.bottonLoader = false
                    this.preLooding = false
                }else{
                    Notification.customError('Error');
                    this.bottonLoader = false
                    this.preLooding = false
                }
                // console.log(res)




            },



        showImage(){
            this.popup = true;

        },
        closePoup(){
            this.popup = false;

        }
    }
};





</script>
<style lang="css" scoped>
#img_size {
    width: 40px;
}
.row.fixed {
    background: #e5e5e5;
    padding: 13px 5px;
    position: fixed;
    width: 75%;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    overflow: auto;
    height: 80vh;
}
.overlay {
    width: 100%;
    height: 100vh;
    position: fixed;
    background: #000000a6;
    top: 0;
    left: 0;
    z-index: 9999;
}
</style>
