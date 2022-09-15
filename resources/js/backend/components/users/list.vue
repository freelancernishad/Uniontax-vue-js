<template>
    <div>
 <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

<div class="breadcrumbs-area">
    <h3>Users List</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Users List</li>
    </ul>
</div>




        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'userlistadd' }" class="btn btn-info">Add New</router-link>
            </div>
        <div class="card-body">


            <table class="table">
            <thead>

                <tr>
                    <th>নাম</th>
                    <th>ইউনিয়ন</th>
                    <th>উপজেলা</th>
                    <th>জেলা</th>
                    <th>পদবি</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>
                <tr v-for="(item,index) in items" :key="''+item.id">
                    <td>{{ item.names }}</td>
                    <td>{{ item.unioun }}</td>
                    <td>{{ item.thana }}</td>
                    <td>{{ item.district }}</td>
                    <td>{{ item.position }}</td>
                    <td><router-link size="sm" :to="{ name: 'userlistedit', params: { id: item.id } }"
                    class="btn btn-info mr-1 mt-1">
                    Edit
                </router-link></td>

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
            addNew:'userlistadd',
            FilterOn:false,
            PerPage:false,
            deleteRoute:'/api/get/users/delete',
            editRoute:'userlistedit',
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
              axios.get(`/api/get/users/list?position=${position}&thana=${thana}`)
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
