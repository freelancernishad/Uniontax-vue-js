<template>
<div class="d-flex justify-content-between align-items-center">
                        <select class='searchFrom form-control' name="division" id="division" readonly>

                                <option value="বরিশাল">বরিশাল</option>
                        </select>
                        <select   class='searchFrom form-control' name="district" id="district" readonly>
                            <option value="বরিশাল">বরিশাল</option>
                        </select>
                        <select  class='searchFrom form-control' name="thana" id="thana" readonly>
                            <option value="বরিশাল সদর">বরিশাল সদর</option>
                        </select>

                        <select  @change="changeunioun()"  class='searchFrom form-control' v-model="unioun" id="unioun">
                           <!-- <option value="">ইউনিয়ন</option> -->
                           <option value="Tungibaria">টুঙ্গীবাড়িয়া</option>
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
            unioun:'Tungibaria'
        }
    },
    methods: {
        changeunioun(){
            var url =  this.$appUrl.split("//");

           var redirect = url[0]+'//'+this.unioun.replaceAll(' ', '_').toLowerCase()+'.'+url[1]+''+this.CustomUrl;
           window.location.href= redirect;
        }
    },
}
</script>
