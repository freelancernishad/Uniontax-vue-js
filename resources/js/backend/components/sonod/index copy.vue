<template>
<div>


<div class="breadcrumbs-area">
    <h3>{{ SonodName.bnname }}</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>{{ SonodName.bnname }}</li>
    </ul>
</div>



<div class="card height-auto">
      <div class="card-body">
 <div class="form-group">
  <label for="">Search</label>
<input type="text" class="form-control" placeholder="Find any item" v-model="filtername">
</div>



  <table id="datatable" class="table" >
    <thead>
        <tr>
            <th>নাম</th>
            <th>পিতার/স্বামীর নাম</th>
            <th>গ্রাম/মহল্লা</th>
            <th>ন্যাশনাল আইডি</th>
            <th> আরো তথ্য</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(item, index) in filterItem">
                <td>{{ item.applicant_name }}</td>
                <td>{{ item.applicant_father_name }}</td>
                <td>{{ item.applicant_present_village }}</td>
                <td>{{ item.applicant_national_id_number }}</td>
                <td>{{ item.sonod_name }}</td>
                <td></td>


            </tr>

    </tbody>
 </table>


    <b-pagination
      v-model="current"
      :total-rows="totalpage"
      :per-page="pageSize"
      first-text="First"
      prev-text="Prev"
      next-text="Next"
      last-text="Last"
      align="right"
    ></b-pagination>
    </div>
    </div>
    </div>
</template>

<script>

export default {


 mounted () {
this.sonodList();






  },
  data(){
    return {


    current: 1,
    pageSize: 10,
    totalpage: 0,



    search: '',
    selectedType: '',
    startDate:null,
    endDate:null,
    filtername:'',
    sonodnamedata:{},
    items: [],

    }
  },
    watch: {
    '$route': async function(to, from) {
      if(this.$route.params.name){
         var res =  await this.callApi('get',`/api/sonod/list?sonod_name=${this.$route.params.name}`,[]);
            this.items = res.data
                    //  this.totalpage = Math.round(this.items.length/this.pageSize);
                     this.totalpage = this.items.length;


           }
        }
    },
computed: {

   indexStart() {
      return (this.current - 1) * this.pageSize;
    },
    indexEnd() {
      return this.indexStart + this.pageSize;
    },
    // paginated() {
    //   return this.alphabets.slice(this.indexStart, this.indexEnd);
    // },














   filterItem: function () {
     return this.filteritems(this.items)
    }
  },

  methods: {
    prev() {
        if(this.current==1){
            return false;
        }

      this.current--;
    },
    next() {
        if(this.current==this.totalpage){
            return false;
        }
      this.current++;
    },
















            filteritems: function(products) {
                // return products.filter(product => !product.name.indexOf(this.filtername))


                var allitem = products.filter(product => {
                    return  product.applicant_name.toLowerCase().match(this.filtername.toLowerCase()) || product.applicant_father_name.match(this.filtername) || product.applicant_present_village.match(this.filtername) || product.applicant_national_id_number.match(this.filtername) || product.sonod_name.match(this.filtername)

                  })
                    return allitem.slice(this.indexStart, this.indexEnd);

            },

        sonodname(){
            if(this.$route.params.name){
              axios.get(`/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_',' ')}`)
                .then(({ data }) => {
                  this.sonodnamedata = data
                })
                .catch()
            }

        },
       async sonodList(){
           if(this.$route.params.name){
             var res = await this.callApi('get',`/api/sonod/list?sonod_name=${this.$route.params.name}`,[]);
            this.items = res.data
            this.totalpage = this.items.length;

           }
        }




    }
}
</script>
