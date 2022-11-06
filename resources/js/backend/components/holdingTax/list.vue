<template>
    <div>

        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>

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
                    <div class="card-header">

                        <div class=" d-flex justify-content-between align-items-center">

                            <h3>হোল্ডিং ট্যাক্স</h3>
                            <router-link :to="{name:'holdingTaxadd',params:{wordNo:$route.params.word}}" class="btn btn-info">হোল্ডিং ট্যাক্স যোগ করুন</router-link>

                        </div>


                        <form  @submit.prevent="formSubmit">


<div class="form-group">
    <label for=""></label>
    <div class="d-flex">
        <input type="text" v-model="form.userdata" id="userdata" class="form-control"
            placeholder="এখানে আপনার হোল্ডিং নং/নাম/জাতীয় পরিচয় পত্র নম্বর/মোবাইল নম্বর (যে কোন একটি তথ্য) এন্ট্রি করুন"
            >


    </div>
</div>

<div class="form-group text-center">
    <button type="button" style="    font-size: 20px;padding: 5px 23px;" disabled class="btn btn-info text-center" v-if="isSending">Wait...</button>
    <button type="submit" style="    font-size: 20px;padding: 5px 23px;" class="btn btn-info text-center" v-else>খুঁজুন</button>

</div>

</form>


                    </div>
                    <div class="card-body">
                       <table class="table">
                            <thead>
                                <tr>
                                        <th>হোল্ডিং নাম্বার</th>
                                        <th>নাম</th>
                                        <th>এন আইডি নাম্বার</th>
                                        <th>মোবাইল নাম্বার</th>

                                        <th>আরও তথ্য</th>

                                    </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(row,index) in rows">
                                    <td>{{ row.holding_no }}</td>
                                    <td>{{ row.maliker_name }}</td>
                                    <td>{{ row.nid_no }}</td>
                                    <td>{{ row.mobile_no }}</td>
                                    <td>
                                        <span size="sm" v-if="buttonLoader" class="btn btn-info mr-1 mt-1"><img width="20px" src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif" alt=""></span>

                                        <router-link :to="{name:'holdingTaxView',params:{id:row.id}}" class="btn btn-success" v-else >দেখুন</router-link>





                                        <!-- <a class="btn btn-success" href="">Edit</a> -->

                <!-- <a class="btn btn-danger" href="">Delete</a> -->


                                    </td>
                                </tr>
                            </tbody>
                       </table>
                    </div>
                </div>

            </div>
            </div>



            </div>
</template>

    <script>
    export default {
        data(){
            return {
                preLooding:true,
                rows:{},
                buttonLoader:false,
                infoModal: {
                    id: 'info-modal',
                    title: '',
                    content: {

                    },
                    bokeya:{},
                    content_id: '',
                },
                form:{
                userdata:'',
            },
            isSending: false
            }
        },
        methods: {
            async list(){


                var res = await this.callApi('get',`/api/holding/tax/list?word=${this.$route.params.word}&union=${localStorage.getItem('unioun')}`,[]);
                this.rows = res.data;
                this.preLooding = false
            },



            async info(item, index, button) {
            this.buttonLoader = true;
            this.infoModal.title = `${item.applicant_name}`

                var res = await this.callApi('get',`/api/holding/bokeya/list?holdingTax_id=${item.id}`,[])

            this.infoModal.bokeya = res.data
            this.infoModal.content = item

            this.buttonLoader = false;
            this.$root.$emit('bv::show::modal', this.infoModal.id, button)
        },

        async formSubmit(){
            this.isSending = true
            var res = await this.callApi('post',`/api/holding/tax/search?union=${localStorage.getItem('unioun')}`,this.form);
            this.rows = res.data;
            this.isSending = false
        }




        },
        mounted() {
            // setTimeout(() => {
                this.list();

            // }, 3000);
        },
    }
    </script>

<style scoped>
    a.btn.btn-info.btn-lg {
        font-size: 26px;
        margin: 4px;
    }

    </style>
