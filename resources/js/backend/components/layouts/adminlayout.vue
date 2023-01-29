<template>
    <div id="wrapper" class="wrapper bg-ash"
        :class="{ 'sidebar-collapsed': sidebarstatus, 'sidebar-collapsed-mobile': mobileSidebar }">
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40"
            objectbg="#999793" opacity="80" name="circular"></loader>


        <!-- Header Menu Area Start Here -->
        <div class="navbar navbar-expand-md header-menu-one bg-light" id='topnavbar'>
            <div class="nav-bar-header-one">
                <div class="header-logo">
                    <h3 style="    margin-bottom: 0;">
                        <router-link :to="{ name: 'Dashboard' }" class="text-white">

                                <span v-if="user.position=='District_admin'">জেলা এডমিন প্যানেল</span>
                                <span v-if="user.position=='Sub_District_admin'">উপপরিচালক প্যানেল</span>
                                <span v-else-if="user.position=='Chairman'">চেয়ারম্যান এডমিন প্যানেল</span>
                                <span v-else-if="user.position=='Secretary'">সচিব এডমিন প্যানেল</span>
                                <span v-else>উপজেলা এডমিন প্যানেল</span>

                            <!-- {{ user.position }} Panel -->
                            <!-- <img width="80%" src="http://esoft4u.tmscedu.com/asset/img/Logo123.png" alt="logo"> -->
                        </router-link>
                    </h3>
                </div>
                <div class="toggle-button sidebar-toggle">
                    <button type="button" class="item-link" @click="sidebarstatus = !sidebarstatus">
                        <span class="btn-icon-wrap">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="d-md-none mobile-nav-bar">
                <button class="navbar-toggler pulse-animation" type="button" data-toggle="collapse"
                    data-target="#mobile-navbar" aria-expanded="false">
                    <i class="far fa-arrow-alt-circle-down"></i>
                </button>
                <button type="button" class="navbar-toggler sidebar-toggle-mobile"
                    @click="mobileSidebar = !mobileSidebar">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            <div class="header-main-menu collapse navbar-collapse" id="mobile-navbar">
                <ul class="navbar-nav">
                    <li class="navbar-item header-search-bar">
                        <div class="input-group stylish-input-group">
                            <span class="input-group-addon">
                                <button type="submit">
                                    <!-- <span class="flaticon-search" aria-hidden="true"></span> -->
                                </button>
                            </span>
                            <!-- <input type="text" class="form-control" placeholder="Find Something . . ."> -->
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="navbar-item dropdown header-admin">
                        <a class="navbar-nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                            aria-expanded="false">
                            <div class="admin-title">
                                <h5 class="item-title">{{ user.names }}</h5>


                                <span v-if="user.position=='District_admin'">জেলা প্রশাসক</span>
                                <span v-if="user.position=='Sub_District_admin'">উপপরিচালক </span>
                                <span v-else-if="user.position=='Chairman'">চেয়ারম্যান</span>
                                <span v-else-if="user.position=='Secretary'">সচিব</span>
                                <span v-else>উপজেলা নির্বাহী অফিসার</span>



                                <!-- <span>{{ user.position }}</span> -->
                            </div>
                            <div class="admin-img">
                                <img :src="$asseturl + 'dashboard_asset/img/figure/admin.jpg'" alt="Admin">
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="item-header">
                                <h6 class="item-title">{{ user.names }}</h6>
                            </div>
                            <div class="item-content">
                                <ul class="settings-list">
                                    <li>
                                        <router-link class="dropdown-item" :to="{ name: 'profile' }">
                                            <img :src="$asseturl + 'dashboard_asset/img/figure/admin.jpg'" alt="Admin">
                                            Profile
                                        </router-link>
                                    </li>

                                    <li>
                                        <router-link class="dropdown-item" :to="{ name: 'logout' }">
                                            <i class="flaticon-turn-off"></i> Logout
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
            <!-- Sidebar Area Start Here -->
            <div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
                <div class="mobile-sidebar-header d-md-none">
                    <div class="header-logo">
                        <a href="/" style="    padding: 10px !important;">
                            {{ user.position }} Panel
                            <!-- <img width="80%" src="http://esoft4u.tmscedu.com/asset/img/Logo123.png" alt="logo"> -->

                        </a>
                    </div>
                </div>
                <div class="sidebar-menu-content" id="dashboardheight">
                    <ul class="nav nav-sidebar-menu sidebar-toggle-view navBar">





                        <!-- <li v-for="(menuList,index) in userPermission" class="nav-item" @click="submenu(index)" v-if="menuList.read">
                            <router-link :to="{name:menuList.name}" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>{{ menuList.resourceName }}</span></router-link>
                        </li> -->


                        <li class="nav-item" @click="submenu(0)">
                            <router-link :to="{ name: 'Dashboard' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>ড্যাশবোর্ড</span></router-link>
                        </li>



<!--
                        <li class="nav-item sidebar-nav-item" :class="{ active: selected == 101 }">
                            <a href="javascript:void(0)" class="nav-link" @click="submenu(101)"><i
                                    class="flaticon-technological"></i><span>Blogs</span>
                            </a>
                            <transition name="slide">
                                <ul class="nav sub-group-menu menu-open child" v-if="selected == 101"
                                    style="display:block">

                                    <li class="nav-item">
                                        <router-link :to="{ name: 'category' }" class="nav-link"><i
                                                class="fas fa-angle-right"></i> Category </router-link>
                                    </li>

                                    <li class="nav-item">
                                        <router-link :to="{ name: 'blogs' }" class="nav-link"><i
                                                class="fas fa-angle-right"></i> Blogs </router-link>
                                    </li>


                                </ul>
                            </transition>
                        </li>
 -->









                        <li class="nav-item" @click="submenu(0)">
                            <router-link :to="{ name: 'report' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>সকল প্রতিবেদন</span></router-link>
                        </li>


                        <!-- <li class="nav-item" @click="submenu(0)">
                            <router-link :to="{ name: 'onlinereport' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>অনলাইন প্রতিবেদন</span></router-link>
                        </li> -->





                        <li class="nav-item" @click="submenu(0)"
                            v-if="this.$localStorage.getItem('position') == 'Thana_admin' || this.$localStorage.getItem('position') == 'District_admin' || this.$localStorage.getItem('position') == 'Sub_District_admin'">
                            <router-link :to="{ name: 'sonodcountall' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>ইস্যুকৃত সনদ প্রতিবেদন</span></router-link>
                        </li>





                        <li class="nav-item" @click="submenu(0)"
                            v-if="Users.position == 'Chairman' || Users.position == 'Secretary'">
                            <router-link :to="{ name: 'unionprofile' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>ইউনিয়ন প্রোফাইল</span></router-link>
                        </li>





                        <li class="nav-item" @click="submenu(0)"
                            v-if="Users.position == 'Chairman' || Users.position == 'Secretary'">
                            <router-link :to="{ name: 'holdingTaxWord' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>হোল্ডিং ট্যাক্স
                                    </span></router-link>
                        </li>




                        <li class="nav-item" @click="submenu(0)" v-if="Users.position == 'Chairman' || Users.position == 'Secretary'">
                            <router-link :to="{ name: 'sonodFees' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>সনদ ফি</span></router-link>
                        </li>



                        <li class="nav-item" @click="submenu(0)" v-if="Users.position == 'super_admin'">
                            <router-link :to="{ name: 'charages' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>ফি</span></router-link>
                        </li>


                        <li class="nav-item" @click="submenu(0)"
                            v-if="Users.position == 'super_admin'">
                            <router-link :to="{ name: 'unionlist' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>ইউনিয়ন এর তালিকা</span></router-link>
                        </li>


                        <li class="nav-item" @click="submenu(0)"
                            v-if="Users.position == 'super_admin'">
                            <router-link :to="{ name: 'sonodlist' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>সেবার তালিকা</span></router-link>
                        </li>


                        <li class="nav-item" @click="submenu(0)" v-if="Users.position == 'super_admin'">
                            <router-link :to="{ name: 'userlist' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>ইউজার তালিকা</span></router-link>
                        </li>

<!--
                        <li class="nav-item" @click="submenu(0)"
                            v-if="Users.position == 'Chairman' || Users.position == 'Secretary'">
                            <router-link :to="{ name: 'citizenlist' }" class="nav-link"><i
                                    class="flaticon-dashboard"></i><span>Citizen List</span></router-link>
                        </li> -->





                        <li class="nav-item sidebar-nav-item" v-for="(sonod, index) in SonodNamesAdmin"
                            :class="{ active: selected == index + 1 }" :key="'add' + index">
                            <a href="javascript:void(0)" class="nav-link" @click="submenu(index + 1)"><i
                                    class="flaticon-technological"></i><span>{{ sonod.bnname }}</span>
                                <label
                                    v-if="(allSonodCount.Pending[sonod.enname.replaceAll(' ', '_')] + allSonodCount.approved[sonod.enname.replaceAll(' ', '_')]) > 0"
                                    style="

                                        background: rgb(223 12 12);
                                        padding: 0px 7px;
                                        color: wheat;
                                        font-size: 12px;
                                            border-radius: 5px;
                                    ">{{ allSonodCount.Pending[sonod.enname.replaceAll(' ', '_')] +
                                            allSonodCount.approved[sonod.enname.replaceAll(' ', '_')]
                                    }}</label></a>
                            <transition name="slide">
                                <ul class="nav sub-group-menu menu-open child" v-if="selected == index + 1"
                                    style="display:block">
                                    <li class="nav-item">
                                        <router-link
                                            :to="{ name: 'sonod', params: { name: sonod.enname.replaceAll(' ', '_'), type: 'new' } }"
                                            class="nav-link"><i class="fas fa-angle-right"></i> নতুন আবেদন <label
                                                v-if="allSonodCount.Pending[sonod.enname.replaceAll(' ', '_')] > 0"
                                                style="
                                        background: rgb(223 12 12);
                                        padding: 0px 7px;
                                        color: wheat;
                                        font-size: 12px;
                                            border-radius: 5px;
                                    ">{{ allSonodCount.Pending[sonod.enname.replaceAll(' ', '_')] }}</label>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link
                                            :to="{ name: 'sonod', params: { name: sonod.enname.replaceAll(' ', '_'), type: 'approved' } }"
                                            class="nav-link"><i class="fas fa-angle-right"></i> অনুমোদিত আবেদন <label
                                                v-if="allSonodCount.approved[sonod.enname.replaceAll(' ', '_')] > 0"
                                                style="
                                        background: rgb(223 12 12);
                                        padding: 0px 7px;
                                        color: wheat;
                                        font-size: 12px;
                                            border-radius: 5px;
                                    ">{{ allSonodCount.approved[sonod.enname.replaceAll(' ', '_')] }}</label>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link
                                            :to="{ name: 'sonod', params: { name: sonod.enname.replaceAll(' ', '_'), type: 'cancel' } }"
                                            class="nav-link"><i class="fas fa-angle-right"></i> বাতিল আবেদন
                                        </router-link>
                                    </li>
                                </ul>
                            </transition>
                        </li>


                        <li class="nav-item" @click="submenu(0)">
                            <router-link :to="{name:'cashbook'}" class="nav-link"><i class="flaticon-dashboard"></i><span>ক্যাশ বহি</span></router-link>
                        </li>


                    </ul>
                </div>
            </div>
            <!-- Sidebar Area End Here -->
            <div class="dashboard-content-one">
                <slot></slot>
                <!-- Footer Area Start Here -->
                <!-- <footer class="footer-wrap-layout1">
                    <div class="copyright">© Copyrights <a href="#">Company name</a> 2019. All rights reserved.
                        Developed by <a target="_blank"
                            href="https://api.whatsapp.com/send?phone=8801909756552&text=I%27m%20interested%20in%20your%20services">Freelancer
                            Nishad</a></div>
                </footer> -->
                <!-- Footer Area End Here -->
            </div>
        </div>
        <!-- Page Area End Here -->
    </div>
</template>
<script>
export default {
    props: ['user', 'permission', 'roles','Sonodnamelists'],
    async created() {
        // this.getSonodNamesAdmin();


        this.SonodNamesAdmin = this.Sonodnamelists;

        // var url = this.$appUrl.split("//");
        // var subdomain = url[1].split(".");
        var subdomain = [];

        this.$store.commit('setWebsiteStatus', 'main')

        if (!User.loggedIn()) {
            window.location.href = '/login'
        }


        // if (this.$route.params.name) {
        //     var result = await this.callApi('get', `/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_', ' ')}`, []);
        //     this.$store.commit('setUpdateSonodName', result.data)
        // }




        this.$store.commit('setUpdateSonodNames', this.SonodNamesAdmin)
        this.$store.commit('setUpdateUser', this.user)
        // this.$store.commit('setUserPermission', JSON.parse(this.permission.permission))
        // this.$store.commit('setUserRoles', this.roles)



        //  this.$store.dispatch("getUser",this.user);


        if (localStorage.getItem('selectedMenu')) {
            this.selected = localStorage.getItem('selectedMenu')
        }
        window.addEventListener("resize", this.myEventHandler);
        window.addEventListener("scroll", this.myscroll);

    },
    watch: {
        '$route': async function (to, from) {


        }
    },
    destroyed() {
        window.removeEventListener("resize", this.myEventHandler);
        window.removeEventListener("scroll", this.myscroll);
    },
    data() {
        return {
            selected: 0,
            preLooding: false,
            sidebarstatus: false,
            mobileSidebar: false,
            SonodNamesAdmin:{},
            allSonodCount: {
                Pending: {},
                Secretary_approved: {},
                approved: {},
            },
        }
    },
    watch: {
        '$route': {
            handler(newValue, oldValue) {
                this.sidebarstatus = false
                this.mobileSidebar = false


            },
            deep: true



        }
    },
    methods: {

    async getSonodNamesAdmin(){
        this.preLooding = true


        var res = await this.callApi('get', '/api/get/sonodname/list?admin=1', []);


        this.SonodNamesAdmin = res.data
        this.preLooding = false

        },
    async sonodlistCount() {
            var unionname = localStorage.getItem('unioun');
            var useridsent ='';
            if (this.$localStorage.getItem('position') == 'District_admin') {

                var unionname = '';
            }else if(this.$localStorage.getItem('position') == 'Thana_admin'){
                var userid = localStorage.getItem('userid');
                    var useridsent = `&userid=${userid}`;
                var unionname = '';
            }

            var allSonodc = await this.callApi('get', `/api/get/sonod/count?union=${unionname}&postion=${localStorage.getItem('position')}${useridsent}`, []);
            this.allSonodCount = allSonodc.data
            // console.log(allSonodc)
        },

        myscroll() {



            // Get the header
            var header = document.getElementById("topnavbar");

            var sticky = header.offsetTop;


            if (window.pageYOffset > sticky) {
                header.classList.add("fixednav");
            } else {
                header.classList.remove("fixednav");
            }



        },

        myEventHandler() {
            // if (window.innerWidth > 768) {
            //     this.sidebarstatus = false
            // } else {
            //     this.mobileSidebar = false
            // }


            // // var index = 1
            // // if(localStorage.getItem('role')=='admin' || localStorage.getItem('role')=='teacher'){
            // //     index= 0
            // // }
            //     var clientHeight = document.getElementsByClassName('navBar')[0].clientHeight;

            // var menuheight = 0
            // if(clientHeight<window.innerHeight){
            //     menuheight= window.innerHeight
            // }else{
            //     menuheight= '100%'
            // }
            // document.getElementById('wrapper').style.height = menuheight +'px';
            // document.getElementById('dashboardheight').style.height = menuheight +'px';










        },
        submenu(ref) {

            if (this.selected > 0) {
                if (ref == this.selected) {
                    this.selected = 0
                    localStorage.setItem('selectedMenu', 0)
                } else {
                    this.selected = ref
                    localStorage.setItem('selectedMenu', ref)
                }
            } else {
                this.selected = ref
                localStorage.setItem('selectedMenu', ref)
            }
        }
    },
    mounted() {
        // this.myEventHandler();

        this.sonodlistCount()
        setInterval(() => {
            this.sonodlistCount()
        }, 300000);
    }
}
</script>
<style>
ul.nav.sub-group-menu.menu-open.child {
    padding: 0 !important;
}

ul.nav.sub-group-menu.menu-open.child li {
    padding: 10px 0;
}

.slide-enter-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: ease-in;
    -webkit-transition-timing-function: ease-in;
    -o-transition-timing-function: ease-in;
    transition-timing-function: ease-in;
}

.slide-leave-active {
    -moz-transition-duration: 0.3s;
    -webkit-transition-duration: 0.3s;
    -o-transition-duration: 0.3s;
    transition-duration: 0.3s;
    -moz-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -webkit-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    -o-transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
}

.slide-enter-to,
.slide-leave {
    max-height: 100px;
    overflow: hidden;
}

.slide-enter,
.slide-leave-to {
    overflow: hidden;
    max-height: 0;
}

a.nav-link span {
    font-size: 14px !important;
}
textarea.form-control {
    background: #b9b9b9 !important;
}
</style>
