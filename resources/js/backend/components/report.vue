<template>
    <div>

            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>প্রতিবেদন</h3>
                <ul>
                    <li>
                        <router-link :to="{ name: 'Dashboard' }">ড্যাশবোর্ড</router-link>
                    </li>
                    <li>প্রতিবেদন </li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->

            <div class="card">
                <div class="card-header" >
                    <form @submit.stop.prevent="onSubmit">
                        <div class="row" style="align-items: center; justify-content: center;">

                            <div class="form-group col-md-3" v-if="$localStorage.getItem('position')=='District_admin' || $localStorage.getItem('position')=='Thana_admin' || $localStorage.getItem('position')=='Sub_District_admin'">
                                <select v-model="form.union" id="sonod" class="form-control" required>
                                    <option value="">ইউনিয়ন নির্বাচন করুন</option>

                                    <!-- <option v-if="$localStorage.getItem('position')=='District_admin'" value="all">সকল প্রতিবেদন</option> -->

                                    <option v-for="(union,ind) in unionList" :key="'union' + ind" :value="union.short_name_e">{{ union.short_name_b }}</option>



                                </select>
                            </div>

                            <div class="form-group col-md-3">
                                <select v-model="form.sonod_type" id="sonod" class="form-control" required>
                                    <option value="">চিহ্নিত করুন</option>
                                    <option  value="all">সকল</option>
                                    <option value="holdingtax">হোল্ডিং ট্যাক্স</option>
                                    <option v-for="(sonod, r) in SonodNamesAdmin" :key="'dropdown' + r" :value="sonod.bnname">{{ sonod.bnname }}</option>
                                </select>
                            </div>



                            <div class="form-group col-md-3">
                                <select v-model="form.payment_type" id="sonod" class="form-control" required>
                                    <option value="">চিহ্নিত করুন</option>
                                    <option  value="all">সকল পেমেন্ট</option>
                                    <option  value="menual">ম্যানুয়াল পেমেন্ট</option>
                                    <option value="online">অনলাইন পেমেন্ট</option>

                                </select>
                            </div>



                            <div class="form-group col-md-3"   v-if="$localStorage.getItem('position')=='District_admin' || $localStorage.getItem('position')=='Thana_admin' || $localStorage.getItem('position')=='Sub_District_admin'">

                            </div>



                            <div class="form-group col-md-3"  v-if="$localStorage.getItem('position')=='District_admin' || $localStorage.getItem('position')=='Thana_admin' || $localStorage.getItem('position')=='Sub_District_admin'">
                                <input type="date" v-model="form.from" class="form-control">
                            </div>

                            <div class="form-group col-md-2"  v-else>
                                <input type="date" v-model="form.from" class="form-control">
                            </div>

                            <div class="form-group col-md-1"  v-if="$localStorage.getItem('position')=='District_admin' || $localStorage.getItem('position')=='Thana_admin' || $localStorage.getItem('position')=='Sub_District_admin'">
                               থেকে
                            </div>

                            <div class="form-group col-md-1"  v-else>
                               থেকে
                            </div>

                            <div class="form-group col-md-3"  v-if="$localStorage.getItem('position')=='District_admin' || $localStorage.getItem('position')=='Thana_admin' || $localStorage.getItem('position')=='Sub_District_admin'">
                                <input type="date" v-model="form.to" class="form-control">
                            </div>

                            <div class="form-group col-md-2"  v-else>
                                <input type="date" v-model="form.to" class="form-control">
                            </div>

                            <div class="form-group col-md-3">
                                <button type="button" style="font-size: 22px;margin-left: 10px;" class="btn btn-info" disabled v-if="isload">অপেক্ষা করুন....</button>
                                <button type="submit" style="font-size: 22px;margin-left: 10px;" class="btn btn-info" v-else>খুজুন</button>
                            </div>

                        </div>


                    </form>




                    <a style="    font-size: 20px;float: right;" target="_blank" :href="'/report/export?sonod_type='+form.sonod_type+'&from='+form.from+'&to='+form.to+'&union='+form.union+'&payment_type='+form.payment_type"  v-if="form.sonod_type!='' && form.from!='' && form.to!=''" class="btn btn-info">প্রতিবেদন ডাউনলোড</a>






                </div>
                <div class="card-body">
                    <div class="table-responsive tableFixHead">
                    <table class="table">
                        <thead>
                            <tr>
                            <!-- <th>ক্রমিক নং</th> -->
                            <th>তারিখ</th>
                            <th>সনদের ধরণ</th>
                            <th>টাকা</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in rows" :key="row.id">
                            <!-- <td>ক্রমিক নং</td> -->
                            <td>{{ row.date }}</td>
                            <td v-if="row.sonod_type=='holdingtax'">হোল্ডিং ট্যাক্স</td>
                            <td v-else>{{ row.sonod_type }}</td>
                            <td>{{ row.amount }}</td>
                        </tr>
                        </tbody>


                    </table>
                </div>
                </div>
            </div>




    </div>
</template>
<script>

export default {
    computed: {

    },
    async created() {

        if(localStorage.getItem('position')=='District_admin'){
            this.form.union ='';
        }else{
            this.form.union = localStorage.getItem('unioun');

        }
    },
    data() {
        return {
            form:{
                payment_type:'all',
                sonod_type:'',
                from:'',
                to:'',
            },
            isload:false,
            unionName:'',
            unionList:{},
            rows:{},
            SonodNamesAdmin:{},
        };
    },
    mounted() {
        this.getSonodNamesAdmin();
    },
    methods: {


        async getSonodNamesAdmin(){

            var  userid = localStorage.getItem('userid');
        var unions = await this.callApi('get', `/api/get/union/list?userid=${userid}`, []);
        this.unionList = unions.data



        var res = await this.callApi('get', '/api/get/sonodname/list?admin=1', []);
        this.SonodNamesAdmin = res.data


        },



        async onSubmit(){
            this.isload = true

            if(localStorage.getItem('position')=='Secretary' || localStorage.getItem('position')=='Chairman'){
                this.form['union'] = this.getUsers.unioun
            }



            var res = await this.callApi('get',`/api/payment/report/search?payment_type=${this.form.payment_type}&sonod_type=${this.form.sonod_type}&from=${this.form.from}&to=${this.form.to}&union=${this.form.union}`,[]);
            // var res = await this.callApi('get',`/api/payment/report/search`,this.form);
            // this.$router.push({name:'report',query: {''}})
            this.rows = res.data
            this.isload = false
        }


    },
};
</script>
<style lang="css" scoped>


.tableFixHead          { overflow: auto;     height: 100vh; }
.tableFixHead thead th { position: sticky; top: 0; z-index: 1; }

/* Just common table stuff. Really. */
.tableFixHead table  { border-collapse: collapse; width: 100%; }
.tableFixHead th, td { padding: 8px 16px; }
.tableFixHead th     { background:#eee; }

</style>
