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
                <tr v-for="(item,index) in filteredItems" :key="''+item.id">
                    <td>{{ item.tender_type }}</td>
                    <td>{{ item.tender_name }}</td>
                    <td>{{ item.tender_word_no }}</td>
                    <td>{{ item.govt_price }}</td>
                    <td>{{ item.tender_start }}</td>
                    <td>{{ item.tender_end }}</td>
                    <td>
                        <a size="sm" target="_blank" :href="'/tenders/'+ item.tender_id" class="btn btn-danger mr-1 mt-1">সিডিউল ফর্ম</a>

                        <span size="sm" @click="tenderComitti(item.id)" class="btn btn-success mr-1 mt-1" v-if="!item.commette1phone && !item.commette2phone && !item.commette3phone">মূল্যায়ন কমিটি তৈরি করুন</span>

                        <span size="sm" @click="tenderComittiVeiw(item)" class="btn btn-success mr-1 mt-1" v-else>মূল্যায়ন কমিটি দেখুন</span>


                        <span size="sm" @click="tendeSelection(item)" class="btn btn-success mr-1 mt-1" v-if="item.isOpen"  >মূল্যায়ন করার জন্য ক্লিক দিন</span>

                        <!-- <router-link size="sm" :to="{ name: 'tendersubmitlist', params: { tender_id: item.id } }" class="btn btn-success mr-1 mt-1">Submited Tender</router-link> -->
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
    filteredItems() {
      const currentDateTime = new Date();

      return this.items.map(entry => {
        const tenderOpenTime = new Date(entry.tender_open);
        return {
          ...entry,
          isOpen: currentDateTime >= tenderOpenTime
        };
      });
    }
    },
    created() {


    },
    data() {
        return {
            currentDateTime: '',

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


        tenderComittiVeiw(item){
            Swal.fire({
                        title:'তিন জন কমিটির ফোন নাম্বার',
                        html:`


                        <ol style='text-align:left;font-size:18px'>
                            <li>${item.commette1phone}</li>
                            <li>${item.commette2phone}</li>
                            <li>${item.commette3phone}</li>
                        </ol>

                        `

                    })
        },

        tenderComitti(id){
            Swal.fire({
            title: 'Result Committe',
            html:
                `
                <div class="form-group">
                    <lable>Comitte one phone number</lable>
                    <input id="committe1" class="swal2-input" required>
                </div>
                <div class="form-group">
                    <lable>Comitte two phone number</lable>
                    <input id="committe2" class="swal2-input" required>
                </div>
                <div class="form-group">
                    <lable>Comitte three phone number</lable>
                    <input id="committe3" class="swal2-input" required>
                </div>
                `,
            focusConfirm: false,
            preConfirm: async (resolve) => {
                var committe1 = document.getElementById('committe1').value
                var committe2 = document.getElementById('committe2').value
                var committe3 = document.getElementById('committe3').value
                if(committe1 && committe2 && committe3){
                    var formValues = {};
                    formValues['commette1phone'] = committe1;
                    formValues['commette2phone'] = committe2;
                    formValues['commette3phone'] = committe3;
                    var res = await this.callApi('post',`/api/committe/update/${id}`,formValues);
                    if(res.status==200){
                        Swal.fire({
                        title:'মূল্যায়ন কমিটি সফল ভাবে গঠন হয়েছে',
                        icon:'success'
                    })
                    this.sonodname();
                    }else{
                        Swal.fire({
                        title:'কিছু একটা সমস্যা হয়েছে',
                        icon:'error'
                    })
                    }
                }else{
                    Swal.fire({
                        title:'সবগুলো ফোন নাম্বার পূরণ করুন',
                        icon:'error'
                    })
                }
            }
            })
        },



        tendeSelection(item){
            Swal.fire({
            title: 'Result Committe',
            html:
                `
                <div class="form-group">
                    <lable>Comitte one phone number</lable>
                    <input type='text' id="commette1phone" class="swal2-input" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <lable>Comitte one password</lable>
                    <input type='password' id="commette1pass" class="swal2-input" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <lable>Comitte one phone number</lable>
                    <input type='text' id="commette2phone" class="swal2-input" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <lable>Comitte one password</lable>
                    <input type='password' id="commette2pass" class="swal2-input" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <lable>Comitte one phone number</lable>
                    <input type='text' id="commette3phone" class="swal2-input" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <lable>Comitte one password</lable>
                    <input type='password' id="commette3pass" class="swal2-input" autocomplete="off" required>
                </div>

                `,
            focusConfirm: false,
            preConfirm: async (resolve) => {

                var commette1phone = document.getElementById('commette1phone').value
                var commette1pass = document.getElementById('commette1pass').value

                var commette2phone = document.getElementById('commette2phone').value
                var commette2pass = document.getElementById('commette2pass').value

                var commette3phone = document.getElementById('commette3phone').value
                var commette3pass = document.getElementById('commette3pass').value

                if(commette1phone && commette1pass && commette2phone && commette2pass && commette3phone && commette3pass){

                    if(commette1phone===item.commette1phone && commette2phone===item.commette2phone && commette3phone===item.commette3phone && commette1pass===item.commette1pass && commette2pass===item.commette2pass && commette3pass===item.commette3pass){

                        Swal.fire({
                            title:'ইজারা মূল্যায়ন করার জন্য প্রস্তুত',
                            icon:'success'
                        })

                        this.$router.push({name:'tendersubmitlist',params:{id:item.id}});


                    }else{
                        Swal.fire({
                            title:'মূল্যায়ন কমিটির ফোন নাম্বার অথবা পাসওয়ার্ড ভুল',
                            icon:'error'
                        })
                    }
                }else{
                    Swal.fire({
                        title:'সবগুলো ফিল্ড পূরণ করুন',
                        icon:'error'
                    })
                }
            }
            })
        },





        sonodname(){
            var position = this.Users.position
            var thana = this.Users.thana
            var unioun = this.Users.unioun
              axios.get(`/api/tender?union_name=${unioun}`)
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
