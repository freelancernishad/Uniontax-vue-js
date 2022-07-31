<template>
  <div class="RightSidebar mt-3" :class="ClassName">
                <div class="sidebarTitle mb-3 defaltColor" >
                    <h4>উপদেষ্টা ও তত্ত্বাবধানে</h4>
                </div>
                <p class="sidebaruser text-center">
                    <img width="70%" alt="" :src="$asseturl+'assets/img/fb71ff2546046a9a64178679c70a6521.png'" />
                </p>
                <div class="contactInfo text-center" >
                    <span><b>জসীম উদ্দীন হায়দার</b></span> <br />
                    <span><b>জেলা প্রশাসক ও জেলা ম্যাজিস্ট্রেট</b></span> <br />
                </div>

        <div class="sidebarTitle mb-3 defaltColor"  >
                    <h4>পরিকল্পনা ও বাস্তবায়নে</h4>
                </div>


                <p class="sidebaruser text-center"  >
                    <img width="70%" alt="" :src="$asseturl+'assets/img/0f0a882a453a4d2b22037af67bbecb27.png'" />
                </p>
                <div class="contactInfo text-center"  >
                    <span><b> মোঃ আতিকুর রহমান</b></span> <br />
                    <span><b>প্রোগ্রামার</b></span> <br />
                </div>



                <div class="sidebarTitle mb-3 defaltColor"  >
                    <h4>পরিকল্পনা, বাস্তবায়ন এবং কারিগরী পরামর্শক</h4>
                </div>


                <p class="sidebaruser text-center"  >
                    <img width="70%" alt="" :src="$asseturl+'assets/img/61fa48285f305025824869.jpg'" />
                </p>
                <div class="contactInfo text-center"  >
                    <span><b> মিথুন কুমার রায়</b></span> <br />
                    <span><b>সহকারী নেটওয়ার্ক ইঞ্জিনিয়ার</b></span> <br />
                </div>




                <div class="sidebarTitle mb-3 defaltColor"  v-if="getType=='main'">
                    <h4>পরিকল্পনা ও বাস্তবায়নে</h4>
                </div>
                <p class="sidebaruser text-center"  v-if="getType=='main'">
                    <img width="70%" alt="" :src="$asseturl+'assets/img/uno-pic.png'" />
                </p>
                <div class="contactInfo text-center"  v-if="getType=='main'">
                    <span><b> সোহাগ চন্দ্র সাহা</b></span> <br />
                    <span><b>উপজেলা নির্বাহী অফিসার</b></span> <br />
                </div>


                <div class="sidebarTitle mb-3 defaltColor"  v-if="getType=='Union'">
                        <h4>এক নজরে {{  getunionInfos.short_name_b  }} ইউনিয়ন</h4>
                    </div>
                    <p class='sidebaruser text-center' v-if="getType=='Union'">
                        <img width="100%" height="100px" alt="" :src="getunionInfos.u_image"> </p>
                <div class="contactInfo text-center" v-if="getType=='Union'">
                    <span style='font-size:13px'>{{ getunionInfos.u_description }}</span> <br>




                </div>

                    <div class="sidebarTitle mb-3 defaltColor" v-if="getType=='Union'">
                        <h4>নোটিশ</h4>
                    </div>
                    <p class='sidebaruser text-center' v-if="getType=='Union'">
                    </p>
                <div class="contactInfo text-center" v-if="getType=='Union'">
                    <span style='font-size:13px'>{{ getunionInfos.u_notice }}</span> <br>

                </div>



                <div class="sidebarTitle mb-3 defaltColor">
                    <h4>জরুরি হটলাইন</h4>
                </div>

                <div class="column block">
                    <img width="100%" :src="$asseturl+'assets/img/suport.jpg'" alt="" />
                </div>

                <div class="fb-page" data-href="https://www.facebook.com/unotetuliaofficial" data-width="350"
                    data-height="300" data-adapt-container-width="true" data-show-facepile="true"></div>

                <div id="fb-root"></div>

                <iframe
                    :src="getunionInfos.google_map"
                    allowfullscreen="" loading="lazy"></iframe>
            </div>
</template>
<script>
export default {
    props:{
        ClassName:{
            type:String,
            default:'col-md-3'
        }
    }
}
</script>
