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






            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header" style="display: flex;align-items: center;justify-content: space-between;">
                            <div class="form-group" style="width: 50%;">
                                <input type="month"  class="form-control"  v-model="month">
                            </div>
                            <router-link :to="{name:'cashbookForm'}" class="btn btn-info">ব্যয়ের হিসাব যোগ করুন</router-link>

                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>তারিখ</th>
                                        <th>ব্যয়ের বিবরণ</th>
                                        <th>টাকার পরিমাণ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>তারিখ</td>
                                        <td>ব্যয়ের বিবরণ</td>
                                        <td>টাকার পরিমাণ</td>
                                    </tr>
                                </tbody>
                            </table>





                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-group">
                                <select name="" id="" class="form-control" v-model="year">

                                    <option value="">নির্বাচন করুন</option>
                                    <option value="2022">2022</option>
                                    <option value="2021">2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                    <option value="2017">2017</option>
                                    <option value="2016">2016</option>
                                    <option value="2015">2015</option>
                                    <option value="2014">2014</option>
                                    <option value="2013">2013</option>
                                    <option value="2012">2012</option>
                                    <option value="2011">2011</option>
                                    <option value="2010">2010</option>
                                    <option value="2009">2009</option>
                                    <option value="2008">2008</option>
                                    <option value="2007">2007</option>
                                    <option value="2006">2006</option>
                                    <option value="2005">2005</option>
                                    <option value="2004">2004</option>
                                    <option value="2003">2003</option>
                                    <option value="2002">2002</option>
                                    <option value="2001">2001</option>
                                    <option value="2000">2000</option>

                                </select>
                            </div>

                        </div>
                        <div class="card-body">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>মাসের নাম</th>
                                        <th>কার্যক্রম</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>মাসের নাম</td>
                                        <td>কার্যক্রম</td>

                                    </tr>
                                </tbody>
                            </table>


                        </div>
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
