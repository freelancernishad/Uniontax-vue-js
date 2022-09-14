<template>
    <div>
 <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

<div class="breadcrumbs-area">
    <h3>Sonod List</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Sonod List</li>
    </ul>
</div>




        <div class="card">
            <div class="card-header">
                <router-link :to="{ name: 'sonodlistadd' }" class="btn btn-info">Add New</router-link>
            </div>
        <div class="card-body">


            <table class="table">
            <thead>

                <tr>
                    <th>বাংলা নাম</th>
                    <th>ইংলিশ নাম</th>
                    <th>সনদ ফি</th>
                    <th>Actions</th>
                </tr>

            </thead>

            <tbody>
                <tr v-for="(item,index) in items" :key="''+item.id">
                    <td>{{ item.bnname }}</td>
                    <td>{{ item.enname }}</td>
                    <td>{{ item.sonod_fee }}</td>
                    <td><router-link size="sm" :to="{ name: 'sonodlistedit', params: { id: item.id } }"
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

            preLooding:false,

            access:'',
            sortstatus:false,
            Filter:true,
            addNew:'sonodlistadd',
            FilterOn:false,
            PerPage:false,
            deleteRoute:'/api/get/sonodname/delete',
            editRoute:'sonodlistedit',
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
                { key: 'bnname', label: 'বাংলা নাম', sortable: true },
                { key: 'enname', label: 'ইংলিশ নাম', sortable: true },
                { key: 'sonod_fee', label: 'সনদ ফি', sortable: true },


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
            this.preLooding = true
              axios.get(`/api/get/sonodname/list`)
                .then(({ data }) => {
                    console.log(data)
                  this.items = data
                  this.TotalRows = `${this.items.length}`;
                  this.preLooding = false
                })
                .catch()
        },

    },
    mounted() {

        this.sonodname();


    }


}
</script>
