<template>
    <div>
        <div class="container p-0">
            <header>
                <div class="topHeader">
                    <div class="row">
                        <div class="topheaderItem col-md-6 col-6"><span>ইউনিয়ন পরিষদ ক্যাশলেস সেবা সিস্টেমে স্বাগতম</span></div>
                        <div class="topheaderItem col-md-6 col-6 text-right"><span
                                style="border-right: 1px solid #ffffff85; padding: 8px 10px;margin-right: 9px;">{{
                                        curentdate
                                }}
                            </span>
                            <!-- <span style="border-right: 1px solid #ffffff85; padding: 8px 10px;margin-right: 9px;">{{ curenttime }}</span> -->
                            <span style="">Visitors : {{ visitors }}</span>
                        </div>
                    </div>
                </div>
                <div class="middleHeader ">
                    <div class="row">
                        <div class="middleHeaderItem col-md-6 mt-3 mb-3">
                            <router-link :to="{ name: 'home' }">
                                <img width="50%" v-if="getType == 'main'"
                                    :src="$asseturl + 'assets/img/mail_logo-01.png'" alt="">
                                <img width="50%" v-else-if="getType == 'Union'" :src="$asseturl+getunionInfos.web_logo" alt="">
                            </router-link>
                        </div>
                        <div class="middleHeaderItem col-md-6 mb-3">
                            <h3 class="searchHeader defaltColor">ইউনিয়ন নির্বাচন করুন </h3>
                            <union-select />
                        </div>
                    </div>
                </div>
                <nav class="">
                    <div class="row">
                        <div class="col-md-12 pcnav" id="mainMenu">
                            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                                <!-- <a class="navbar-brand" href="#">Navbar</a> -->
                                <button class="navbar-toggler  text-white" style="color:white !important" type="button"
                                    data-toggle="collapse" data-target="#navbarSupportedContent"
                                    aria-controls="navbarSupportedContent" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                    <!-- <span class="navbar-toggler-icon"></span> -->
                                    <i class="fas fa-bars"></i>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <ul class="navbar-nav mr-auto">
                                        <li class="nav-item active">
                                            <router-link class="nav-link" :to="{ name: 'home' }">হোম</router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'upProfile' }">ইউপি সেবা পরিচিতি
                                            </router-link>
                                        </li>

<!--

                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">বার্তা</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <router-link class="dropdown-item" to="/hello">জেলা প্রশাসকের বার্তা
                                                </router-link>
                                                <router-link class="dropdown-item" to="/hello2">উপজেলা নির্বাহী অফিসারের
                                                    বার্তা</router-link>
                                            </div>
                                        </li> -->



                                        <li class="nav-item dropdown" v-if="getType == 'main'">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">নাগরিক সেবা</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <div class="dropdown-item"
                                                    v-for="(sonod, r) in SonodNames" :key="'mainMenu' + r"
                                                    @click="sendInfo('/application/' + sonod.enname.replaceAll(' ', '_'),$event.target)"
                                                    role="button">{{ sonod.bnname }}</div>
                                            </div>
                                        </li>



                                        <li class="nav-item dropdown" v-if="getType=='Union'">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">নাগরিক সেবা</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                                <router-link class="dropdown-item" v-for="(sonod, rk) in SonodNames"
                                                    :key="'unionMenu' + rk"
                                                    :to="{ name: 'application', params: { name: sonod.enname.replaceAll(' ', '_') } }">
                                                    {{ sonod.bnname }}</router-link>
                                            </div>
                                        </li>




                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">অন্যান্য</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <a class="dropdown-item" target="_blank"
                                                    href="https://bdris.gov.bd/br/application">জন্ম নিবন্ধন সনদের
                                                    আবেদন</a>
                                                <a class="dropdown-item" target="_blank"
                                                    href="https://bdris.gov.bd/dr/application">মৃত্যু নিবন্ধন সনদের
                                                    আবেদন</a>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'sonodsearch' }">সনদ
                                                যাচাই
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'notice' }">নোটিশ</router-link>
                                        </li>

                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'tenders' }">ইজারা</router-link>
                                        </li>

                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'contact' }">যোগাযোগ
                                            </router-link>
                                        </li>
                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'holdingTax' }">হোল্ডিং ট্যাক্স
                                            </router-link>
                                        </li>

<!--
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                                role="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">খবর</a>
                                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                <router-link class="dropdown-item" v-for="(cat, indexs) in categorys"
                                                    :to="{ name: 'blogs', params: { name: cat.slug } }" :key="'cat' + indexs">
                                                    {{ cat.name }}
                                                </router-link>
                                            </div>
                                        </li> -->



                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'citizens_corner' }">নাগরিক কর্নার</router-link>
                                        </li>

                                        <li class="nav-item">
                                            <router-link class="nav-link" :to="{ name: 'login' }">লগইন</router-link>
                                        </li>
                                    </ul>
                                    <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
                                </div>
                            </nav>
                        </div>
                    </div>
                </nav>
            </header>
            <div class="middeleContent">
                <marquee direction="left" onmouseover="this.stop();" onmouseout="this.start();" scrolldelay="100" style="background: var(--defaultColor);
color: white;
font-size: 18px;
padding: 3px 11px;"> ইউনিয়ন পরিষদের ডিজিটাল অনলাইন সেবা সিস্টেম uniontax.gov.bd –তে আপনাকে স্বাগতম। </marquee>
                <slot></slot>
                <div class="row">
                    <div class="col-md-12 mt-3 mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="imbox">
                                    <div class="sidebarTitle mb-3 defaltColor">
                                        <h4 class='text-center'>গুরুত্বপূর্ণ লিংক</h4>
                                    </div>
                                    <ul class='list-unstyled importantLInk' style="padding: 0 11px;">
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a
                                                href="http://www.bangabhaban.gov.bd/"
                                                title="রাষ্ট্রপতির কার্যালয়">রাষ্ট্রপতির কার্যালয়</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="http://www.pmo.gov.bd"
                                                title="প্রধানমন্ত্রীর কার্যালয়">প্রধানমন্ত্রীর কার্যালয়</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a
                                                href="http://www.parliament.gov.bd/" title=" জাতীয় সংসদ">জাতীয় সংসদ</a>
                                        </li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="http://mopa.gov.bd"
                                                title="জনপ্রশাসন মন্ত্রণালয়">জনপ্রশাসন মন্ত্রণালয়</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a
                                                href="http://www.bangladesh.gov.bd" title="জাতীয় তথ্য বাতায়ন">জাতীয় তথ্য
                                                বাতায়ন</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a
                                                href="http://www.panchagarh.gov.bd/" title="পঞ্চগড় জেলা">পঞ্চগড় জেলা</a>
                                        </li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a
                                                href="http://tetulia.panchagarh.gov.bd/"
                                                title="তেঁতুলিয়া উপজেলা">তেঁতুলিয়া উপজেলা</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="imbox">
                                    <div class="sidebarTitle mb-3 defaltColor">
                                        <h4 class='text-center'>অন্যান্য</h4>
                                    </div>
                                    <ul class='list-unstyled importantLInk' style="padding: 0 11px;">
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="http://forms.mygov.bd/"
                                                title="বাংলাদেশ ফরম">বাংলাদেশ ফরম</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="http://www.ebook.gov.bd/"
                                                title="ই-বুক">ই-বুক</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="https://www.mygov.bd/"
                                                title="সকল ই-সেবা">সকল ই-সেবা</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="http://mopa.gov.bd"
                                                title="পাসপোর্টের আবেদন">পাসপোর্টের আবেদন</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="http://echallan.gov.bd/"
                                                title="ই-চালান প্রশিক্ষণ">ই-চালান</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="https://ldtax.gov.bd/"
                                                title="ভূমি সেবা">ভূমি সেবা</a></li>
                                        <li><i class="fas fa-check-circle"></i> &nbsp;<a href="https://a2i.gov.bd/"
                                                title="এটুআই">এটুআই</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="imbox">
                                    <div class="sidebarTitle mb-3 defaltColor">
                                        <h4 class='text-center'>ইজারা নোটিশ বোর্ড</h4>
                                    </div>
                                    <ul class='list-unstyled importantLInk' style="padding: 0 11px;">



                                        <li v-for="(tender,indexs) in tenders" :key="'tender'+indexs"><i class="fas fa-check-circle"></i> &nbsp;<router-link :to="{name:'tenderView',params:{id:tender.id}}">{{ tender.tender_name }}</router-link></li>



                                    </ul>
                                </div>
                            </div>


                            <!-- <div class="col-md-4">
                                <div class="imbox">
                                    <div class="column block" style="padding: 0 0px;">
                                        <iframe width="100%" height="240"
                                            src="https://www.youtube.com/embed/QNUSIOMb6vI" title="YouTube video player"
                                            frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
            <footer>
                <div class="footer_top_bg"
                    style="background: url('/public/assets/img/footer_top_bg.png'); height: 93px; background-repeat: no-repeat; background-size: cover;">
                </div>





                <div class="footerBottom">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="footerList">
                                <li style="font-size:font-size:15px"> <b> পরিকল্পনা ও বাস্তবায়নে:</b> <br />
                                    সোহাগ চন্দ্র সাহা
                                    <br />উপজেলা নির্বাহী অফিসার,তেঁতুলিয়া,পঞ্চগড়
                                </li>

                            </ul>
                        </div>


                        <div class="col-md-4">
                            <ul class="footerList">
                                <li style="font-size:font-size:15px"> </li>
                                <li
                                    style="font-size:font-size:15px;    display: flex;justify-content: center;align-items: center;">
                                    <img style="width:40px !important" :src="$asseturl + 'assets/img/bd-logo.png'"alt="">
                                    <span style="padding: 0 15px;"> <b> ব্যবস্থাপনা ও তত্ত্বাবধানে:</b> <br>  জেলা প্রশাসন, পঞ্চগড়।</span>
                                </li>
                            </ul>
                        </div>



                        <div class="col-md-4">
                            <ul class="footerList">
                                <li style="font-size:font-size:15px"> </li>
                                <li
                                    style="font-size:font-size:15px;    display: flex;justify-content: center;align-items: center;">
                                    <img style="width:40px !important" :src="$asseturl + 'Soft-Web-Sys.png'"alt="">
                                    <span  style="padding: 0 15px;"> <b> কারিগরি সহায়তায়:</b> <br>
                                        <a target="_blank" href="https://softwebsys.com/"> সফটওয়েব সিস্টেম সল্যুশন</a></span>
                                </li>
                            </ul>
                        </div>
                        </div>
                </div>

                <div class="footerpayment">

                </div>

                <div class="footerpayment row ">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <img :src="$asseturl+'assets/img/ekpay.png'" width="100%" alt="">

                    </div>
                    <div class="col-md-2"></div>

                </div>



            </footer>
        </div>
        <div class="modal fade  bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">ইউনিয়ন নির্বাচন করুন</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class='d-flex'>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <b-modal :id="actionModal.id" size="xl" title="ইউনিয়ন নির্বাচন করুন" ok-only>
                    <union-select :custom-url="actionModal.title" />
        </b-modal>


    </div>
</template>
<script>
export default {
    props: ['user','unioundetialsprops','sonodnamesprops','alldivisionprops','tradelicenseprops'],
    async created() {
        // var res = await this.callApi('get', '/api/get/sonodname/list', []);
        // this.$store.commit('setUpdateSonodNames', res.data)
        this.$store.commit('setUpdateDivision', this.alldivisionprops)
        this.$store.commit('setUpdateSonodNames', this.sonodnamesprops)
        this.$store.commit('setUpdateTrandeLicenseKhat', this.tradelicenseprops)


        var url = this.$appUrl.split("//");

        var subdomain = url[1].split(".");







        var sub=false;
        var subdomainget='';
        if(subdomain[0]=='www'){
                subdomainget = subdomain[1];


       var subdomainCount =  subdomain.length;
    //    console.log(subdomainCount);
        if(subdomainCount>this.$withWWW){
            sub = true;
        }else{
            sub = false;

        }


            }else{

      var subdomainCount =  subdomain.length;
        if(subdomainCount>this.$withOutWWW){
            sub = true;
        }else{
            sub = false;

        }

                subdomainget = subdomain[0];

            }

// console.log(sub,subdomainget)
            localStorage.setItem('unioun',subdomainget)

        if (sub) {

        // this.$store.commit('setWebsiteStatus', subdomainget)
        this.subdomaingetOwn = subdomainget
           var  unionData = {'subdomainget':subdomainget,'uniounDetialsprops':this.unioundetialsprops};
        this.$store.commit('setWebsiteStatus', unionData)

            // var unioninfo = await this.callApi('post', `/api/union/info?union=${subdomainget}`, []);
            // console.log(unioninfo)
            this.ff['district'] = this.unioundetialsprops.district
            this.ff['thana'] = this.unioundetialsprops.thana
            // var charge = await this.callApi('post', `/api/vattax/get`, this.ff);
            // this.$store.commit('setvatTax', charge.data)
            this.$store.commit('setvatTax', 0)
        }else{
        // this.$store.commit('setWebsiteStatus', 'main')
        this.subdomaingetOwn = 'main'
        var  unionData = {'subdomainget':'main','uniounDetialsprops':this.unioundetialsprops};
        this.$store.commit('setWebsiteStatus', unionData)

        }
    },
    data() {
        return {
            subdomaingetOwn:'main',
            selectedUser: '',
            curentdate: '',
            curenttime: '',
            visitors: '',
            categorys: {},
            ff: {},
            actionModal: {
                id: 'action-modal',
                title: '',
                status: '',
                content: {},
                content_id: '',
            },
            tenders:{},
        }
    },
    watch: {
        '$route': {
            handler(newValue, oldValue) {
                document.getElementById('navbarSupportedContent').classList.remove("show");
                window.scrollTo(0, 0);
            },
            deep: true
        }
    },
    methods: {
        async getTender(){
            console.log(this.subdomaingetOwn)

            if (this.getType == 'Union') {
              var  unionname = this.getUnion.subdomainget;
                var res = await this.callApi('get',`/api/get/all/tender/list?union_name=${unionname}`,[]);
            }else{
                var res = await this.callApi('get',`/api/get/all/tender/list`,[]);
            }



        this.tenders = res.data;
        },


        sendInfo(item,button) {


            this.actionModal.title = item;
            this.selectedUser = item;
            this.$root.$emit('bv::show::modal', this.actionModal.id, button)

            // console.log(item)
            },
        async visitorfun() {
            var unionname = 'uniontax';
            if (this.getType == 'Union') {
                unionname = this.getUnion.subdomainget;
            }
            var visitcreate = await this.callApi('post', `/api/visitorcreate`, [])
            var res = await this.callApi('get', `/api/visitorcount?union=${unionname}`, [])
            this.visitors = res.data;
        },
        getCategory() {
            axios.get(`/api/get/category/list`)
                .then((res) => {
                    this.categorys = res.data
                })
        }
    },
    mounted() {
        // this.getCategory();
        setTimeout(() => {
            this.visitorfun();
            this.getTender();
        }, 2000);
        var date = new Date();
        this.curentdate = User.dateformat(new Date())[0]
        setInterval(() => {
            this.curenttime = User.dateformat(new Date())[8]
        }, 1000);
    }
}
</script>
<style>

ul.footerList li a:hover {
    background: #fff !important;
    color: #0e56a1 !important;
    text-decoration: none !important;
    border-radius: 0 !important;
}
ul.footerList li a {
    display: block;
    padding: 6px 0;
    font-size: 13px;
    color: #0e0e0e;
    border-right: 0px dotted #5a5454;
}


nav.navbar.navbar-expand-lg.navbar-light.bg-light {
    background: #023076 !important;
}
li.nav-item a, .dropdown-item {
    color: white !important;
}
.dropdown-menu {
    background: #9e5bba;
}
.dropdown-item.active,
.dropdown-item:active {
    background-color: #159513ed;
}
.dropdown-item:focus,
.dropdown-item:hover {
    background-color: #159513ed;
}
nav.navbar.navbar-expand-lg.navbar-light.bg-light {
    padding: 0 6px;
}
@media (min-width:992px) {
    li.nav-item {
        border-right: 1px solid white;
    }
    .dropdown-item {
        border-bottom: 1px solid #89209b;
    }
    .dropdown-item:first-child {
        border-top: 1px solid #89209b;
    }
}
/* .dropdown:hover>.dropdown-menu{
		display: block;
	} */
/* .serviceBox {
    border-top-right-radius: 30px;
    border-bottom-left-radius: 30px;
} */
.defaltColor {
    background: var(--defaultColor) !important;
}
.defaltTextColor {
    color: var(--defaultColor) !important;
}
</style>
