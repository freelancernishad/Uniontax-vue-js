<template>
    <div>
        <!-- Sidebar Area End Here -->
        <div class="dashboard-content-one">
            <!-- Breadcubs Area Start Here -->
            <div class="breadcrumbs-area">
                <h3>{{ Users.position }} Dashboard</h3>
                <ul>
                    <li>
                        <router-link :to="{ name: 'Dashboard' }">Home</router-link>
                    </li>
                    <li>{{ Users.position }} </li>
                </ul>
            </div>
            <!-- Breadcubs Area End Here -->
            <!-- Dashboard summery Start Here -->
            <div class="row gutters-20">



                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="dashboard-summery-one mg-b-20">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="item-icon bg-light-green ">
                                    <i class="flaticon-classmates text-green"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">মোট আবেদন</div>
                                    <div class="item-number"><span class="counter" :data-num="sonodCount.allSonodCount">{{ sonodCount.allSonodCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="dashboard-summery-one mg-b-20">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="item-icon bg-light-blue">
                                    <i class="flaticon-multiple-users-silhouette text-blue"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">নতুন আবেদন</div>
                                    <div class="item-number"><span class="counter" :data-num="sonodCount.pendingSonodCount">{{ sonodCount.pendingSonodCount }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="dashboard-summery-one mg-b-20">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="item-icon bg-light-yellow">
                                    <i class="flaticon-couple text-orange"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">ইস্যুকৃত সনদ</div>
                                    <div class="item-number"><span class="counter" :data-num="sonodCount.approvedSonodCount">{{ sonodCount.approvedSonodCount }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="dashboard-summery-one mg-b-20">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <div class="item-icon bg-light-red">
                                    <i class="flaticon-money text-red"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="item-content">
                                    <div class="item-title">বাতিল আবেদন</div>
                                    <div class="item-number"><span class="counter"
                                            :data-num="sonodCount.cancelSonodCount">{{ sonodCount.cancelSonodCount }}</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Dashboard summery End Here -->

        </div>
    </div>
</template>
<script>
// import { mapState,mapActions } from 'vuex';
export default {
    computed: {
        // users(){
        //    return this.$store.state.Users
        // }
    },
    async created() {
        //   const res = await this.callApi('POST', '/api/user', {});
        // if (!User.loggedIn()) {
        //     this.$router.push({ name: "/login" });
        // }
    },
    data() {
        return {
            sonodCount:{

            allSonodCount:0,
            pendingSonodCount:0,
            approvedSonodCount:0,
            cancelSonodCount:0,

            }
        };
    },
    mounted() {

        setInterval(() => {
                this.sonodCountDashbord('all','allSonodCount')
                this.sonodCountDashbord('Pending','pendingSonodCount')
                this.sonodCountDashbord('approved','approvedSonodCount')
                this.sonodCountDashbord('cancel','cancelSonodCount')
        },5000)


    },
    methods: {

       async sonodCountDashbord(status = '',data=''){
        var res = await this.callApi('get',`/api/count/sonod/${status}`,[]);
            this.sonodCount[data] = res.data;
        }

    },
};
</script>
<style lang="css" scoped>
</style>
