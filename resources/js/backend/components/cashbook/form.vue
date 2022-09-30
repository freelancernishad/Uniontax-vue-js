<template>
    <div>

            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>ক্যাশ বহি</h3>
                <ul>
                    <li>
                        <router-link :to="{ name: 'Dashboard' }">ড্যাশবোর্ড</router-link>
                    </li>
                    <li>ক্যাশ বহি </li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->


                    <div class="card">
                        <div class="card-body">

                            <form class="row" action="">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">তারিখ</label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">টাকার পরিমাণ</label>
                                        <input type="tel" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ব্যয়ের বিবরণ</label>
                                        <textarea class="form-control" style="height:100px;resize:none"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit">সাবমিট</button>
                                </div>
                            </form>

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

        };
    },
    mounted() {

    },
    methods: {

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
