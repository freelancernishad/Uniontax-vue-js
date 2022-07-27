<template>

    <div>
        <!-- User Interface controls -->
        <b-row>
            <b-col lg="6" class="my-1" v-if="SortOptionsStaus">
                <b-form-group label="Sort" label-for="sort-by-select" label-cols-sm="3" label-align-sm="right"
                    label-size="sm" class="mb-0" v-slot="{ ariaDescribedby }">
                    <b-input-group size="sm">
                        <b-form-select id="sort-by-select" v-model="sortBy" :options="sortOptions"
                            :aria-describedby="ariaDescribedby" class="w-75">
                            <template #first>
                                <option value="">-- none --</option>
                            </template>
                        </b-form-select>

                        <b-form-select v-model="sortDesc" :disabled="!sortBy" :aria-describedby="ariaDescribedby"
                            size="sm" class="w-25">
                            <option :value="false">Asc</option>
                            <option :value="true">Desc</option>
                        </b-form-select>
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col lg="6" class="my-1" v-if="SortOptionsStaus">
                <b-form-group label="Initial sort" label-for="initial-sort-select" label-cols-sm="3"
                    label-align-sm="right" label-size="sm" class="mb-0">
                    <b-form-select id="initial-sort-select" v-model="sortDirection" :options="['asc', 'desc', 'last']"
                        size="sm"></b-form-select>
                </b-form-group>
            </b-col>

            <b-col lg="6" class="my-1" v-if="Filter">
                <b-form-group label="Filter" label-for="filter-input" label-cols-sm="3" label-align-sm="right"
                    class="mb-0">
                    <b-input-group >
                        <b-form-input id="filter-input" v-model="filter" type="search" placeholder="Type to Search">
                        </b-form-input>

                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>

            <b-col lg="6" class="my-1" v-if="FilterOn">
                <b-form-group v-model="sortDirection" label="Filter On"
                    description="Leave all unchecked to filter on all data" label-cols-sm="3" label-align-sm="right"
                    label-size="sm" class="mb-0" v-slot="{ ariaDescribedby }">
                    <b-form-checkbox-group v-model="filterOn" :aria-describedby="ariaDescribedby" class="mt-1">
                        <b-form-checkbox value="name">Name</b-form-checkbox>
                        <b-form-checkbox value="age">Age</b-form-checkbox>
                        <b-form-checkbox value="isActive">Active</b-form-checkbox>
                    </b-form-checkbox-group>
                </b-form-group>
            </b-col>

            <b-col sm="5" md="6" class="my-1" v-if="PerPage">
                <b-form-group label="Per page" label-for="per-page-select" label-cols-sm="6" label-cols-md="4"
                    label-cols-lg="3" label-align-sm="right" label-size="sm" class="mb-0">
                    <b-form-select id="per-page-select" v-model="perPage" :options="pageOptions" size="sm">
                    </b-form-select>
                </b-form-group>
            </b-col>


        </b-row>

        <!-- Main table element -->
        <b-table :items="Items" :fields="Fields" :current-page="currentPage" :per-page="PerPageData" :filter="filter"
            :filter-included-fields="filterOn" :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
            :sort-direction="sortDirection" stacked="md" show-empty small @filtered="onFiltered">


           <template #cell(name)="row">
                {{ row.value.first }} {{ row.value.last }}
            </template>

            <template #cell(actions)="row">



                <span size="sm" @click="deletefun(row.item, row.index, $event.target)" v-if="DeleteRoute!=''" class="btn btn-danger mr-1">
                    Delete
                </span>

                <a size="sm" target="_blank" :href="ApplicationRoute+'/'+row.item.sonod_name+'/'+row.item.id"  v-if="ApplicationRoute!=''" class="btn btn-success mr-1">
                    আবেদন পত্র
                </a>


                <router-link size="sm" :to="{name:EditRoute,params:{id:row.item.id}}"  v-if="EditRoute!=''" class="btn btn-info mr-1">
                    Edit
                </router-link>

                <span size="sm" @click="info(row.item,row.index, $event.target)"  v-if="ViewRoute!=''" class="btn btn-success mr-1">
                    View
                </span>

                <!-- <router-link size="sm" :to="{name:ViewRoute,params:{id:row.item.id}}" @click="info(ApproveRoute,row.item.id,ApproveData, $event.target)"  v-if="ViewRoute!=''" class="btn btn-success mr-1">
                    View
                </router-link> -->

                <span size="sm" @click="approve(ApproveRoute,row.item.id,ApproveData, $event.target)" v-if="ApproveRoute!=''" class="btn btn-success mr-1">
                    Approve
                </span>

                <span size="sm" @click="paynow(PayRoute,row.item.id, $event.target)" v-if="row.item.payment_status=='Unpaid' && row.item.stutus=='approved' && PayRoute!=''" class="btn btn-info mr-1">
                    Pay Now
                </span>

                <a :href="'/invoice/d/'+row.item.id" target="_blank" size="sm" v-if="row.item.stutus=='approved'" class="btn btn-info mr-1">
                    রশিদ
                </a>
                <a :href="'/sonod/d/'+row.item.id" target="_blank" size="sm"  v-if="row.item.payment_status=='Paid'" class="btn btn-info mr-1">
                     সনদ
                </a>
<!--
                <router-link size="sm" :to="{name:ApproveRoute,params:{id:row.item.id}}"  v-if="ApproveRoute!='' && ApproveType=='vueAction'" class="btn btn-success mr-1">
                    Approve
                </router-link> -->

                <span size="sm" @click="approve(CancelRoute,row.item.id,'cancel', $event.target)" v-if="CancelRoute!=''" class="btn btn-danger mr-1">
                    Cancel
                </span>

            </template>

            <template #row-details="row">
                <b-card>
                    <ul>
                        <li v-for="(value, key) in row.item" :key="key">{{ key }}: {{ value }}</li>
                    </ul>
                </b-card>
            </template>



        </b-table>






    <b-pagination
      v-model="currentPage"
      :total-rows="TotalRows"
      :per-page="PerPageData"
      first-text="First"
      prev-text="Prev"
      next-text="Next"
      last-text="Last"
      align="right"
    ></b-pagination>





        <!-- Info modal -->
        <b-modal :id="infoModal.id" size="xl" :title="infoModal.title" ok-only @hide="resetInfoModal">
            <approvetrade :approve-data="ApproveData" :sonod-id="infoModal.content_id" @event-name="sonodList"  v-if="SonodType=='Trade_license'"></approvetrade>
            <approvesonod :approve-data="ApproveData" :sonod-id="infoModal.content_id" @event-name="sonodList"  v-else></approvesonod>

            <!-- <pre>{{ infoModal.content_id }}</pre> -->


        </b-modal>

        <!-- Info modal -->
        <b-modal :id="viewModal.id" size="xl" :title="viewModal.title" ok-only @hide="resetInfoModal">


            <div class="row">

                <div class="col-md-4 col-6 mt-3"><b>ন্যাশনাল আইডি : </b>{{ viewModal.content.applicant_national_id_number }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জন্ম নিবন্ধন নং : </b>{{ viewModal.content.applicant_birth_certificate_number }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পাসপোর্ট নং : </b>{{ viewModal.content.applicant_passport_number }}</div>

                <div class="col-md-4 col-6 mt-3"><b>জম্ম তারিখ : </b>{{ viewModal.content.applicant_date_of_birth }}</div>
                <div class="col-md-4 col-6 mt-3"><b>নাম: </b>{{ viewModal.content.applicant_name }}</div>
                <div class="col-md-4 col-6 mt-3"><b>লিঙ্গ: </b>{{ viewModal.content.applicant_gender }}</div>

                <div class="col-md-4 col-6 mt-3"><b>বৈবাহিক সম্পর্ক : </b>{{ viewModal.content.applicant_marriage_status }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পিতার নাম: </b>{{ viewModal.content.applicant_father_name }}</div>
                <div class="col-md-4 col-6 mt-3"><b>মাতার নাম: </b>{{ viewModal.content.applicant_mother_name }}</div>

                <div class="col-md-4 col-6 mt-3"><b>পেশা : </b>{{ viewModal.content.applicant_occupation }}</div>
                <div class="col-md-4 col-6 mt-3"><b>শিক্ষাগত যোগ্যতা: </b>{{ viewModal.content.applicant_education }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ধর্ম : </b>{{ viewModal.content.applicant_religion }}</div>
                <div class="col-md-4 col-6 mt-3"><b>বাসিন্দা : </b>{{ viewModal.content.applicant_resident_status }}</div>


            <div class="col-md-12 mt-5 mb-1">
                <h5>বর্তমান ঠিকানা</h5>
            </div>

                <div class="col-md-4 col-6 mt-3"><b>গ্রাম/মহল্লা: </b>{{ viewModal.content.applicant_present_village }}</div>
                <div class="col-md-4 col-6 mt-3"><b>রোড/ব্লক/সেক্টর: </b>{{ viewModal.content.applicant_present_road_block_sector }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ওয়ার্ড নং: </b>{{ viewModal.content.applicant_present_word_number }}</div>

                <div class="col-md-4 col-6 mt-3"><b>জেলা: </b>{{ viewModal.content.applicant_present_district }}</div>
                <div class="col-md-4 col-6 mt-3"><b>উপজেলা/থানা: </b>{{ viewModal.content.applicant_present_Upazila }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পোষ্ট অফিস: </b>{{ viewModal.content.applicant_present_post_office }}</div>

            <div class="col-md-12 mt-5 mb-1">
                <h5>স্থায়ী ঠিকানা</h5>
            </div>

                <div class="col-md-4 col-6 mt-3"><b>গ্রাম/মহল্লা: </b>{{ viewModal.content.applicant_permanent_village }}</div>
                <div class="col-md-4 col-6 mt-3"><b>রোড/ব্লক/সেক্টর: </b>{{ viewModal.content.applicant_permanent_road_block_sector }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ওয়ার্ড নং: </b>{{ viewModal.content.applicant_permanent_word_number }}</div>

                <div class="col-md-4 col-6 mt-3"><b>জেলা: </b>{{ viewModal.content.applicant_permanent_district }}</div>
                <div class="col-md-4 col-6 mt-3"><b>উপজেলা/থানা: </b>{{ viewModal.content.applicant_permanent_Upazila }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পোষ্ট অফিস: </b>{{ viewModal.content.applicant_permanent_post_office }}</div>

            <div class="col-md-12 mt-5 mb-1">
                <h5>Attachment</h5>
            </div>

                <div class="col-md-4 col-6 mt-3"><span>ন্যাশনাল আইডি (Front page)</span> <br> <img width="100%" :src="$asseturl + viewModal.content.applicant_national_id_front_attachment" alt=""></div>


                <div class="col-md-4 col-6 mt-3"><span>ন্যাশনাল আইডি (Back page)</span> <br> <img width="100%" :src="$asseturl + viewModal.content.applicant_national_id_back_attachment" alt=""></div>

                <div class="col-md-4 col-6 mt-3"><span>জন্ম নিবন্ধন</span> <br> <img width="100%" :src="$asseturl + viewModal.content.applicant_birth_certificate_attachment" alt=""></div>





            </div>


        </b-modal>

    </div>

</template>

<script>
export default {
    props: {
        SonodType: {
            type: String,
            default: ''
        },
        SortOptionsStaus: {
            type: Boolean,
            default: false
        },
         Filter: {
            type: Boolean,
            default: false
        },
        FilterOn: {
            type: Boolean,
            default: false
        },

        PerPage: {
            type: Boolean,
            default: false
        },
        Items: {
            type: Array,
            default: [],
        },
        Fields: {
            type: Array,
            default: [],
        },
        PerPageData: {
            type: String,
            default: 10,
        },
        TotalRows: {
            type: String,
            default: 1,
        },
        DeleteRoute: {
            type: String,
            default: '',
        },
        EditRoute: {
            type: String,
            default: '',
        },
        ViewRoute: {
            type: String,
            default: '',
        },
        ApplicationRoute: {
            type: String,
            default: '',
        },
        ApproveRoute: {
            type: String,
            default: '',
        },
        PayRoute: {
            type: String,
            default: '',
        },
        ApproveData: {
            type: String,
            default: 'approved',
        },
        ApproveType: {
            type: String,
            default: 'apiAction',
        },
        CancelRoute: {
            type: String,
            default: '',
        },
        ApproveComponent: {
            type: String,
            default: '',
        }

    },


    data() {
        return {


            // totalRows: 1,
            currentPage: 1,
            perPage: 5,
            // pageOptions: [5, 10, 15, { value: 100, text: "Show a lot" }],
            sortBy: '',
            sortDesc: false,
            sortDirection: 'asc',
            filter: null,
            filterOn: [],
            infoModal: {
                id: 'info-modal',
                title: '',
                content: '',
                content_id: '',
            },
            viewModal: {
                id: 'view-modal',
                title: '',
                content: '',
                content_id: '',
            }
        }
    },
    computed: {
        sortOptions() {
            // Create an options list from our fields
            return this.Fields
                .filter(f => f.sortable)
                .map(f => {
                    return { text: f.label, value: f.key }
                })
        }
    },
    mounted() {
        // Set the initial number of items
        // this.totalRows = this.Items.length




    },
    methods: {
        info(item, index, button) {
            this.viewModal.title = `${item.applicant_name}`
            this.viewModal.content = item
            this.$root.$emit('bv::show::modal', this.viewModal.id, button)
        },


        resetInfoModal() {
            this.infoModal.title = ''
            this.infoModal.content = ''
        },
        onFiltered(filteredItems) {
            // Trigger pagination to update the number of buttons/pages due to filtering
            // this.totalRows = filteredItems.length
            this.currentPage = 1
        },


        sonodList(){
            return this.$emit('event-name')
        },

        async approve(route,id,status,button){

            if(this.ApproveType=='vueAction'){
 this.infoModal.content_id = `${id}`;
                this.$root.$emit('bv::show::modal', this.infoModal.id, button)

            }else if(this.ApproveType=='apiAction'){
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


                var res = await this.callApi('get',`${route}/${status}/${id}`,[]);
                Notification.customSuccess(`Your data has been ${status}`);
                this.$emit('event-name')



                    }
                })

                }


        },

        async paynow(route,id,button){

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Pay this data!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: `Yes, Pay it!`
                }).then(async (result) => {
                    if (result.isConfirmed) {


                var res = await this.callApi('get',`${route}/${id}`,[]);
                Notification.customSuccess(`Your data has been Paid`);
                this.$emit('event-name')



                    }
                })




        },


         deletefun(item, index, event){
            // console.log('item: '+item.id, 'index: '+index, 'event: '+event)




			Swal.fire({
				title: 'Are you sure?',
				text: "You won't be able to revert this!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: `Yes, ${this.action} it!`
			}).then(async (result) => {
				if (result.isConfirmed) {



            var res = await this.callApi('get',`${this.DeleteRoute}/${item.id}`,[]);
      Notification.customdelete(`Your data has been Deleted!`);
            this.$emit('event-name')



				}
			})







        }

    }
}
</script>
<style>
.modal-dialog.modal-xl {
    max-width: 1200px;
}
</style>
