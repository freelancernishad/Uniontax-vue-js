<template>
    <div>
 <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

<div class="breadcrumbs-area">
    <h3>Tenders List</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Tenders List</li>
    </ul>
</div>




        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'tenderlistadd' }" class="btn btn-info">Add New</router-link>
            </div>
        <div class="card-body">


            <table class="table">
            <thead>

                <tr>
                    <th>ইজারার ধরণ</th>
                    <th>ইজারার শিরোনাম</th>
                    <th>ওয়ার্ড নং</th>
                    <th>সরকারি মূল্য</th>
                    <th>শুরু তারিখ</th>
                    <th>শেষ তারিখ</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>
                <tr v-for="(item,index) in items" :key="''+item.id">
                    <td>{{ item.tender_type }}</td>
                    <td>{{ item.tender_name }}</td>
                    <td>{{ item.tender_word_no }}</td>
                    <td>{{ item.govt_price }}</td>
                    <td>{{ item.tender_start }}</td>
                    <td>{{ item.tender_end }}</td>
                    <td>
                        <a size="sm" target="_blank" :href="'/tenders/'+ item.tender_id" class="btn btn-danger mr-1 mt-1">Tender form</a>

                        <router-link size="sm" :to="{ name: 'tendersubmitlist', params: { tender_id: item.id } }" class="btn btn-success mr-1 mt-1">Submited Tender</router-link>
                        <router-link size="sm" :to="{ name: 'tenderlistedit', params: { id: item.id } }" class="btn btn-info mr-1 mt-1">Edit</router-link>
                    </td>

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
    created() {


    },
    data() {
        return {

            preLooding:true,

            access:'',
            sortstatus:false,
            Filter:true,
            addNew:'tenderlistadd',
            FilterOn:false,
            PerPage:false,
            deleteRoute:'/api/get/users/delete',
            editRoute:'tenderlistedit',
            applicationRoute:'',
            viewRoute:'',
            approveRoute:'',
            cancelRoute:'',
            approveType:'',
            approveData:'',
            payRoute:'',
            PerPageData:'10',
            TotalRows:'1',
            Type:'',
            items: [],
            fields: [
                { key: 'names', label: 'নাম', sortable: true },
                { key: 'unioun', label: 'ইউনিয়ন', sortable: true },
                { key: 'thana', label: 'উপজেলা', sortable: true },
                { key: 'district', label: 'জেলা', sortable: true },
                { key: 'position', label: 'পদবি', sortable: true },

                { key: 'actions', label: 'Actions' }
            ],


        }
    },
    // updated(){

    //  this.sonodList();

    // },

  watch: {
        '$route':  {
            handler(newValue, oldValue) {

        // hello


      },
      deep: true



        }
    },

    methods: {


        sonodname(){
            var position = this.Users.position
            var thana = this.Users.thana
              axios.get(`/api/tender`)
                .then(({ data }) => {
                    // console.log(data)
                  this.items = data
                  this.TotalRows = `${this.items.length}`;
                  this.preLooding = false
                })
                .catch()
        },

    },
    mounted() {
        setTimeout(()=>{

            this.sonodname();
        }, 2000);


    }


}
</script>
