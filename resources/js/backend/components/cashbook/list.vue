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
                                <input type="month"  class="form-control"  v-model="month" @change="monthSearch">
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
                                    <tr v-for="(list,index) in rows" :key="'item'+index">
                                        <td>{{ list.date }}</td>
                                        <td>{{ list.description }}</td>
                                        <td>{{ list.price }}</td>
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
                                <select name="" id="" class="form-control" v-model="year" @change="yearSearch">

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
                                    <tr v-for="(yearList,inde) in dataYears" :key="'yearList'+inde">
                                        <td>{{ yearList.month }}</td>
                                        <td>
                                            <router-link :to="{name:'cashbook',query:{year:year,month:yearList.month}}" class="btn btn-info">দেখুন</router-link>

                                            <a target="_blank" :href="'/cashbook/download?unioun_name='+$localStorage.getItem('unioun')+'&year='+year+'&month='+yearList.month" class="btn btn-info">রিপোর্ট</a>
                                        </td>

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
            month:this.dateformatGlobal()[11],
            year:this.dateformatGlobal()[9],
            isload:false,
            rows:{},
            dataYears:{},

        };
    },

    watch: {
        '$route': {
            handler(newValue, oldValue) {
                if(this.$route.query.year && this.$route.query.month){
                    this.month = this.$route.query.year+'-'+this.getMonthFromString(this.$route.query.month).toString().padStart(2, '0');
                    this.getdata();
                }
            },
            deep: true
        }
    },

    mounted() {

    },
    methods: {



        monthSearch(){
            this.getdata();
        },

        yearSearch(){
            this.getYearList();
        },

        async getdata(){
            this.isload = true
            var uinon_name = ''
            if(localStorage.getItem('position')=='Secretary' || localStorage.getItem('position')=='Chairman'){
                this.form['union'] = localStorage.getItem('unioun')
                uinon_name = localStorage.getItem('unioun')
            }

            var res = await this.callApi('get',`/api/cash/expenditure?unioun_name=${uinon_name}&month=${this.month}&type=month`,[]);
            // this.$router.push({name:'report',query: {''}})
            this.rows = res.data
            this.isload = false
        },
        async getYearList(){
            this.isload = true
            var uinon_name = ''
            if(localStorage.getItem('position')=='Secretary' || localStorage.getItem('position')=='Chairman'){
                this.form['union'] = localStorage.getItem('unioun')
                uinon_name = localStorage.getItem('unioun')
            }

            var res = await this.callApi('get',`/api/cash/expenditure?unioun_name=${uinon_name}&year=${this.year}&type=year`,[]);
            // this.$router.push({name:'report',query: {''}})
            this.dataYears = res.data
            this.isload = false
        }


    },
    mounted() {

        if(this.$route.query.year && this.$route.query.month){
            this.month = this.$route.query.year+'-'+this.getMonthFromString(this.$route.query.month).toString().padStart(2, '0');
            this.getdata();
        }else{

            this.getdata();
        }

        this.getYearList();

    },
};
</script>
<style lang="css" scoped>
</style>
