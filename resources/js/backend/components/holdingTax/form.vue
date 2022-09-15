<template>
    <div>

        <div class="breadcrumbs-area">
            <h3>হোল্ডিং ট্যাক্স</h3>
            <ul>
                <li>
                    <router-link :to="{name:'Dashboard'}">Holding Form</router-link>
                </li>
                <li>Profile</li>
            </ul>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body">
                        <form   @submit.stop.prevent="finalSubmit"
                            class="form-horizontal">
                            <div class="card-body">
                                <h4 class="card-title">হোল্ডিং ট্যাক্স</h4>
                                <div class="row">
                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">হোল্ডিং নং</label>
                                            <input type="text" class="form-control" id="holding_no" v-model="form.holding_no"
                                                 required/>
                                        </div>
                                    </div>
                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">মালিকের নাম</label>
                                            <input type="text" class="form-control" id="maliker_name" v-model="form.maliker_name"
                                                required/>
                                        </div>
                                    </div>
                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">পিতা/স্বামীর নাম</label>
                                            <input type="text" class="form-control" id="father_or_samir_name"
                                            v-model="form.father_or_samir_name" required/>
                                        </div>
                                    </div>
                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">গ্রামের নাম</label>
                                            <input type="text" class="form-control" id="gramer_name" v-model="form.gramer_name"
                                                 required/>
                                        </div>
                                    </div>



                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">ওয়াড নং</label>


                                            <select v-model="form.word_no" id="word_no" class="form-control" required>
                                                <option value="">ওয়াড নং</option>
                                                <option value="1">১</option>
                                                <option value="2">২</option>
                                                <option value="3">৩</option>
                                                <option value="4">৪</option>
                                                <option value="5">৫</option>
                                                <option value="6">৬</option>
                                                <option value="7">৭</option>
                                                <option value="8">৮</option>
                                                <option value="9">৯</option>

                                            </select>


                                        </div>
                                    </div>


                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">এনআইডি নং</label>
                                            <input type="text" class="form-control" id="nid_no" v-model="form.nid_no"
                                                 required/>
                                        </div>
                                    </div>
                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">মোবাইল নং</label>
                                            <input type="text" class="form-control" id="mobile_no" v-model="form.mobile_no"
                                                 />
                                        </div>
                                    </div>




                                    <!-- col-md-4 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">হোল্ডিং ট্যাক্স এর ধরণ</label>
                                            <select v-model="form.category" id="category" class="form-control">
                                                <option value="">হোল্ডিং ট্যাক্স এর ধরণ</option>
                                                <option>মালিক নিজে বসবাসকারী</option>
                                                <option>ভাড়া</option>
                                                <option>আংশিক ভাড়া</option>
                                                <option value="প্রতিষ্ঠান">প্রতিষ্ঠান (সরকারি/আধা সরকারি/বেসরকারি/বাণিজ্যিক)</option>

                                         </select>
                                        </div>
                                    </div>






                                    <!-- col-md-4 -->
                                    <div class="col-md-4" id="griher_barsikh_mullo_d" v-if="form.category=='মালিক নিজে বসবাসকারী' || form.category=='আংশিক ভাড়া' || form.category=='প্রতিষ্ঠান'">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">গৃহের বার্ষিক মূল্য</label>
                                            <input type="text" class="form-control" id="griher_barsikh_mullo"
                                            v-model="form.griher_barsikh_mullo"  />
                                        </div>
                                    </div>



                                    <!-- col-md-4 -->
                                    <div class="col-md-4" id="jomir_vara_d" v-if="form.category=='মালিক নিজে বসবাসকারী' || form.category=='আংশিক ভাড়া' || form.category=='প্রতিষ্ঠান'">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">জমির ভাড়া</label>
                                            <input type="text" class="form-control" id="jomir_vara" v-model="form.jomir_vara"
                                                 />
                                        </div>
                                    </div>



                                    <!-- col-md-4 -->
                                    <div class="col-md-4" id="barsikh_vara_d" v-if="form.category=='ভাড়া' || form.category=='আংশিক ভাড়া'">
                                        <div class="form-group">
                                            <label class="control-label col-form-label">বার্ষিক ভাড়া</label>
                                            <input type="text" class="form-control" id="barsikh_vara" v-model="form.barsikh_vara"
                                                />
                                        </div>
                                    </div>








                                    <div class="col-md-12 mt-5">
                                        <h3>বকেয়ার পরিমাণ</h3>
                                        <hr />
                                    </div>

                                    <div class="col-md-12">
                                        <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="30%">সাল</th>
                        <th  width="40%">টাকার পরিমান</th>
                        <th  width="30%"><button type="button" class="btn btn-info" @click="addMore()">Add More</button></th>
                    </tr>
                </thead>

                <tbody>
                    <tr  v-for="(bok, index) in form.bokeya" :key="index">
                        <td>
                            <input type="hidden" v-model="form.itemId = index">
                            <div class="form-group">
                                                           <select v-model="bok.year" class="form-control">

                                                           <option>2021-2022</option><option>2020-2021</option><option>2019-2020</option><option>2018-2019</option><option>2017-2018</option><option>2016-2017</option><option>2015-2016</option><option>2014-2015</option><option>2013-2014</option><option>2012-2013</option><option>2011-2012</option><option>2010-2011</option><option>2009-2010</option><option>2008-2009</option><option>2007-2008</option><option>2006-2007</option><option>2005-2006</option><option>2004-2005</option><option>2003-2004</option><option>2002-2003</option><option>2001-2002</option>                                                        </select>
                            </div>

                        </td>

                        <td><div class="form-group"><input type="number" v-model="bok.price"  class="form-control w-full py-2 border border-indigo-500 rounded" min="0"  step="5"/></div></td>



                        <td><button type="button" class="ml-2 btn btn-danger" @click="remove(index)" v-show="index != 0">Remove</button></td>
                    </tr>



                </tbody>


            </table>


                                    </div>



                                </div>
                            </div>
                            <div class="border-top">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
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
                rows:{},
                form:{
                    holding_no:'',
                    maliker_name:'',
                    father_or_samir_name:'',
                    gramer_name:'',
                    word_no:'',
                    nid_no:'',
                    mobile_no:'',
                    category:'',
                    bokeya:[],
                    griher_barsikh_mullo:0,
                    jomir_vara:0,
                    barsikh_vara:0,
                }
            }
        },
        methods: {
            async list(){
                var res = await this.callApi('get',`/api/holding/tax/list?word=${this.$route.params.word}&union=${this.Users.unioun}`,[]);
            },


            addMore() {
                this.form.bokeya.push({
                                itemId: "",
                                status: "",
                                year: "",
                                price: 0,
                });
                },
                remove(index) {
                this.form.bokeya.splice(index, 1);
                },


                async finalSubmit(){
                    this.form['unioun']= this.Users.unioun
                    var res = await this.callApi('post',`/api/holding/tax/submit`,this.form)

                    this.$router.push({ name: 'holdingTaxWord'})
            Notification.customSuccess('Holding tax Update Success');
                },


        },
        mounted() {
            setTimeout(() => {
                this.list();

            }, 3000);
        },
    }
    </script>

<style scoped>
    a.btn.btn-info.btn-lg {
        font-size: 26px;
        margin: 4px;
    }

    </style>
