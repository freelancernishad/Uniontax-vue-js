<template>
    <div>

            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>ইস্যুকৃত সনদ প্রতিবেদন</h3>
                <ul>
                    <li>
                        <router-link :to="{ name: 'Dashboard' }">ড্যাশবোর্ড</router-link>
                    </li>
                    <li>ইস্যুকৃত সনদ প্রতিবেদন </li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->

            <div class="card">

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                            <!-- <th>ক্রমিক নং</th> -->
                            <th>ইউনিয়ন</th>
                            <th>ইস্যুকৃত সনদ</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="row in rows" :key="row.id">
                            <!-- <td>ক্রমিক নং</td> -->
                            <td>{{ row.Unionname }}</td>

                            <td>{{ row.approved }}</td>

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

        if(localStorage.getItem('position')=='District_admin'){
            this.form.union ='';
        }else{
            this.form.union = localStorage.getItem('unioun');

        }
    },
    data() {
        return {
            form:{
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
this.onSubmit();
    },
    methods: {





        async onSubmit(){
            this.isload = true

            var userid = localStorage.getItem('userid');
            var res = await this.callApi('get',`/api/sonodcountall?userid=${userid}`,[]);
            // this.$router.push({name:'report',query: {''}})
            this.rows = res.data
            this.isload = false
        }


    },
};
</script>
<style lang="css" scoped>
</style>
