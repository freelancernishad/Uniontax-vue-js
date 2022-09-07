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
            <div class="card-head">
                <input type="text" class="form-control" v-model="sonod_id" @input="searchSondId">
            </div>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item,index) in items" :key="item.id">
                            <td>{{ item.sonod_Id }}</td>
                            <td>{{ item.unioun_name }}</td>
                            <td>{{ item.applicant_name }}</td>
                            <td>{{ item.applicant_father_name }}</td>
                            <td>{{ item.applicant_present_village }}</td>
                            <td>{{ item.applicant_national_id_number }}</td>
                            <td>{{ item.created_at }}</td>
                            <td>
                                <!-- <span size="sm" @click="deletefun(item, index, $event.target)" class="btn btn-danger mr-1 mt-1">Delete</span> -->
                                <a size="sm" target="_blank"
                                    :href="applicationRoute+'/' + item.sonod_name + '/' + item.id"
                                    v-if="applicationRoute != ''" class="btn btn-success mr-1 mt-1">আবেদন পত্র</a>
                                <!-- <router-link size="sm" :to="{ name: EditRoute, params: { id: item.id } }" class="btn btn-info mr-1 mt-1">Edit</router-link> -->
                                <span size="sm" v-if="buttonLoader" class="btn btn-info mr-1 mt-1"><img width="20px"
                                        src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif"
                                        alt=""></span>
                                <span size="sm" @click="info(item, index, $event.target)" v-else-if="viewRoute != ''"
                                    class="btn btn-info mr-1 mt-1">View</span>
                                <span size="sm"
                                    @click="approve(approveRoute, item.id, approveData, $event.target, approveType,item)"
                                    v-if="approveRoute != '' && item.payment_status == 'Unpaid'"
                                    class="btn btn-success mr-1 mt-1">Approve</span>
                                <span size="sm"
                                    @click="approve('/api/sonod', item.id, approveData, $event.target, 'apiAction',item)"
                                    v-else-if="approveRoute != '' && item.payment_status == 'Paid'"
                                    class="btn btn-success mr-1 mt-1">Approve</span>
                                <span size="sm" @click="paynow(payRoute, item.id, $event.target)"
                                    v-if="item.payment_status == 'Unpaid' && item.stutus == 'approved' && payRoute != ''"
                                    class="btn btn-info mr-1 mt-1">Pay Now</span>
                                <a :href="'/invoice/d/' + item.id" target="_blank" size="sm"
                                    v-if="item.stutus == 'approved'" class="btn btn-info mr-1 mt-1">রশিদ</a>
                                <a :href="'/sonod/d/' + item.id" target="_blank" size="sm"
                                    v-if="item.stutus == 'approved' && item.payment_status == 'Paid'"
                                    class="btn btn-info mr-1 mt-1">সনদ</a>
                                <span size="sm" @click="cancel(cancelRoute, item.id, 'cancel', $event.target)"
                                    v-if="cancelRoute != ''" class="btn btn-danger mr-1 mt-1">Not-Approve</span>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>



                    </tfoot>
                </table>







                <!-- <approve-component></approve-component> -->
            </div>
        </div>



        <nav aria-label="Page navigation example" v-if="TotalRows>20">
            <ul class="pagination  justify-content-end">
                <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->

                <li class="page-item" v-for="(pag,index) in Totalpage" :key="'p'+index" v-if="index==0 && pag.url">
                    <router-link class="page-link"
                        :to="{name:'sonod',params:{name:$route.params.name,type:$route.params.type},query:{page:pag.url.split('?')[1].split('=')[1]}}"
                        v-html="pag.label"></router-link>
                </li>



                <li class="page-item" v-for="(pag,index) in Totalpage" :key="'i'+index"
                    :class="{active:pag.active,'disabled':pag.label=='...'}"
                    v-if="index!=0 && pag.label!='Next &raquo;'">
                    <router-link class="page-link"
                        :to="{name:'sonod',params:{name:$route.params.name,type:$route.params.type},query:{page:pag.label}}"
                        v-html="pag.label"></router-link>
                </li>



                <li class="page-item" v-for="(pag,index) in Totalpage" :key="'l'+index"
                    v-if="pag.label=='Next &raquo;'  && pag.url">
                    <router-link class="page-link"
                        :to="{name:'sonod',params:{name:$route.params.name,type:$route.params.type},query:{page:pag.url.split('?')[1].split('=')[1]}}"
                        v-html="pag.label"></router-link>
                </li>

                <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
            </ul>
        </nav>

        <!-- Info modal -->
        <b-modal :id="infoModal.id" size="xl" :title="infoModal.title" ok-only>
            <div class="row">
                <div class="col-md-12">
                    <div class="app-heading">আবেদনকারীর তথ্য</div>
                </div>
                <div class="col-md-4 mt-3"></div>
                <div class="col-md-4 mt-3"><img width="100%" :src="$asseturl + infoModal.content.image" alt=""></div>
                <div class="col-md-4 mt-3"></div>
                <div class="col-md-4 col-6 mt-3"><b>আবেদনকারীর নাম : </b>{{ infoModal.content.applicant_name }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="SonodName.enname == 'Certification of the same name'">
                    <b>আবেদনকারীর দ্বিতীয় নাম : </b>{{ infoModal.content.applicant_second_name }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>লিঙ্গ : </b>{{ infoModal.content.applicant_gender }}</div>
                <div class="col-md-4 col-6 mt-3"><b>আবেদনকারীর পিতা/স্বামীর নাম : </b>{{
                infoModal.content.applicant_father_name
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>আবেদনকারীর পিতা জীবিত কিনা : </b>{{
                infoModal.content.successor_father_alive_status
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>আবেদনকারীর মাতার নাম : </b>{{
                infoModal.content.applicant_mother_name
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>আবেদনকারীর মাতা জীবিত কিনা : </b>{{
                infoModal.content.successor_mother_alive_status
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ন্যাশনাল আইডি : </b>{{
                infoModal.content.applicant_national_id_number
                }}
                    <span v-if="nidverify" class="badge badge-pill badge-success mg-t-8">Verified</span>
                    <span v-else class="badge badge-pill badge-danger mg-t-8">Unverified</span>
                </div>
                <div class="col-md-4 col-6 mt-3"><b>জন্ম নিবন্ধন নং : </b>{{
                infoModal.content.applicant_birth_certificate_number
                }}
                    <span v-if="dobverify" class="badge badge-pill badge-success mg-t-8">Verified</span>
                    <span v-else class="badge badge-pill badge-danger mg-t-8">Unverified</span>
                </div>
                <div class="col-md-4 col-6 mt-3"><b>হোল্ডিং নং : </b>{{ infoModal.content.applicant_holding_tax_number
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জম্ম তারিখ : </b>{{ infoModal.content.applicant_date_of_birth }}
                </div>
                <div class="col-md-4 col-6 mt-3" v-if="SonodName.enname == 'Family certificate'"><b>বংশের নাম : </b>{{
                infoModal.content.family_name }}</div>
                <div class="col-md-4 col-6 mt-3"
                    v-if="SonodName.enname == 'Certificate of annual income' || SonodName.enname == 'Parents Income Certificate'">
                    <b>বার্ষিক আয় : </b>{{ infoModal.content.Annual_income }}
                </div>
                <div class="col-md-4 col-6 mt-3" v-if="SonodName.enname == 'permit'"><b>অনুমতি এর বিষয় : </b>{{
                infoModal.content.Subject_to_permission }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="SonodName.bnname=='প্রতিবন্ধী সনদপত্র'"><b>প্রতিবন্ধী : </b>{{
                infoModal.content.disabled }}</div>
                <div class="col-md-4 col-6 mt-3"
                    v-if="SonodName.enname == 'No Objection Letter to Transfer of Constituency'"><b>স্থানান্তরিত এলাকার
                        নাম : </b>{{ infoModal.content.Name_of_the_transferred_area }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="SonodName.enname == 'Certificate'"><b>প্রত্যয়নপত্র এর বিষয় :
                    </b>{{ infoModal.content.The_subject_of_the_certificate }}</div>
                <div class="col-md-4 col-6 mt-3"><b>বয়স: </b>{{ infoModal.content.applicant_date_of_birth }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পাসপোর্ট নং : </b>{{ infoModal.content.applicant_passport_number }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>বৈবাহিক সম্পর্ক : </b>{{ infoModal.content.applicant_marriage_status
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পেশা: </b>{{ infoModal.content.applicant_occupation }}</div>
                <div class="col-md-4 col-6 mt-3"><b>শিক্ষাগত যোগ্যতা: </b>{{ infoModal.content.applicant_education }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>ধর্ম: </b>{{ infoModal.content.applicant_religion }}</div>
                <div class="col-md-4 col-6 mt-3"><b>বাসিন্দা: </b>{{ infoModal.content.applicant_resident_status }}
                </div>
                <div class="col-md-12 col-12 mt-3" v-if="infoModal.content.sonod_name!='ট্রেড লাইসেন্স'"><b>আবেদনকৃত
                        প্রত্যয়নের বিবরণ: <br> </b>{{ infoModal.content.prottoyon }}</div>
                <div class="col-md-12 col-12 mt-3"
                    v-if="infoModal.content.stutus=='Secretary_approved' || infoModal.content.stutus=='approved'">
                    <b>প্রত্যয়ন প্রদানের বিবরণ: <br> </b>
                    <span v-html="infoModal.content.sec_prottoyon"></span>
                </div>
                <div class="col-md-12">
                    <div class="app-heading">বর্তমান ঠিকানা</div>
                </div>
                <div class="col-md-4 col-6 mt-3"><b>গ্রাম/মহল্লা: </b>{{ infoModal.content.applicant_present_village }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>রোড/ব্লক/সেক্টর: </b>{{
                infoModal.content.applicant_present_road_block_sector
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ওয়ার্ড নং: </b>{{ infoModal.content.applicant_present_word_number }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>জেলা: </b>{{ infoModal.content.applicant_present_district }}</div>
                <div class="col-md-4 col-6 mt-3"><b>উপজেলা/থানা: </b>{{ infoModal.content.applicant_present_Upazila }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>পোষ্ট অফিস: </b>{{ infoModal.content.applicant_present_post_office
                }}</div>
                <div class="col-md-12">
                    <div class="app-heading">স্থায়ী ঠিকানা</div>
                </div>
                <div class="col-md-4 col-6 mt-3"><b>গ্রাম/মহল্লা: </b>{{ infoModal.content.applicant_permanent_village
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>রোড/ব্লক/সেক্টর: </b>{{
                infoModal.content.applicant_permanent_road_block_sector
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ওয়ার্ড নং: </b>{{ infoModal.content.applicant_permanent_word_number
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জেলা: </b>{{ infoModal.content.applicant_permanent_district }}</div>
                <div class="col-md-4 col-6 mt-3"><b>উপজেলা/থানা: </b>{{ infoModal.content.applicant_permanent_Upazila }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>পোষ্ট অফিস: </b>{{ infoModal.content.applicant_permanent_post_office
                }}</div>
                <div class="col-md-12">
                    <div class="app-heading">যোগাযোগের ঠিকানা</div>
                </div>
                <div class="col-md-6 col-6 mt-3"><b>মোবাইল: </b>{{ infoModal.content.applicant_mobile }}</div>
                <div class="col-md-6 col-6 mt-3"><b>ইমেল: </b>{{ infoModal.content.applicant_email }}</div>
                <div class="col-md-12">
                    <div class="app-heading">Attachment</div>
                </div>
                <div class="col-md-4 col-6 mt-3"><span>ন্যাশনাল আইডি (Front page)</span> <br> <img width="100%"
                        :src="$asseturl + infoModal.content.applicant_national_id_front_attachment" alt=""></div>
                <div class="col-md-4 col-6 mt-3"><span>ন্যাশনাল আইডি (Back page)</span> <br> <img width="100%"
                        :src="$asseturl + infoModal.content.applicant_national_id_back_attachment" alt=""></div>
                <div class="col-md-4 col-6 mt-3"><span>জন্ম নিবন্ধন</span> <br> <img width="100%"
                        :src="$asseturl + infoModal.content.applicant_birth_certificate_attachment" alt=""></div>
                <div class="col-md-12"
                    v-if="infoModal.content.sonod_name=='ওয়ারিশ সনদ' || infoModal.content.sonod_name=='উত্তরাধিকারী সনদ'">
                    <div class="app-heading" v-if="infoModal.content.sonod_name=='ওয়ারিশ সনদ'">ওয়ারিশগনের তালিকা </div>
                    <div class="app-heading" v-else-if="infoModal.content.sonod_name=='উত্তরাধিকারী সনদ'">
                        উত্তরাধিকারীগনের তালিকা </div>
                </div>
                <table class="table"
                    v-if="infoModal.content.sonod_name=='ওয়ারিশ সনদ' || infoModal.content.sonod_name=='উত্তরাধিকারী সনদ'">
                    <tr>
                        <th>ক্রমিক</th>
                        <th>নাম</th>
                        <th>সম্পর্ক</th>
                        <th>জন্ম তারিখ</th>
                        <th>জাতীয় পরিচয়পত্র নাম্বার</th>
                    </tr>
                    <tr v-for="(ut,index) in JSON.parse(infoModal.content.successor_list)" :key="'ut'+index">
                        <td>{{ ut.w_id }}</td>
                        <td>{{ ut.w_name }}</td>
                        <td>{{ ut.w_relation }}</td>
                        <td>{{ ut.w_age }}</td>
                        <td>{{ ut.w_nid }}</td>
                    </tr>
                </table>
            </div>
        </b-modal>
        <!-- Info modal -->
        <b-modal :id="actionModal.id" size="xl" :title="actionModal.title" ok-only>
            <div v-if="actionModal.title == 'Cancel'">
                <form v-on:submit.prevent="formcancel">
                    <div class="form-group">
                        <label for="">বাতিল এর কারন উল্লেখ করুন</label>
                        <textarea class="form-control" v-model="b.reson" cols="30" rows="10"
                            style="height:100px;resize:none"></textarea>
                    </div>
                    <button type="submit" class="btn btn-info">Not Approve</button>
                </form>
            </div>
            <div v-else>
                <approvetrade :approve-data="actionModal.status" :sonod-id="actionModal.content_id"
                    :Details="actionModal.content" @event-name="sonodList" v-if="SonodName.enname == 'Trade license'">
                </approvetrade>
                <approvesonod :approve-data="actionModal.status" :sonod-id="actionModal.content_id"
                    :Details="actionModal.content" @event-name="sonodList" v-else>
                </approvesonod>
            </div>
        </b-modal>
    </div>
</template>
<script>
export default {
    computed: {
    },
    created() {
        if (this.$route.params.type == 'cancel') {
            this.fields.push({ key: 'cancedby', label: 'বাতিল করেছে', sortable: true },);
        }
    },
    data() {
        return {
            preLooding: true,
            nidverify: false,
            dobverify: false,
            buttonLoader: false,
            Type: '',
            sonod_id: '',
            cancelRoute: '',
            approveRoute: '',
            approveType: '',
            payRoute: '',
            applicationRoute: '/document',
            items: [],
            f: {
                paymentType: '',
                district: '',
            },
            b: {
                reson: '',
            },
            infoModal: {
                id: 'info-modal',
                title: '',
                content: {},
                content_id: '',
            },
            prottoyonModal: {
                id: 'prottoyon-modal',
                title: '',
                content: {},
                content_id: '',
            },
            actionModal: {
                id: 'action-modal',
                title: '',
                status: '',
                content: {},
                content_id: '',
            },
            PerPageData: '20',
            TotalRows: '1',
            Totalpage: {},

        }
    },
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

        searchSondId(){
            this.sonodList(true,this.sonod_id)
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
                } else {
                    this.approveRoute = '';
                }
                if (this.$localStorage.getItem('position') == 'District_admin' || this.$localStorage.getItem('position') == 'Thana_admin') {
                }
            }
        },
        async info(item, index, button) {
            this.buttonLoader = true;
            this.infoModal.title = `${item.applicant_name}`
            this.infoModal.content = item
            console.log(JSON.parse(item.successor_list))
            var applicant_national_id_number = item.applicant_national_id_number;
            var applicant_birth_certificate_number = item.applicant_birth_certificate_number;
            var nidVerify = await this.callApi('get', `/api/niddob/verify?applicant_national_id_number=${applicant_national_id_number}`, []);
            var dobVerify = await this.callApi('get', `/api/niddob/verify?applicant_birth_certificate_number=${applicant_birth_certificate_number}`, []);
            if (nidVerify.data == 1) {
                this.nidverify = true
            } else {
                this.nidverify = false
            }
            if (dobVerify.data == 1) {
                this.dobverify = true;
            } else {
                this.dobverify = false;
            }
            this.buttonLoader = false;
            this.$root.$emit('bv::show::modal', this.infoModal.id, button)
        },
        async approve(route, id, status, button, ApproveType, item) {
            // console.log(item.sonod_name)
            if (ApproveType == 'vueAction') {
                this.actionModal.content_id = `${id}`;
                this.actionModal.status = `${status}`;
                this.actionModal.content = item;
                this.$root.$emit('bv::show::modal', this.actionModal.id, button)
            } else if (ApproveType == 'apiAction') {
                if (this.Users.position == 'Secretary') {
                    this.actionModal.content_id = `${id}`;
                    this.actionModal.status = `${status}`;
                    this.actionModal.content = item;
                    this.$root.$emit('bv::show::modal', this.actionModal.id, button)
                } else {
                    this.preLooding = true
                    Swal.fire({
                        title: 'Are you sure?',
                        text: `${status} this data!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: `Yes, ${status} it!`
                    }).then(async (result) => {
                        if (result.isConfirmed) {
                            var res = await this.callApi('get', `${route}/${status}/${id}`, []);
                            Notification.customSuccess(`Your data has been ${status}`);
                            this.preLooding = false
                            this.sonodList()
                        } else {
                            this.preLooding = false
                        }
                    })
                }
            }
        },
        async cancel(route, id, status, button) {
            console.log(id)
            this.actionModal.content_id = `${id}`;
            this.actionModal.title = `Cancel`;
            this.$root.$emit('bv::show::modal', this.actionModal.id, button)
        },
        async formcancel() {
            var id = this.actionModal.content_id;
            this.b['names'] = this.Users.names;
            this.b['user_id'] = this.Users.id;
            this.b['position'] = this.Users.position;
            this.b['unioun'] = this.Users.unioun;
            this.b['status'] = 'cancel';
            this.b['sonod_id'] = id;
            var res = await this.callApi('post', `${this.cancelRoute}/cancel/${id}`, this.b);
            // console.log(res)
            this.$root.$emit('bv::hide::modal', this.actionModal.id)
            this.sonodList()
            this.actionModal.content_id = ''
            this.actionModal.title = ''
            this.actionModal.content = {}
            this.b = {
                reson: '',
            }
            Notification.customSuccess(`Your data has been Canceled`);
        },
        async uniondata() {
            if (this.$route.params.name) {
                var res = await this.callApi('get', `/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_', ' ')}`, []);
                this.$store.commit('setUpdateSonodName', res.data)
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
        async sonodList(auto = false,sondId='') {
            if (!auto) this.preLooding = true

            var page = 1;
            if (this.$route.query.page) page = this.$route.query.page;


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
                if (this.$localStorage.getItem('position') == 'Chairman' || this.$localStorage.getItem('position') == 'Secretary') var unioun = `&unioun_name=${this.Users.unioun}`
                if (this.$localStorage.getItem('position') == 'Thana_admin') {
                    var unioun = ``
                }


                if(sondId){

                    var res = await this.callApi('get', `/api/sonod/list?page=${page}&sonod_name=${this.$route.params.name}${unioun}&stutus=${stutus}&payment_status=${payment_status}&sondId=${sondId}`, []);
                }else{
                    var res = await this.callApi('get', `/api/sonod/list?page=${page}&sonod_name=${this.$route.params.name}${unioun}&stutus=${stutus}&payment_status=${payment_status}`, []);

                }




                // var res = await this.callApi('get', `/api/sonod/list?page=${page}&sonod_name=${this.$route.params.name}${unioun}&filter[stutus]=${stutus}&filter[payment_status]=${payment_status}`, []);



                this.items = res.data.data
                this.TotalRows = `${this.items.length}`;
                // console.log(this.TotalRows)
                this.Totalpage = res.data.links
                if (!auto) window.scrollTo(0, 0);
                if (!auto) this.preLooding = false
            }
            this.actionAccess()
        },
        age(dateOf = '2001-08-25') {
            var dateofbirth = dateOf.split("-");
            var y1 = dateofbirth[0];
            var m1 = dateofbirth[1];
            var d1 = dateofbirth[2];
            var date = new Date();
            var d2 = date.getDate();
            var m2 = 1 + date.getMonth();
            var y2 = date.getFullYear();
            var month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            if (d1 > d2) {
                d2 = d2 + month[m2 - 1];
                m2 = m2 - 1;
            }
            if (m1 > m2) {
                m2 = m2 + 12;
                y2 = y2 - 1;
            }
            var d = d2 - d1;
            var m = m2 - m1;
            var y = y2 - y1;
            return y + ' Years ' + m + ' Months ' + d + ' Days ';
        },
    },
    mounted() {
        this.uniondata();
        setTimeout(() => {
            this.sonodList();
        }, 2000);
        setInterval(() => {
            this.sonodList(true)
        }, 5000);
    }
}
</script>
<style scoped>
th.position-relative {
    font-size: 13px;
}

td {
    font-size: 14px;
}

li.page-item.active a {
    color: white !important;
}
</style>
