<template>
    <div>
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40"
            objectbg="#999793" opacity="80" name="circular"></loader>
        <div class="breadcrumbs-area">
            <h3>{{ SonodName.bnname }} {{ Type }}</h3>
            <ul>
                <li>
                    <router-link :to="{ name: 'Dashboard' }">Home</router-link>
                </li>
                <li>{{ SonodName.bnname }} {{ Type }}</li>
            </ul>
        </div>
        <div class="card">
            <div class="card-body">


                <table class="table">
                    <thead>
                        <tr>
                            <th>সনদ নাম্বার</th>
                            <th>ইউনিয়ন</th>
                            <th>নাম</th>
                            <th>পিতার/স্বামীর নাম</th>
                            <th>গ্রাম/মহল্লা</th>
                            <th>ন্যাশনাল আইডি</th>
                            <th>আবেদনের তারিখ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in items" :key="item.id">
                            <td>{{ item.sonod_Id }}</td>
                            <td>{{ item.unioun_name }}</td>
                            <td>{{ item.applicant_name }}</td>
                            <td>{{ item.applicant_father_name }}</td>
                            <td>{{ item.applicant_present_village }}</td>
                            <td>{{ item.applicant_national_id_number }}</td>
                            <td>{{ item.created_at }}</td>
                            <td>

                            </td>
                        </tr>
                    </tbody>
                </table>


















                <table-component :sonod-type="$route.params.name" :sort-options-staus="sortstatus" :Filter="Filter"
                    :filter-on="FilterOn" :per-page="PerPage" :Items="items" :Fields="fields"
                    :per-page-data="PerPageData" :total-rows="TotalRows" :delete-route="deleteRoute"
                    :edit-route="editRoute" :application-route="applicationRoute" :view-route="viewRoute"
                    :approve-route="approveRoute" :pay-route="payRoute" :cancel-route="cancelRoute"
                    :approve-type="approveType" :approve-data="approveData" @event-name="sonodList">
                </table-component>
                <!-- <approve-component></approve-component> -->
            </div>
        </div>
    </div>
</template>
<script>

export default {
    computed: {
    },
    created() {
        this.fields =  [
                { key: 'sonod_Id', label: 'সনদ নাম্বার', sortable: true },
                { key: 'unioun_name', label: 'ইউনিয়ন', sortable: true },
                { key: 'applicant_name', label: 'নাম', sortable: true },
                { key: 'applicant_father_name', label: 'পিতার/স্বামীর নাম', sortable: true },
                { key: 'applicant_present_village', label: 'গ্রাম/মহল্লা', sortable: true },
                { key: 'applicant_national_id_number', label: 'ন্যাশনাল আইডি', sortable: true },
                {
                    key: 'created_at', label: 'আবেদনের তারিখ', sortable: true,
                    formatter: (value, key, item) => {
                        // return new Date().getFullYear()
                        return User.dateformat(value)[7]
                    }
                },


            ]
            if (this.$route.params.type == 'cancel') {

                this.fields.push({ key: 'cancedby', label: 'বাতিল করেছে',sortable: true  },);
            }


            this.fields.push( { key: 'actions', label: 'Actions' },
                { key: 'status', label: 'Status' },);
    },
    data() {
        return {
            preLooding: true,
            access: '',
            sortstatus: false,
            Filter: true,
            FilterOn: false,
            PerPage: false,
            deleteRoute: '',
            editRoute: '',
            applicationRoute: '/document',
            viewRoute: '',
            approveRoute: '',
            cancelRoute: '',
            approveType: '',
            approveData: '',
            payRoute: '',
            PerPageData: '10',
            TotalRows: '1',
            Type: '',
            unionsInfos: {
                payment_type:''
            },
            items: [],
            fields: [
                [
                { key: 'sonod_Id', label: 'সনদ নাম্বার', sortable: true },
                { key: 'unioun_name', label: 'ইউনিয়ন', sortable: true },
                { key: 'applicant_name', label: 'নাম', sortable: true },
                { key: 'applicant_father_name', label: 'পিতার/স্বামীর নাম', sortable: true },
                { key: 'applicant_present_village', label: 'গ্রাম/মহল্লা', sortable: true },
                { key: 'applicant_national_id_number', label: 'ন্যাশনাল আইডি', sortable: true },
                {
                    key: 'created_at', label: 'আবেদনের তারিখ', sortable: true,
                    formatter: (value, key, item) => {
                        // return new Date().getFullYear()
                        return User.dateformat(value)[7]
                    }
                },
                { key: 'actions', label: 'Actions' },
                { key: 'status', label: 'Status' },
            ]
            ],
        }
    },
    // updated(){
    //  this.sonodList();
    // },
    watch: {
        '$route': {
            handler(newValue, oldValue) {



                this.uniondata();
                this.sonodList();

            },
            deep: true
        }
    },
    methods: {


    async uniondata(){
                    if(this.$route.params.name){
       var res =  await this.callApi('get',`/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_',' ')}`,[]);
        this.$store.commit('setUpdateSonodName', res.data)
            }
    },



        actionAccess() {
            if (this.$route.params.type == 'new') {

                // this.deleteRoute='/api/sonod/delete';
                // this.editRoute='sonodedit';
                this.editRoute = '';
                this.viewRoute = 'sonodview';
                this.approveRoute = '';
                this.approveType = 'vueAction';
                this.approveData = 'sec_approved';
                if (this.$localStorage.getItem('position') == 'District_admin' || this.$localStorage.getItem('position') == 'Thana_admin') {
   this.cancelRoute = '';
                    this.approveRoute = '';
                    this.approveType = 'vueAction';
                    this.approveData = 'sec_approved';
                } else if (this.$localStorage.getItem('position') == 'Chairman') {

                    this.approveRoute = '/api/sonod';
                    this.approveType = 'apiAction';
                    this.approveData = `approved`;
                       this.cancelRoute = '/api/sonod';
                } else {
   this.cancelRoute = '/api/sonod';
                        this.approveRoute = 'approvetrade';
                        this.approveType = 'vueAction';
                        this.approveData = `${this.$localStorage.getItem('position')}_approved`;






                }
                this.Type = 'নতুন আবেদন';
            } else if (this.$route.params.type == 'approved') {
                this.cancelRoute = '';
                this.approveRoute = '';
                this.approveType = '';
                this.deleteRoute = '';
                // this.editRoute='sonodedit';
                this.editRoute = '';
                this.viewRoute = 'sonodview';
                this.Type = 'অনুমোদিত আবেদন';
                if (this.$localStorage.getItem('position') == 'Secretary') {
                    this.payRoute = '/api/sonod/pay';
                }
                if (this.$localStorage.getItem('position') == 'District_admin' || this.$localStorage.getItem('position') == 'Thana_admin') {

                }
            } else if (this.$route.params.type == 'cancel') {
                this.approveType = 'vueAction';
                 this.approveData = `${this.$localStorage.getItem('position')}_approved`;
                this.editRoute = '';
                this.cancelRoute = '';
                // this.deleteRoute='/api/sonod/delete';
                this.viewRoute = 'sonodview';
                this.Type = 'বাতিল আবেদন';

           if (this.$localStorage.getItem('position') == 'Secretary') {
               this.approveRoute = 'approvetrade';
                }else{
                    this.approveRoute = '';

                }

                if (this.$localStorage.getItem('position') == 'District_admin' || this.$localStorage.getItem('position') == 'Thana_admin') {

                }
            }




        },
        sonodname() {
            if (this.$route.params.name) {
                axios.get(`/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_', ' ')}`)
                    .then(({ data }) => {
                        this.sonodnamedata = data
                    })
                    .catch()
            }
        },
        async sonodList(auto = false) {
            if (!auto) this.preLooding = true
            if (this.$route.params.name) {
                var stutus = '';
                var payment_status = '';
                if (this.$route.params.type == 'new') {
                    stutus = 'Pending'
                    if (this.$localStorage.getItem('position') == 'super-admin') {
                        stutus = 'Pending'
                    } else if (this.$localStorage.getItem('position') == 'Chairman') {
                        stutus = 'Secretary_approved'
                    } else {
                        stutus = 'Pending'
                    }
                } else if (this.$route.params.type == 'approved') {
                    stutus = 'approved'
                    if (this.$localStorage.getItem('position') == 'Chairman') {
                        stutus = 'approved'
                        payment_status = 'Paid'
                    } else {
                        stutus = 'approved'
                    }
                } else {
                    stutus = this.$route.params.type;
                }
                var unioun = ``
                if (this.$localStorage.getItem('position') == 'Chairman' || this.$localStorage.getItem('position') == 'Secretary') var unioun = `&filter[unioun_name]=${this.Users.unioun}`


                if (this.$localStorage.getItem('position') == 'Thana_admin'){

                    var unioun = ``
                }


                var res = await this.callApi('get', `/api/sonod/list?sonod_name=${this.$route.params.name}${unioun}&filter[stutus]=${stutus}&filter[payment_status]=${payment_status}`, []);
                this.items = res.data
                this.TotalRows = `${this.items.length}`;

                this.actionAccess();
                if (!auto) window.scrollTo(0,0);
                if (!auto) this.preLooding = false
            }
        }
    },
    mounted() {




        this.uniondata();
        setTimeout(() => {
            this.sonodList();
        }, 2000);
        setInterval(() => {
            this.sonodList(true)
        }, 18000);
    }
}
</script>
<style>
th.position-relative {
    font-size: 13px;
}
td {
    font-size: 14px;
}
</style>
