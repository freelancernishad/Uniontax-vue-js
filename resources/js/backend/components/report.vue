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
                <div class="card-header" style="display: flex;justify-content: space-between;align-items: center;">
                    <form @submit.stop.prevent="onSubmit">
                        <div class="d-flex">

                            <div class="form-group">
                                <select v-model="form.sonod_type" id="sonod" class="form-control" required>
                                    <option value="">চিহ্নিত করুন</option>
                                    <option  value="all">সকল</option>
                                    <option value="holdingtax">হোল্ডিং ট্যাক্স</option>
                                    <option v-for="(sonod, r) in SonodNamesAdmin" :key="'dropdown' + r" :value="sonod.bnname">{{ sonod.bnname }}</option>
                                </select>
                            </div>

                            <div class="form-group ml-3">
                                <input type="date" v-model="form.from" class="form-control">
                            </div>

                            <div class="form-group ml-3">
                                <input type="date" v-model="form.to" class="form-control">
                            </div>

                            <div class="form-group ml-3">
                                <button type="button" style="font-size: 22px;margin-left: 10px;" class="btn btn-info" disabled v-if="isload">অপেক্ষা করুন....</button>
                                <button type="submit" style="font-size: 22px;margin-left: 10px;" class="btn btn-info" v-else>খুজুন</button>
                            </div>

                        </div>


                    </form>

                    <a style="    font-size: 20px;" target="_blank" :href="'/report/export?sonod_type='+form.sonod_type+'&from='+form.from+'&to='+form.to+'&union='+$localStorage.getItem('unioun')"  v-if="form.sonod_type!='' && form.from!='' && form.to!=''" class="btn btn-info">প্রতিবেদন ডাউনলোড</a>



                </div>
                <div class="card-body">
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
</template>
<script>

export default {
    computed: {

    },
    async created() {

    },
    data() {
        return {
            form:{
                sonod_type:'',
                from:'',
                to:'',
            },
            isload:false,
            rows:{},
            SonodNamesAdmin:{},
        };
    },
    mounted() {
        this.getSonodNamesAdmin();
    },
    methods: {


        async getSonodNamesAdmin(){


        var res = await this.callApi('get', '/api/get/sonodname/list?admin=1', []);
        this.SonodNamesAdmin = res.data


        },



        async onSubmit(){
            this.isload = true

            if(localStorage.getItem('position')=='Secretary' || localStorage.getItem('position')=='Chairman'){
                this.form['union'] = this.getUsers.unioun
            }



            var res = await this.callApi('post',`/api/report/search`,this.form);
            // this.$router.push({name:'report',query: {''}})
            this.rows = res.data
            this.isload = false
        }


    },
};
</script>
<style lang="css" scoped>
</style>
