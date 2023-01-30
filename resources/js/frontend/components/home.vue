<template>
    <div>
        <div class="row">
            <div class="mainBody col-md-9 mt-3">
                <div class="pmCover">
                    <!-- <vue-image-slider :images="imageArray" :intervalVal=5000 :width="width" :height="height"  /> -->
                    <vue-flux :options="vfOptions" :images="vfImages" :transitions="vfTransitions" ref="slider">
                        <template v-slot:preloader>
                            <flux-preloader />
                        </template>
                        <!-- <template v-slot:caption>
      <flux-caption />
   </template> -->
                        <!-- <template v-slot:controls>
      <flux-controls />
   </template> -->
                        <!-- <template v-slot:pagination>
      <flux-pagination />
   </template> -->
                        <!-- <template v-slot:index>
      <flux-index />
   </template> -->
                    </vue-flux>
                    <!--        <img width="100%" src="assets/img/National-Portal-Card-PM.jpeg" alt=""> --->
                </div>





                <div class="services mt-3">
                    <div class="row" v-if="getType == 'main'">
                        <div class="col-md-12">
                            <h6 class="serviceTitle position-relative defaltColor">
                                সেবাসমূহ
                            </h6>
                        </div>


                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3 mb-3 text-center"
                            v-for="(sonod, r) in SonodNames" :key="'main' + r"
                            @click="sendInfo('/application/' + sonod.enname.replaceAll(' ', '_'),$event.target)">
                            <div class="serviceBox">
                                <div class="serviceLogo">
                                    <img :src="sonod.icon" width="50%" alt="" />
                                </div>
                                <div class="serviceTitle defaltTextColor">
                                    {{ sonod.bnname }}
                                </div>
                            </div>
                        </div>



                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3 mb-3 text-center">
                            <div class="serviceBox">
                                <div class="serviceLogo">
                                    <img :src="$asseturl + 'assets/img/pic-06.png'" width="33%" alt="" />
                                </div>
                                <div class="serviceTitle">
                                    <a href="https://bdris.gov.bd/br/application" class="defaltTextColor">জন্ম নিবন্ধন
                                        সনদের আবেদন</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3 mb-3 text-center"
                            onclick="item('citizen_apps/2')" data-toggle="modal" data-target="#exampleModal">
                            <div class="serviceBox">
                                <div class="serviceLogo">
                                    <img :src="$asseturl + 'assets/img/pic-10.png'" width="33%" alt="" />
                                </div>
                                <div class="serviceTitle">
                                    <a href="https://bdris.gov.bd/dr/application" class="defaltTextColor">মৃত্যু নিবন্ধন
                                        সনদের আবেদন</a>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row" v-else>
                        <div class="col-md-12">
                            <h6 class="serviceTitle position-relative defaltColor">
                                সেবাসমূহ
                            </h6>
                        </div>






                        <router-link class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3 mb-3 text-center"
                            v-for="(sonod, rk) in SonodNames" :key="'uniondd' + rk"
                            :to="{ name: 'application', params: { name: sonod.enname.replaceAll(' ', '_') } }">
                            <div class="serviceBox">
                                <div class="serviceLogo">
                                    <img :src="sonod.icon" width="33%" alt="" />
                                </div>
                                <div class="serviceTitle defaltTextColor">
                                    {{ sonod.bnname }}
                                </div>
                            </div>
                        </router-link>

                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3 mb-3 text-center">
                            <div class="serviceBox">
                                <div class="serviceLogo">
                                    <img :src="$asseturl + 'assets/img/pic-06.png'" width="33%" alt="" />
                                </div>
                                <div class="serviceTitle">
                                    <a href="https://bdris.gov.bd/br/application" class="defaltTextColor">জন্ম নিবন্ধন
                                        সনদের আবেদন</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-3 mb-3 text-center"
                            onclick="item('citizen_apps/2')" data-toggle="modal" data-target="#exampleModal">
                            <div class="serviceBox">
                                <div class="serviceLogo">
                                    <img :src="$asseturl + 'assets/img/pic-10.png'" width="33%" alt="" />
                                </div>
                                <div class="serviceTitle">
                                    <a href="https://bdris.gov.bd/dr/application" class="defaltTextColor">মৃত্যু নিবন্ধন
                                        সনদের আবেদন</a>
                                </div>
                            </div>
                        </div>


                    </div>







<div class="row">

                        <div class="col-md-12">
                            <h6 class="serviceTitle position-relative defaltColor">
                                ক্যাশলেস ইউনিয়ন পরিষদ সেবা
                            </h6>
                        </div>
                        <div class="col-md-12">
                            <p>
                                ইউনিয়ন পরিষদ হল বাংলাদেশে পল্লী অঞ্চলের
                                সর্বনিম্ন প্রশাসনিক একক। গ্রাম চৌকিদারি আইনের
                                ১৮৭০ এর অধীনে ইউনিয়ন পরিষদের সৃষ্টি হয়। প্রাথমিক
                                পর্যায়ে এর ভূমিকা নিরাপত্তামূলক কর্মকাণ্ডে
                                সীমাবদ্ধ থাকলেও পরবর্তী কালে এটিই স্থানীয়
                                সরকারের প্রাথমিক ইউনিটের ভিত্তিরুপে গড়ে উঠে।
                                বর্তমানে ইউনিয়ন পরিষদ থেকে ট্রেড লাইসেন্স,
                                চারিত্রিক সনদপত্র, ভূমিহীন সনদপত্র, ওয়ারিশান
                                সনদপত্র, অবিবাহিত সনদপত্র, প্রত্যয়নপত্র,
                                অস্বচ্ছল প্রত্যয়নপত্র, নাগরিক সনদপত্র,
                                উত্তরাধিকার সনদপত্র ইত্যাদি সেবা প্রদান করা হয়।
                                বহুল প্রচলিত এই সকল সেবাকে জনবান্ধব করার জন্য
                                একটি ডিজিটাল প্লাটফর্ম অত্যাবশ্যকীয় হয়ে পড়ে। সে
                                লক্ষ্যে ইউনিয়ন পরিষদ থেকে প্রদত্ত সেবাসমূহকে
                                জনগণের কাছে স্বল্প খরচে, স্বল্প সময়ে এবং
                                হয়রানিমুক্তভাবে প্রদান নিশ্চিত করার জন্য একটি
                                এ্যাপ্লিকেশন থেকে সকল সেবা প্রদানের নিমিত্ত গত
                                ২০১৯-২০ অর্থ-বছরে সম্ভব্যতা যাচাইয়ের মাধ্যমে
                                www.uniontax.gov.bd নামক একটি অনলাইন সিস্টেম
                                কার্যক্রম চালু করা হয়। সম্ভব্যতা যাচাইয়ের জন্য
                                জিজ্ঞসাবাদের মাধ্যমকে সামনে রেখে প্রথমে একটি
                                ইউনিয়নের সকল ওয়ার্ডের কিছু সংখ্যক মানুষকে দৈব
                                চয়ন ভিত্তিতে চিহ্নিত করে ইউনিয়ন পরিষদ প্রদত্ত
                                সেবাসমূহকে ডিজিটালাইজ করার সম্ভবনা যাচাই করা হয়।
                                এই পদ্ধতিতে প্রাপ্ত তথ্যের আলোকে “ইউনিয়ন পরিষদ
                                ডিজিটাল সেবা” নামক অনলাইন সফটওয়্যারটি তৈরী করা
                                হয় এবং পরবর্তীতে ২০২০-২০২১ অর্থ বছরে ৩নং
                                তেঁতুলিয়া ইউনিয়ন পরিষদে পাইলটিং হিসেবে চালু করার
                                পর সকল ইউনিয়নে বাস্তবায়ন করা হলে আশাব্যঞ্জক সাড়া
                                পাওয়া যায় এবং গত ০৫/১০/২০২১ তারিখে রংপুর বিভাগের
                                মাননীয় বিভাগীয় কমিশনার জনাব মো: আব্দুল ওয়াহাব
                                ভূঞা মহোদয় www.uniontax.gov.bd অনলাইন সিস্টেমটির
                                শুভ উদ্বোধন করেন।
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <side-bar class-name="col-md-3"></side-bar>
        </div>


        <b-modal :id="actionModalhome.id" size="xl" title="ইউনিয়ন নির্বাচন করুন" ok-only>
                    <union-select :custom-url="actionModalhome.title" />
        </b-modal>



        <div class="popupcard" v-if="popupShow">
            <div class="popupcard-body">
                <div class="card-header" style="padding: 0 13px;text-align: right;">
                    <span style="cursor: pointer;color: red;font-weight: 600;font-size: 20px;padding: 0 8px;" @click="hidepop">&Chi;</span>
                </div>
                <img width="100%" :src="$asseturl+'notice.jpeg'" alt="">
            </div>
        </div>








    </div>
</template>
<script>
import {
    VueFlux,
    FluxCaption,
    FluxControls,
    FluxIndex,
    FluxPagination,
    FluxPreloader,
} from "vue-flux";
import FlipCard from "./layouts/FlipCard.vue";
export default {
    created() {
        // if (!User.loggedIn()) {
        //     this.$router.push({ name: "/login" });
        // }


        this.popupShow = false

    },
    components: {
        VueFlux,
        FluxCaption,
        FluxControls,
        FluxIndex,
        FluxPagination,
        FluxPreloader,
        FlipCard,
    },
    data() {
        return {
            selectedUser: '',
            flipped: false,
            popupShow: false,
            vfOptions: {
                autoplay: true,
            },
            vfImages: [
                this.$asseturl + "assets/img/padmabanner.jpeg",
                this.$asseturl + "assets/img/slider2.jpg",
                this.$asseturl + "assets/img/smart_bangladesh.jpeg",
                this.$asseturl + "assets/img/pm-smart-bangladesh-en.jpeg",
                this.$asseturl + "assets/img/digital-connectivity.jpeg",
                // this.$asseturl + "assets/img/61ed07bbaac6b597183901.jpg",
                // this.$asseturl + "assets/img/slide1.jpeg",
                // this.$asseturl + "assets/img/slide2.jpeg",
                // this.$asseturl+"assets/img/padmabanner.jpeg",
                // this.$asseturl+"assets/img/slide12.jpg",
                // this.$asseturl+"assets/img/slide11.jpg",
                // "/assets/img/slider2.png",
            ],
            vfTransitions: [
                "blinds2d",
                "blinds3d",
                "blocks1",
                "blocks2",
                "book",
                "camera",
                "concentric",
                "cube",
                "explode",
                "fade",
                "fall",
                "kenburn",
                "round1",
                "round2",
                "slide",
                "swipe",
                "warp",
                "waterfall",
                "wave",
                "zip",
            ],


            actionModalhome: {
                id: 'action-modal-home',
                title: '',
                status: '',
                content: {},
                content_id: '',
            },




            //   vfCaptions: [],
        };
    },
    mounted() {
    },
    methods: {

        hidepop(){
            this.popupShow = false
        },
        sendInfo(item, button) {


            this.actionModalhome.title = item;
            this.selectedUser = item;
            this.$root.$emit('bv::show::modal', this.actionModalhome.id, button)

            console.log(item)
        },
    },
};
</script>
<style lang="css" scoped>
.popupcard {
    position: fixed;
    z-index: 999999;
    top: 0;
    left: 0;
    width: 100%;
    height: 100vh;
    background: #000000c7;
}
.popupcard-body {
    width: 50%;
    margin: 30px auto;
    background: white;
        position: relative;
}
a.prev {
    display: none !important;
}

a.next {
    display: none !important;
}
</style>
