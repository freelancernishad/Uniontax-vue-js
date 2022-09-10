<template>
    <div>

<div class="breadcrumbs-area">
    <h3>Sonod List</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Sonod List</li>
    </ul>
</div>

    <form class="row" @submit.stop.prevent="onSubmit">


        <div class="form-group col-md-6">
          <label for="">নাম</label>
          <input type="text" v-model="form.names" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6">
          <label for="">পদবি</label>

          <select v-model="form.position" class="form-control">
            <option value="">নির্বাচন করুন</option>
            <option value="District_admin">জেলা এডমিন</option>
            <option value="Thana_admin">উপজেলা এডমিন</option>
            <option value="Chairman">চেয়ারম্যান</option>
            <option value="Secretary">সচিব</option>
          </select>

        </div>




        <div class="form-group col-md-6">
          <label for="">জেলা</label>

          <select v-model="form.district" class="form-control">
            <option selected value="পঞ্চগড়">পঞ্চগড়</option>
          </select>

        </div>


        <div class="form-group col-md-6">
          <label for="">উপজেলা</label>

          <select v-model="form.thana" class="form-control">

            <option value="">উপজেলা নির্বাচন করুন</option>
            <option value="পঞ্চগড় সদর">পঞ্চগড় সদর</option>
            <option value="দেবীগঞ্জ">দেবীগঞ্জ</option>
            <option value="বোদা">বোদা</option>
            <option value="আটোয়ারী">আটোয়ারী</option>
            <option value="তেঁতুলিয়া">তেঁতুলিয়া</option>


          </select>

        </div>


        <div class="form-group col-md-6">
          <label for="">ইউনিয়ন</label>

          <select v-model="form.unioun" class="form-control" required>
            <option value="">নির্বাচন করুন</option>

            <option v-for="un in unions" :key="un.id" :value="un.short_name_e">{{ un.full_name }}</option>

          </select>

        </div>

        <!-- <div class="form-group col-md-6" v-if="form.thana=='পঞ্চগড় সদর'">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">ইউনিয়ন নির্বাচন করুন</option> <option>পঞ্চগড় সদর</option><option>সাতমেরা</option><option>অমরখানা</option><option>হাড়িভাসা</option><option>চাকলাহাট</option><option>হাফিজাবাদ</option><option>কামাত কাজল দীঘি</option><option>ধাক্কামারা</option><option>মাগুরা</option><option>গরিনাবাড়ী</option>
          </select>
        </div>


        <div class="form-group col-md-6" v-else-if="form.thana=='দেবীগঞ্জ'">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">ইউনিয়ন নির্বাচন করুন</option> <option>চিলাহাটি</option><option>শালডাঙ্গা</option><option>দেবীগঞ্জ সদর</option><option>পামুলী</option><option>সুন্দরদিঘী</option><option>সোনাহার মল্লিকাদহ</option><option>টেপ্রীগঞ্জ</option><option>দন্ডপাল</option><option>দেবীডুবা</option><option>চেংঠী হাজরা ডাঙ্গা</option>
          </select>
        </div>


        <div class="form-group col-md-6" v-else-if="form.thana=='বোদা'">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">ইউনিয়ন নির্বাচন করুন</option> <option >ঝলইশাল শিরি</option><option >ময়দান দীঘি</option><option >বেংহারী</option><option >কাজলদীঘি কালিগঞ্জ</option><option >বড়শশী</option><option >চন্দনবাড়ী</option><option >মাড়েয়া বামনহাট</option><option >বোদা</option><option >সাকোয়া</option><option >পাচপীর</option>
          </select>
        </div>


        <div class="form-group col-md-6" v-else-if="form.thana=='আটোয়ারী'">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">ইউনিয়ন নির্বাচন করুন</option> <option>মির্জাপুর</option><option>রাধানগর</option><option>তোড়িয়া</option><option>বলরামপুর</option><option>আলোয়াখোয়া</option><option>ধামোর</option>
          </select>
        </div>


        <div class="form-group col-md-6" v-else-if="form.thana=='তেঁতুলিয়া'">
          <label for="">ইউনিয়ন</label>
          <select v-model="form.unioun" class="form-control">
            <option value="">ইউনিয়ন নির্বাচন করুন</option> <option>বাংলাবান্ধা</option><option>ভজনপুর</option><option>ভজনপুর</option><option>বুড়াবুড়ী</option><option>দেবনগর</option><option>শালবাহান</option><option>তেঁতুলিয়া</option><option>তিমাইহাট</option>
          </select>
        </div> -->



        <div class="form-group col-md-6">
          <label for="">ইমেইল</label>
          <input type="text" v-model="form.email" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="form-group col-md-6" v-if="!this.$route.params.id">
          <label for="">পাসওয়ার্ড</label>
          <input type="text" v-model="form.password" class="form-control" placeholder="" aria-describedby="helpId">
        </div>



        <div class="form-group col-md-6">
          <label for="">মোবাইল নাম্বার</label>
          <input type="text" v-model="form.phone" class="form-control" placeholder="" aria-describedby="helpId">
        </div>


        <div class="col-md-12">
    <button class="btn btn-info" type="submit">Submit</button>
</div>
    </form>


    </div>
</template>

<script>
export default {
    data(){
        return {
            form:{
                id:null,
                unioun:null,
                names:'Chairman',
                email:null,
                phone:'01909756552',
                email_verified_at:null,
                password:'uheba21',
                position:'Chairman',
                full_unioun_name:null,
                district:'পঞ্চগড়',
                thana:'',
                gram:null,
                word:null,
                description:null,
                image:null,
                status:null,
                role:1,
                remember_token:null,
                created_at:null,
                updated_at:null,
            },
            unions:{},
        }
    },
    methods:{

        async getsonodById(){
           var id =  this.$route.params.id;
            var res = await this.callApi('get', `/api/update/users/${id}`, []);
            this.form = res.data;
        },


        async onSubmit() {

            var res = await this.callApi('post', '/api/update/users', this.form);
             this.$router.push({ name: 'userlist'})
            Notification.customSuccess('User Update Success');

        },


        unionlist(){

            var position = this.Users.position
            var thana = this.Users.thana
            var district = this.Users.district
            axios.get(`/api/get/union/list?position=${position}&thana=${thana}&district=${district}`)
                .then(({ data }) => {
                    // console.log(data)
                this.unions = data

                })
                .catch()
            },

    },
    mounted(){
        if(this.$route.params.id){

            this.getsonodById();
        }

        setTimeout(()=>{
            this.unionlist();

        }, 3000);

    }
}
</script>



