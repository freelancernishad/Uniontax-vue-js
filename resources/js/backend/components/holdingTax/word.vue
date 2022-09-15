<template>
    <div>

        <div class="breadcrumbs-area">
            <h3>হোল্ডিং ট্যাক্স</h3>
            <ul>
                <li>
                    <router-link :to="{name:'Dashboard'}">ড্যাশবোর্ড</router-link>
                </li>
                <li>হোল্ডিং ট্যাক্স</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">


                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="card-title">হোল্ডিং ট্যাক্স</h5>

                                </div>
                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:1}}" class="btn btn-info btn-lg">১নং
                                        ওয়ার্ড</router-link>
                                </div>

                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:2}}" class="btn btn-info btn-lg">২নং
                                        ওয়ার্ড</router-link>
                                </div>

                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:3}}" class="btn btn-info btn-lg">৩নং
                                        ওয়ার্ড</router-link>
                                </div>

                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:4}}" class="btn btn-info btn-lg">৪নং
                                        ওয়ার্ড</router-link>
                                </div>

                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:5}}" class="btn btn-info btn-lg">৫নং
                                        ওয়ার্ড</router-link>
                                </div>

                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:6}}" class="btn btn-info btn-lg">৬নং
                                        ওয়ার্ড</router-link>
                                </div>


                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:7}}" class="btn btn-info btn-lg">৭নং
                                        ওয়ার্ড</router-link>
                                </div>


                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:8}}" class="btn btn-info btn-lg">৮নং
                                        ওয়ার্ড</router-link>
                                </div>


                                <div class="col-md-2 col-sm-3 col-4">
                                    <router-link :to="{name:'holdingTaxList',params:{word:9}}" class="btn btn-info btn-lg">৯নং
                                        ওয়ার্ড</router-link>
                                </div>












                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
            </div>
</template>

<style scoped>
    a.btn.btn-info.btn-lg {
        font-size: 26px;
        margin: 4px;
    }

    </style>
