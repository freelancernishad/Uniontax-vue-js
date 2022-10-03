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

                            <form class="row" @submit.stop.prevent="onSubmit" >


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">তারিখ</label>
                                        <input type="date" v-model="form.date" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">টাকার পরিমাণ</label>
                                        <input type="tel" v-model="form.price" class="form-control">
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">ব্যয়ের বিবরণ</label>
                                        <textarea class="form-control" v-model="form.description" style="height:100px;resize:none"></textarea>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="button" v-if="isload" class="btn btn-success">অপেক্ষা করুন....</button>
                                    <button type="submit" v-else class="btn btn-success">সাবমিট</button>
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
                'unioun_name':'',
                'date':'',
                'price':'',
                'description':'',
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
                this.form['unioun_name'] = localStorage.getItem('unioun')
            }
            var res = await this.callApi('post',`/api/cash/expenditure`,this.form);
            this.rows = res.data
            this.isload = false
            this.$router.push({ name: 'cashbook'})
    Notification.customSuccess('Successfuly Done');
        }


    },
};
</script>
<style lang="css" scoped>
</style>
