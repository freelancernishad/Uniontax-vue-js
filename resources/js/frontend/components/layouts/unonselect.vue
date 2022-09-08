<template>
<div class="d-flex justify-content-between align-items-center">
                        <select class='searchFrom form-control' name="division" id="division" v-model="division" @change="getdistrictFun" >
                            <option value="">বিভাগ নির্বাচন করুন</option>
                                <option v-for="div in getdivisions" :key="div.id" :value="div.id">{{ div.bn_name }}</option>
                        </select>
                        <select   class='searchFrom form-control' name="district" id="district" v-model="district" @change="getthanaFun" >
                            <option value="">জেলা নির্বাচন করুন</option>
                            <option v-for="dist in getdistricts" :key="dist.id" :value="dist.id">{{ dist.bn_name }}</option>
                        </select>
                        <select  class='searchFrom form-control' name="thana" id="thana" v-model="thana" @change="getuniounFun" >
                            <option value="">উপজেলা নির্বাচন করুন</option>
                            <option v-for="thana in getthanas" :key="thana.id" :value="thana.id">{{ thana.bn_name }}</option>
                        </select>

                        <select  @change="changeunioun"  class='searchFrom form-control' v-model="unioun" id="unioun">
                            <option value="">ইউনিয়ন নির্বাচন করুন</option>

                           <!-- <option value="">ইউনিয়ন</option> -->
                           <option v-for="union in getuniouns" :key="union.id" :value="union.url">{{ union.bn_name }}</option>
                        </select>
<!--
                        <select  @change="changeunioun()"  class='searchFrom form-control' v-model="unioun" id="unioun">
                           <option value="">ইউনিয়ন</option><option value="Chilahati">চিলাহাটি</option><option value="Shaldanga">শালডাঙ্গা</option><option value="Debiganj Sadar">দেবীগঞ্জ সদর</option><option value="Pamuli">পামুলী</option><option value="Sundardighi">সুন্দরদিঘী</option><option value="Sonahar Mollikadaha">সোনাহার মল্লিকাদহ</option><option value="Tepriganj">টেপ্রীগঞ্জ</option><option value="Dandopal">দন্ডপাল</option><option value="Debiduba">দেবীডুবা</option><option value="Chengthi Hazra Danga">চেংঠী হাজরা ডাঙ্গা</option>
                        </select> -->


</div>
</template>
<script>
export default {
    props: {
        CustomUrl:{
            type:String,
            default:''
        }
    },
    data(){
        return {

            division:'',
            district:'',
            thana:'',
            unioun:'',

            getdivisions:{},
            getdistricts:{},
            getthanas:{},
            getuniouns:{},




        }
    },
    methods: {


       async getdivisionFun(){
         var res = await this.callApi('get',`/api/getdivisions`,[]);
         this.getdivisions = res.data;
        },

       async getdistrictFun(){

         var res = await this.callApi('get',`/api/getdistrict?id=${this.division}`,[]);
         this.getdistricts = res.data;
        },

       async getthanaFun(){
         var res = await this.callApi('get',`/api/getthana?id=${this.district}`,[]);
         this.getthanas = res.data;
        },

       async getuniounFun(){
         var res = await this.callApi('get',`/api/getunioun?id=${this.thana}`,[]);
         this.getuniouns = res.data;
        },


        changeunioun(){





                window.location.href = this.unioun+this.CustomUrl
                console.log(this.unioun+this.CustomUrl)



        //     var url =  this.$appUrl.split("//");

        //    var redirect = url[0]+'//'+this.unioun.replaceAll(' ', '_').toLowerCase()+'.'+url[1]+''+this.CustomUrl;
        //    window.location.href= redirect;
        }
    },
    mounted() {
        this.getdivisionFun();
    },
}
</script>
