<template>
    <div>
        <form @submit.stop.prevent="onSubmit">

            <!-- <div class="panel-heading" style="font-weight: bold; font-size: 20px;background:#159513;text-align:center;color:white">{{ sonodnamedata.bnname }} </div> -->
            <div class="panel-heading" style="font-weight: bold; font-size: 20px;background:#159513;text-align:center;color:white">{{ form.sonod_name }} </div>


            <div class="form-pannel">
                <input type="hidden" v-model="form.unioun_name = getUnion.subdomainget">







                    <div class="row">




                    <div class="col-md-12">
                        <div class="app-heading">আবেদনকারীর তথ্য</div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">আবেদনকারীর নাম <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" v-model="form.applicant_name" required>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">লিঙ্গ</label>
                            <select class="form-control" v-model="form.applicant_gender">
                                <option value="">লিঙ্গ নির্বাচন করুন</option>
                                <option>পুরুষ</option>
                                <option>মহিলা</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">পিতা/স্বামীর নাম</label>
                            <input type="text" class="form-control" v-model="form.applicant_father_name">
                        </div>
                    </div>

                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="" class="labelColor">মাতার নাম</label>
                            <input type="text" class="form-control" v-model="form.applicant_mother_name">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জাতীয় পরিচয়পত্র নং</label>
                            <input type="text" class="form-control" v-model="form.applicant_national_id_number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জন্ম নিবন্ধন নং</label>
                            <input type="text" class="form-control" v-model="form.applicant_birth_certificate_number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">হোল্ডিং নং</label>
                            <input type="text" class="form-control" v-model="form.applicant_holding_tax_number">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জন্ম তারিখ</label>
                            <input type="date" class="form-control" v-model="form.applicant_date_of_birth">
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4" >
                        <div class="form-group">
                            <label for="" class="labelColor">ছবি</label>
                            <input type="file" accept="image/*" class="custom-file-input" @change="FileSelected($event, 'image')" id="image">
                            <label class="custom-file-label" style="margin: 0px auto;margin-top: 32px;width: 93%;" for="image">Choose file</label>
                            <img style="    width: 100%;" thumbnail fluid v-if="form.image != null" :src="form.image" alt="Image 3" />
                        </div>
                    </div>



                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">মোবাইল</label>
                            <input type="tel" class="form-control" name="phone" minlength="11" maxlength="11" v-model="form.applicant_mobile" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ই-মেইল</label>
                            <input type="email" class="form-control" v-model="form.applicant_email">
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="app-heading">বর্তমান ঠিকানা</div>
                        <div class="col-md-12">
                        </div>



                        <div class="form-group" style="    margin-top: 66px !important;">
                            <label for="" class="labelColor">বিভাগ</label>

                            <select class='form-control' name="division" id="division" v-model="Pdivision" @change="getdistrictFun" >
                            <option value="">বিভাগ নির্বাচন করুন</option>
                                <option v-for="div in getdivisions" :key="'divsion'+div.id" :value="div.id">{{ div.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_district"> -->
                        </div>

                        <div class="form-group">
                            <label for="" class="labelColor">জেলা</label>

                        <select   class='form-control' name="district" id="district" v-model="applicant_present_district" @change="getthanaFun" >
                            <option value="">জেলা নির্বাচন করুন</option>
                            <option v-for="dist in getdistricts" :key="'dist'+dist.id" :value="dist.id">{{ dist.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_district"> -->
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">উপজেলা/থানা</label>

                        <select  class='form-control' name="thana" id="thana" v-model="form.applicant_present_Upazila" @change="getuniounFun" >
                            <option value="">উপজেলা নির্বাচন করুন</option>
                            <option v-for="thana in getthanas" :key="'thana'+thana.id" :value="thana.bn_name">{{ thana.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_Upazila"> -->
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">পোষ্ট অফিস</label>
                            <input type="text" class="form-control" v-model="form.applicant_present_post_office">
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">ওয়ার্ড নং</label>
                            <select v-model="form.applicant_present_word_number" id="word_no" class="form-control" required>
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
                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_word_number"> -->
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">গ্রাম/মহল্লা</label>
                            <input type="text" class="form-control" v-model="form.applicant_present_village">
                        </div>
                        <!-- <div class="form-group">
                            <label for="" class="labelColor">রোড/ব্লক/সেক্টর</label>
                            <input type="text" class="form-control" v-model="form.applicant_present_road_block_sector">
                        </div> -->


                    </div>
                    <div class="col-md-6">
                        <div class="app-heading">স্থায়ী ঠিকানা</div>
                        <div class="col-md-12">
                            <input type="checkbox" id="checkbox" v-model="sameStatus" @change="sameAddress"> <label
                                for="checkbox"> বর্তমান ঠিকানা ও স্থায়ী ঠিকানা একই হলে</label>
                        </div>


                        <div class="form-group">
                            <label for="" class="labelColor">বিভাগ</label>

                            <select class='form-control' name="division" id="division" v-model="Perdivision" @change="getdistrictFunPer" >
                            <option value="">বিভাগ নির্বাচন করুন</option>
                                <option v-for="div in getdivisionsPer" :key="'getdivisionsPer'+div.id" :value="div.id">{{ div.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_district"> -->
                        </div>



                        <div class="form-group">
                            <label for="" class="labelColor">জেলা</label>

                            <select   class='form-control' name="district" id="district" v-model="applicant_permanent_district" @change="getthanaFunPer" >
                            <option value="">জেলা নির্বাচন করুন</option>
                            <option v-for="dist in getdistrictsPer" :key="'getdistrictsPer'+dist.id" :value="dist.id">{{ dist.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_permanent_district"> -->
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">উপজেলা/থানা</label>
                            <select  class='form-control' name="thana" id="thana" v-model="form.applicant_permanent_Upazila" @change="getuniounFunPer" >
                                <option value="">উপজেলা নির্বাচন করুন</option>
                                <option v-for="thana in getthanasPer" :key="'getthanasPer'+thana.id" :value="thana.bn_name">{{ thana.bn_name }}</option>
                            </select>
                            <!-- <input type="text" class="form-control" v-model="form.applicant_permanent_Upazila"> -->
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">পোষ্ট অফিস</label>
                            <input type="text" class="form-control" v-model="form.applicant_permanent_post_office">
                        </div>

                        <div class="form-group">
                            <label for="" class="labelColor">ওয়ার্ড নং</label>
                            <select v-model="form.applicant_permanent_word_number" id="word_no" class="form-control" required>
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
                            <!-- <input type="text" class="form-control" v-model="form.applicant_permanent_word_number"> -->
                        </div>

                        <div class="form-group">
                            <label for="" class="labelColor">গ্রাম/মহল্লা</label>
                            <input type="text" class="form-control" v-model="form.applicant_permanent_village">
                        </div>
                        <!-- <div class="form-group">
                            <label for="" class="labelColor">রোড/ব্লক/সেক্টর</label>
                            <input type="text" class="form-control"
                                v-model="form.applicant_permanent_road_block_sector">
                        </div> -->

                    </div>
                </div>




                <div class="row">
                    <div class="col-md-12">
                        <div class="app-heading"> ইমারত নির্মাণ/পুকুর খনন/পাহাড় কর্তন এর তথ্য</div>
                    </div>

                    <div class="col-md-12">
                        <div class="text-heading"> যে জমিতে ইমারত নির্মাণ/পুকুর খনন/পাহাড় কর্তন করা হবে তাঁর বিবরণ</div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">সিটি কর্পোরেশন/পৌরসভা/আম/মহল্লা/ উন্নয়নকৃত এলাকার নাম {{ form.building_construction['areaName'] }}</label>
                            <input type="text" v-model="form.building_construction['areaName']" class="form-control" >
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">দাগ ও খতিয়ান নং (জরিপ মোতাবেক)/প্লট নং</label>
                            <input type="text"  v-model="form.building_construction['dagKhotiyan']"   class="form-control" >
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor"> মৌজার নাম / ব্লক নং/সেক্টর নং</label>
                            <input type="text"  v-model="form.building_construction['Mouja']"  class="form-control" >
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ওয়ার্ড নং (প্রযোজ্য ক্ষেত্রে)</label>
                            <select  class="form-control"  v-model="form.building_construction['wordNo']">
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
                            <label for="" class="labelColor">রাস্তার নাম</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['rastarName']" >
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">সিট নং (প্রযোজ্য ক্ষেত্রে)</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['sitNo']" >
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">দাগে আবেদনকারী/আবেদনকারীগণের অংশের পরিমাণ</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['dageApplicantOngso']" >
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">আবেদনকারী/আবেদনকারীগণ কি সূত্রে সাইটের জমি অর্জন করিয়াছেন</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['jomirMakilType']" >
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="text-heading"> সাইটের বিবরণ</div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">সাইটের আয়তন (ক্ষেত্রফল)</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterAyoton']" >
                        </div>
                    </div>

                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">সাইটের চৌহদ্দী (বাহুর পরিমাণ)</div>
                    </div>
                    <div class="col-md-12"></div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">উত্তরে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterUttore']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">দক্ষিণে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterDokhine']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">পূর্বে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterPurbe']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">পশ্চিমে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterPoschime']" >
                        </div>
                    </div>


                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">ইমারত দ্বারা সাইটের যে পরিমাণ স্থান আচ্ছাদিত হইবে তাহার বিশদ বিবরণ</div>
                    </div>
                    <div class="col-md-12"></div>
                    <!-- col-md-3 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="labelColor">১ম তলা </label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['protomTola']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="labelColor">অন্যান্য তলা </label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['OnnannoTola']" >
                        </div>
                    </div>



                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">সাইটের নিকটস্থ রাস্তার বিবরণ</div>
                    </div>
                    <div class="col-md-12"></div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">নাম</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterNikotName']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">অবস্থান (কোনদিকে)</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterNikotObostan']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">দূরত্ব</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterNikotDurotto']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">বিস্তার</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterNikotBistar']" >
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="labelColor">নিকটস্থ রাস্তা হইতে সাইটে যাতায়াতের উপায়</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterNikotJatayatUpay']" >
                        </div>
                    </div>




                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">সাইটের বিভিন্ন দিকে যে পরিমাণ স্থান উন্মুক্ত রাখা হইবে</div>
                    </div>
                    <div class="col-md-12"></div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">উত্তর সীমানা হইতে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterFakaUttorDike']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">দক্ষিণ সীমানা হইতে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterFakaDokhinDike']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">পূর্ব সীমানা হইতে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterFakaPurboDike']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">পশ্চিম সীমানা হইতে</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['siterFakaPoschimDike']" >
                        </div>
                    </div>






                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">সাইটের পূর্ব নির্মিত কাঁচা/পাকা ইমারতের বিবরণ (যদি থাকে)</div>
                    </div>
                    <div class="col-md-12"></div>
                    <!-- col-md-3 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="labelColor">পূর্ব নির্মিত ইমারতের সংখ্যা ও তদ্বারা বেষ্টিত স্থানের পরিমাণ </label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['PurbeImaroterSonkha']" >
                        </div>
                    </div>
                    <!-- col-md-3 -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রস্তাবিত ইমারত নির্মাণ অনুমোদিত হলে পূর্ব নির্মিত ইমারতের কোন অংশ ভাংতে হবে কিনা এবং হলে তদ্বারা স্থানের পরিমাণ </label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['vagaStanerPoriman']" >
                        </div>
                    </div>




                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">এলাকার বিভিন্ন সেবা-সুযোগের বিবরণ </div>
                    </div>
                    <div class="col-md-12"></div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor"> বিদ্যুৎ সরবরাহ লাইন আছে কিনা </label>
                            <select  class="form-control"  v-model="form.building_construction['BidudLIneAcheKina']" >
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor"> পানি সরবরাহ লাইন আছে কিনা </label>
                            <select  class="form-control"  v-model="form.building_construction['paniLIneAcheKina']">
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor">গ্যাস সরবরাহ লাইন আছে কিনা </label>
                            <select  class="form-control"  v-model="form.building_construction['gasLIneAcheKina']" >
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor"> পয়ঃ নিষ্কাশন লাইন আছে কিনা </label>
                            <select  class="form-control"  v-model="form.building_construction['poyNiskasonLIneAcheKina']" >
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="" class="labelColor"> প্রস্তাবিত ইমারতের ক্ষেত্রে সেপ্টিক ট্যাংকের ব্যবস্থা আছে কিনা </label>
                            <select  class="form-control"  v-model="form.building_construction['tackLIneAcheKina']" >
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div>




                    <div class="col-md-12"></div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="labelColor"> প্রস্তাবিত ইমারত নির্মাণ/পুকুর খনন/পাহাড় কর্তন বা ধ্বংস সাধনের কাজ কখন শুরু হবে</label>
                            <input type="date"  class="form-control"  v-model="form.building_construction['startDate']" >
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="labelColor"> প্রস্তাবিত ইমারত নির্মাণ/পুকুর খনন/পাহাড় কর্তন বা ধ্বংস সাধনের উদ্দেশ্য</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['uddesso']" >
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="labelColor"> অথরাইজড অফিসারের অনুমোদন ব্যতীত আবেদনকারী পূর্বে কোন ইমারত নির্মাণ/পুকুর খনন/পাহাড় কর্তন বা ধ্বংস সাধন করিয়া থাকিলে তজ্জন্য তাহার বিরুদ্ধে Building Construction Act, 1952 (E.B. Act II of 1953) এর অধীন নোটিশ জারী হইয়াছে কিনা</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['faltImarotTodontto']" >
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রস্তাবিত ইমারত নির্মাণ/পুকুর খনন /পাহাড় কর্তন বা ধ্বংস সাধন সম্পর্কে আবেদনকারীর বিরুদ্ধে Building Construction Act, 1952 (E.B. Act II of 1953) এর section 12 এর অধীন কোন মামলা দায়ের হইয়াছে কিনা</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['mamlaTodontto']" >
                        </div>
                    </div>

                    <div class="col-md-12"></div>
                    <div class="col-md-12">
                        <div class="text-heading">প্রস্তাবিত পুকুর খনন/পাহাড় কর্তন বা ধ্বংস সাধনের স্থান হইতে নিকটবর্তী :- </div>
                    </div>
                    <div class="col-md-12"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">রাস্তার দূরত্ব</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['rastarDurotto']" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ইমারতের দূরত্ব</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['imaroterDurotto']" >
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">পয়ঃ নালার দূরত্ব</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['poyNalarDurotto']">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">বিদ্যুৎ সরবরাহ লাইনের দূরত্ব</label>
                            <input type="text"  class="form-control"   v-model="form.building_construction['bidudLineDurotto']">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">গ্যাস সরবরাহ লাইনের দূরত্ব</label>
                            <input type="text"  class="form-control"  v-model="form.building_construction['gasLineDurotto']" >
                        </div>
                    </div>






                </div>





                <div class="row">
                    <div class="col-md-12">
                        <div class="app-heading"> সংযুক্ত</div>
                    </div>
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জাতীয় পরিচয়পত্র (Front page)</label>
                            <input type="file" accept="image/*" class="form-control custom-file-input" @change="FileSelected($event, 'applicant_national_id_front_attachment')" id="applicant_national_id_front_attachment">
                                <label class="custom-file-label" style="margin: 0px auto;margin-top: 32px;width: 93%;"  for="applicant_national_id_front_attachment">Choose file</label>
                            <img style="    width: 100%;" thumbnail fluid v-if="form.applicant_national_id_front_attachment != null"
                                :src="form.applicant_national_id_front_attachment" alt="Image 3" />
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জাতীয় পরিচয়পত্র (Back page)</label>
                            <input type="file" accept="image/*" class="form-control custom-file-input"
                                @change="FileSelected($event, 'applicant_national_id_back_attachment')" id="applicant_national_id_back_attachment">
                                <label class="custom-file-label" style="margin: 0px auto;margin-top: 32px;width: 93%;"  for="applicant_national_id_back_attachment">Choose file</label>
                            <img style="    width: 100%;" thumbnail fluid v-if="form.applicant_national_id_back_attachment != null"
                                :src="form.applicant_national_id_back_attachment" alt="Image 3" />
                        </div>
                    </div>
                    <!-- col-md-4 -->
                    <!-- col-md-4 -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জন্ম নিবন্ধন</label>
                            <input type="file" accept="image/*" class="form-control custom-file-input"
                                @change="FileSelected($event, 'applicant_birth_certificate_attachment')" id="applicant_birth_certificate_attachment">
                                <label class="custom-file-label" style="margin: 0px auto;margin-top: 32px;width: 93%;"  for="applicant_birth_certificate_attachment">Choose file</label>
                            <img style="    width: 100%;" thumbnail fluid v-if="form.applicant_birth_certificate_attachment != null"
                                :src="form.applicant_birth_certificate_attachment" alt="Image 3" />
                        </div>
                    </div>
                    <!-- col-md-4 -->
                </div>




                <div style="text-align:center">
                    <b-button type="submit" variant="primary">সাবমিট</b-button>
                </div>
                <!-- <b-button class="ml-2" @click="resetForm()">রিসেট</b-button> -->
            </div>
        </form>



        <b-modal :id="infoModal.id" size="xl" :title="infoModal.title" ok-only ok-disabled no-close-on-esc
            no-close-on-backdrop>

            <div class="row" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'" >


        <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.enname == 'Certificate of Inheritance'"><b>মৃত ব্যাক্তির নাম : </b>{{ form.utname }}</div>
        <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.enname == 'Inheritance certificate'"><b>জীবিত ব্যক্তির নাম : </b>{{ form.utname }}</div>
        <div class="col-md-4 col-6 mt-3"><b>লিঙ্গ : </b>{{ form.applicant_gender }}</div>
        <div class="col-md-4 col-6 mt-3"><b>বৈবাহিক সম্পর্ক : </b>{{ form.applicant_marriage_status }}</div>
        <div class="col-md-4 col-6 mt-3"><b>পিতা/স্বামীর নাম : </b>{{ form.ut_father_name }}</div>
        <div class="col-md-4 col-6 mt-3"><b>মাতার নাম : </b>{{ form.ut_mother_name }}</div>
        <div class="col-md-4 col-6 mt-3"><b>পিতা জীবিত কিনা : </b>{{ form.successor_father_alive_status }}</div>
        <div class="col-md-4 col-6 mt-3"><b>মাতা জীবিত কিনা : </b>{{ form.successor_mother_alive_status }}</div>
        <div class="col-md-4 col-6 mt-3"><b>পেশা : </b>{{ form.applicant_occupation }}</div>
        <div class="col-md-4 col-6 mt-3"><b>বাসিন্দা : </b>{{ form.applicant_resident_status }}</div>


            </div>







            <div class="row">
                <div class="col-md-12">
                    <div class="app-heading">আবেদনকারীর তথ্য</div>
                </div>
                <div class="col-md-4 mt-3"></div>
                <div class="col-md-4 mt-3"><img width="100%" :src="form.image" alt=""></div>
                <div class="col-md-4 mt-3"></div>
                <div class="col-md-4 col-6 mt-3"><b>আবেদনকারীর নাম : </b>{{ form.applicant_name }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.enname == 'Certification of the same name'">
                    <b>দ্বিতীয় নাম : </b>{{ form.applicant_second_name }}
                </div>

                <div class="col-md-4 col-6 mt-3" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>

                <div class="col-md-4 col-6 mt-3" v-else><b>লিঙ্গ : </b>{{ form.applicant_gender }}</div>

                <div class="col-md-4 col-6 mt-3" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>
                <div class="col-md-4 col-6 mt-3" v-else><b>পিতা/স্বামীর নাম : </b>{{ form.applicant_father_name }}
                </div>

                <div class="col-md-4 col-6 mt-3"><b>মাতার নাম : </b>{{ form.applicant_mother_name }}</div>

                <div class="col-md-4 col-6 mt-3"><b>ন্যাশনাল আইডি : </b>{{ form.applicant_national_id_number }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জন্ম নিবন্ধন নং : </b>{{ form.applicant_birth_certificate_number }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>হোল্ডিং নং : </b>{{ form.applicant_holding_tax_number }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জম্ম তারিখ : </b>{{ form.applicant_date_of_birth }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.enname == 'Family certificate'"><b>বংশের নাম :
                    </b>{{ form.family_name }}</div>
                <div class="col-md-4 col-6 mt-3"
                    v-if="sonodnamedata.enname == 'Certificate of annual income' || sonodnamedata.enname == 'Parents Income Certificate'">
                    <b>বার্ষিক আয় : </b>{{ form.Annual_income }}
                </div>
                <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.enname == 'permit'"><b>অনুমতি এর বিষয় : </b>{{
                form.Subject_to_permission
                }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.bnname == 'প্রতিবন্ধী সনদপত্র'"><b>প্রতিবন্ধী :
                    </b>{{ form.disabled }}</div>
                <div class="col-md-4 col-6 mt-3"
                    v-if="sonodnamedata.enname == 'No Objection Letter to Transfer of Constituency'"><b>স্থানান্তরিত
                        এলাকার নাম : </b>{{ form.Name_of_the_transferred_area }}</div>
                <div class="col-md-4 col-6 mt-3" v-if="sonodnamedata.enname == 'Certificate'"><b>প্রত্যয়নপত্র এর বিষয় :
                    </b>{{ form.The_subject_of_the_certificate }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পাসপোর্ট নং : </b>{{ form.applicant_passport_number }}</div>
                <div class="col-md-4 col-6 mt-3" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>
                <div class="col-md-4 col-6 mt-3" v-else><b>বৈবাহিক সম্পর্ক : </b>{{ form.applicant_marriage_status }}</div>
                <div class="col-md-4 col-6 mt-3" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>
                <div class="col-md-4 col-6 mt-3" v-else><b>পেশা: </b>{{ form.applicant_occupation }}</div>
                <div class="col-md-4 col-6 mt-3"><b>শিক্ষাগত যোগ্যতা: </b>{{ form.applicant_education }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ধর্ম: </b>{{ form.applicant_religion }}</div>
                <div class="col-md-4 col-6 mt-3" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>
                <div class="col-md-4 col-6 mt-3" v-else><b>বাসিন্দা: </b>{{ form.applicant_resident_status }}</div>
                <div class="col-md-12 col-12 mt-3" v-if="form.sonod_name != 'ট্রেড লাইসেন্স'"><b>আবেদনকৃত প্রত্যয়নের
                        : <br> </b>{{ form.prottoyon }}</div>
                <div class="col-md-12">
                    <div class="app-heading">বর্তমান ঠিকানা</div>
                </div>
                <div class="col-md-4 col-6 mt-3"><b>গ্রাম/মহল্লা: </b>{{ form.applicant_present_village }}</div>
                <div class="col-md-4 col-6 mt-3"><b>রোড/ব্লক/সেক্টর: </b>{{ form.applicant_present_road_block_sector }}
                </div>
                <div class="col-md-4 col-6 mt-3"><b>ওয়ার্ড নং: </b>{{ form.applicant_present_word_number }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জেলা: </b>{{ form.applicant_present_district }}</div>
                <div class="col-md-4 col-6 mt-3"><b>উপজেলা/থানা: </b>{{ form.applicant_present_Upazila }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পোষ্ট অফিস: </b>{{ form.applicant_present_post_office }}</div>
                <div class="col-md-12">
                    <div class="app-heading">স্থায়ী ঠিকানা</div>
                </div>
                <div class="col-md-4 col-6 mt-3"><b>গ্রাম/মহল্লা: </b>{{ form.applicant_permanent_village }}</div>
                <div class="col-md-4 col-6 mt-3"><b>রোড/ব্লক/সেক্টর: </b>{{ form.applicant_permanent_road_block_sector
                }}</div>
                <div class="col-md-4 col-6 mt-3"><b>ওয়ার্ড নং: </b>{{ form.applicant_permanent_word_number }}</div>
                <div class="col-md-4 col-6 mt-3"><b>জেলা: </b>{{ form.applicant_permanent_district }}</div>
                <div class="col-md-4 col-6 mt-3"><b>উপজেলা/থানা: </b>{{ form.applicant_permanent_Upazila }}</div>
                <div class="col-md-4 col-6 mt-3"><b>পোষ্ট অফিস: </b>{{ form.applicant_permanent_post_office }}</div>
                <div class="col-md-12">
                    <div class="app-heading">যোগাযোগের ঠিকানা</div>
                </div>
                <div class="col-md-6 col-6 mt-3"><b>মোবাইল: </b>{{ form.applicant_mobile }}</div>
                <div class="col-md-6 col-6 mt-3"><b>ইমেল: </b>{{ form.applicant_email }}</div>
                <div class="col-md-12">
                    <div class="app-heading">সংযুক্ত</div>
                </div>
                <div class="col-md-4 col-6 mt-3"><span>ন্যাশনাল আইডি (Front page)</span> <br> <img width="100%"
                        :src="form.applicant_national_id_front_attachment" alt=""></div>
                <div class="col-md-4 col-6 mt-3"><span>ন্যাশনাল আইডি (Back page)</span> <br> <img width="100%"
                        :src="form.applicant_national_id_back_attachment" alt=""></div>
                <div class="col-md-4 col-6 mt-3"><span>জন্ম নিবন্ধন</span> <br> <img width="100%"
                        :src="form.applicant_birth_certificate_attachment" alt=""></div>
                <div class="col-md-12" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.bnname == 'Inheritance certificate'">
                    <div class="app-heading">ওয়ারিশগনের তালিকা </div>
                </div>
                <table class="table" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.bnname == 'Inheritance certificate'">
                    <tr>
                        <th>ক্রমিক</th>
                        <th>নাম</th>
                        <th>সম্পর্ক</th>
                        <th>জন্ম তারিখ</th>
                        <th>জাতীয় পরিচয়পত্র নাম্বার</th>
                    </tr>
                    <tr v-for="(ut, indexs) in form.successors" :key="'uts' + indexs">
                        <td>{{ ut.w_id }}</td>
                        <td>{{ ut.w_name }}</td>
                        <td>{{ ut.w_relation }}</td>
                        <td>{{ ut.w_age }}</td>
                        <td>{{ ut.w_nid }}</td>
                    </tr>
                </table>
            </div>
            <br>
            <br>
            <form @submit.stop.prevent="finalSubmit" style="margin-top: 50px;">
                <div class="text-center" style="width:50%;margin:0 auto" v-if="getunionInfos.payment_type == 'Prepaid'">
                    <h3>আপনার আবেদনটি সফল করার জন্য সনদের ফি প্রদান করুন । {{ sonodnamedata.bnname }} এর ফি {{
                    charages.totalamount
                    }} টাকা ।</h3>
                    <button type="submit" class="btn btn-info" v-if="!submitLoad">Pay And Submit</button>
                    <span class="btn btn-info" v-else-if="submitLoad">Please Wait...</span>
                    <button type="submit" class="btn btn-info" v-if="submitLoad">Try Again</button>
                </div>
                <div class="text-center" style="width:50%;margin:0 auto"
                    v-else-if="getunionInfos.payment_type == 'Postpaid'">
                    <h3>আপনার আবেদনটি সফল করার জন্য Confirm বাটন এ চাপ দিন</h3>
                    <button type="submit" class="btn btn-info" v-if="!submitLoad">Confirm</button>
                    <span class="btn btn-info" v-else-if="submitLoad">Please Wait...</span>
                </div>
            </form>

            <template #modal-footer>
<div></div>
      </template>

        </b-modal>
    </div>
</template>
<script>
export default {
    data() {
        return {
            infoModal: {
                id: 'info-modal',
                title: '',
                content: '',
                content_id: '',
            },
            charages: {
                sonod_fee: 0,
                vatAmount: 0,
                taxAmount: 0,
                service: 0,
                totalamount: 0,
            },
            pesaKor:0,
            waitForPayment: false,
            submitLoad: false,
            sameStatus: '',
            sonodnamedata: {},
            sonodnameFee: {},
            SonodNamesOptions: {},
            form: {
                image: null,
                sonod_Id: '',
                unioun_name: null,
                year: null,
                ut_name: null,
                ut_religion: '',
                sonod_name: null,
                applicant_holding_tax_number: null,
                applicant_national_id_number: null,
                applicant_birth_certificate_number: null,
                applicant_passport_number: null,
                applicant_date_of_birth: null,
                family_name: null,
                Annual_income: null,
                Subject_to_permission: null,
                disabled: null,
                The_subject_of_the_certificate: null,
                Name_of_the_transferred_area: null,
                applicant_name: null,
                applicant_second_name: null,
                applicant_name_of_the_organization: null,
                organization_address: null,
                applicant_gender: null,
                applicant_marriage_status: null,
                ut_father_name: null,
                ut_mother_name: null,
                applicant_father_name: null,
                applicant_mother_name: null,
                applicant_occupation: null,
                applicant_education: null,
                applicant_religion: null,
                applicant_resident_status: null,
                applicant_owner_type: null,
                applicant_vat_id_number: null,
                applicant_tax_id_number: null,
                applicant_type_of_business: null,
                applicant_type_of_businessKhat: null,
                applicant_type_of_businessKhatAmount: null,
                successor_father_alive_status: null,
                successor_mother_alive_status: null,
                utname: null,
                //////////////////////////////////////////////
                // বর্তমান ঠিকানা
                ut_grame: null,
                ut_word: null,
                ut_post: null,
                ut_thana: null,
                ut_district: null,
                //////////////////////////////////////////////
                // বর্তমান ঠিকানা
                applicant_present_village: null,
                applicant_present_road_block_sector: null,
                applicant_present_word_number: null,
                applicant_present_district: null,
                applicant_present_Upazila: null,
                applicant_present_post_office: null,
                //////////////////////////////////////////////
                // স্থায়ী ঠিকানা
                applicant_permanent_village: null,
                applicant_permanent_road_block_sector: null,
                applicant_permanent_word_number: null,
                applicant_permanent_district: null,
                applicant_permanent_Upazila: null,
                applicant_permanent_post_office: null,
                //////////////////////////////////////////////
                // যোগাযোগের ঠিকানা
                applicant_mobile: null,
                applicant_email: null,
                //////////////////////////////////////////////
                // Attachment
                applicant_national_id_front_attachment: null,
                applicant_national_id_back_attachment: null,
                applicant_birth_certificate_attachment: null,
                prottoyon: null,
                stutus: 'Pending',
                payment_status: 'Unpaid',
                building_construction:{
                    areaName:''
                },
                successors: [
                    {
                        w_id: "",
                        w_name: "",
                        w_relation: "",
                        w_age: "",
                        w_nid: "",
                    },
                ],
            },
            TradeLicenseKhats:{},
            TradeLicenseKhatAmouts:{},



            getdivisions:{},
            getdistricts:{},
            getthanas:{},
            getuniouns:{},

            getdivisionsPer:{},
            getdistrictsPer:{},
            getthanasPer:{},
            getuniounsPer:{},
            Pdivision:'',
            Perdivision:'',
            applicant_present_district:'',
            applicant_permanent_district:'',
            businessType:true,
        };
    },
    watch: {
        '$route': {
            handler(newValue, oldValue) {
                this.form.year = new Date().getFullYear();
                this.sonodname();
            },
            deep: true
        }
    },

    methods: {


        building_construction_array(name){

            this.building_construction.push(name);

        },



        async getdivisionFun(){
        //  var res = await this.callApi('get',`/api/getdivisions`,[]);
         this.getdivisions = this.allDivision;
        },

        async getdistrictFun(){

        var res = await this.callApi('get',`/api/getdistrict?id=${this.Pdivision}`,[]);
        this.getdistricts = res.data;




        },

        async getthanaFun(){
        var res = await this.callApi('get',`/api/getthana?id=${this.applicant_present_district}`,[]);
        this.getthanas = res.data;
        var resOwn = await this.callApi('get',`/api/getdistrict?ownid=${this.applicant_present_district}`,[]);
        this.form.applicant_present_district = resOwn.data.bn_name

        },

        async getuniounFun(){
        var res = await this.callApi('get',`/api/getunioun?id=${this.thana}`,[]);
        this.getuniouns = res.data;
        },




        //////////////////////////////////

        async getdivisionFunPer(){
        //  var res = await this.callApi('get',`/api/getdivisions`,[]);
         this.getdivisionsPer = this.allDivision;
        },

        async getdistrictFunPer(){

        var res = await this.callApi('get',`/api/getdistrict?id=${this.Perdivision}`,[]);
        this.getdistrictsPer = res.data;



        },

        async getthanaFunPer(){
            // console.log(this.applicant_permanent_district)
        var res = await this.callApi('get',`/api/getthana?id=${this.applicant_permanent_district}`,[]);
        this.getthanasPer = res.data;
        var resOwn = await this.callApi('get',`/api/getdistrict?ownid=${this.applicant_permanent_district}`,[]);
        this.form.applicant_permanent_district = resOwn.data.bn_name

        },

        async getuniounFunPer(){
        var res = await this.callApi('get',`/api/getunioun?id=${this.thana}`,[]);
        this.getuniounsPer = res.data;
        },



        FileSelected($event, parent_index) {
            let file = $event.target.files[0];
            if (file.size > 5048576) {
                Notification.image_validation();
            } else {
                let reader = new FileReader;
                reader.onload = event => {
                    this.form[parent_index] = event.target.result
                    // console.log(event.target.result);
                };
                reader.readAsDataURL(file)
            }
        },


        sameAddress() {
            // console.log(value)
            if (this.sameStatus) {

                this.getdivisionFunPer();
                this.Perdivision = this.Pdivision
                this.getdistrictFunPer();
                this.applicant_permanent_district = this.applicant_present_district
                this.getthanaFunPer();
                this.form.applicant_permanent_Upazila = this.form.applicant_present_Upazila


                this.form.applicant_permanent_village = this.form.applicant_present_village
                this.form.applicant_permanent_road_block_sector = this.form.applicant_present_road_block_sector
                this.form.applicant_permanent_word_number = this.form.applicant_present_word_number

                this.form.applicant_permanent_post_office = this.form.applicant_present_post_office




            } else {
                this.form.applicant_permanent_village = null
                this.form.applicant_permanent_road_block_sector = null
                this.form.applicant_permanent_word_number = null
                this.form.applicant_permanent_district = null
                this.form.applicant_permanent_Upazila = null
                this.form.applicant_permanent_post_office = null
            }
        },
        sonodname() {
            if (this.$route.params.name) {
                axios.get(`/api/get/sonodname/list?data=${this.$route.params.name.replaceAll('_', ' ')}&fees=1&unioun=${localStorage.getItem('unioun')}`)
                    .then(({ data }) => {
                        this.sonodnamedata = data.sonodname
                        this.sonodnameFee = data.sonodFee

						this.form.sonod_name = this.sonodnamedata.bnname;
                        window.scrollTo(0, 0);
                    })
                    .catch()
            }
        },
        resetInfoModal() {
            this.infoModal.title = ''
            this.infoModal.content = ''
        },
        async onSubmit() {
            var sonod_fee = 0
            var payment_type = this.getunionInfos.payment_type;
            if (payment_type == 'Prepaid') {
                var sonod_fee = Number(this.sonodnameFee.fees)
            }

            var vat = Number(this.getvatTax.vat)
            var tax = Number(this.getvatTax.tax)
            var service = Number(this.getvatTax.service)
            var vatAmount = ((sonod_fee * vat) / 100);
            var taxAmount = ((sonod_fee * tax) / 100);
            // var totalamount = sonod_fee + vatAmount + taxAmount + service

            var tradeVat = 15;
            if(this.form.sonod_name=='ট্রেড লাইসেন্স'){


                var TradevatAmount =  ((sonod_fee * tradeVat) / 100);
                var totalamount = Number(this.pesaKor) + sonod_fee + TradevatAmount
            }else{

                var totalamount = sonod_fee
            }


            this.charages = {
                sonod_fee: sonod_fee,
                vatAmount: vatAmount,
                taxAmount: taxAmount,
                pesaKor: this.pesaKor,
                service: service,
                tradeVat: tradeVat,
                totalamount: totalamount,
            },



                this.$root.$emit('bv::show::modal', this.infoModal.id)
        },
        async finalSubmit() {
            // this.submitLoad = true;
            var redirect;
            var payment_type = this.getunionInfos.payment_type;
            if (payment_type == 'Prepaid') {
                this.form.stutus = 'Prepaid';
            } else if (payment_type == 'Postpaid') {
                this.form.stutus = 'Pending';
            }
            this.form['charages'] = this.charages;
            var res = await this.callApi('post', '/api/nagorik/seba/inserts', this.form);
            var datas = res.data;
            if (payment_type == 'Prepaid') {
                redirect = `/sonod/payment/${datas.id}`
                this.waitForPayment = true;
                this.form['id'] = datas.id;
                // window.location.href =redirect;

            } else if (payment_type == 'Postpaid') {
                this.waitForPayment = true;
                Swal.fire({
                    title: 'অভিনন্দন',
                    text: `আপনার আবেদনটি সফলভাবে দাখিল হয়েছে`,
                    icon: 'success',
                    confirmButtonColor: 'green',
                    confirmButtonText: `আবেদন পত্র ডাউনলোড করুন`,
                    // showDenyButton: true,
                    showCancelButton: true,
                    // denyButtonText: 'রশিদ ডাউনলোড করুন',
                    cancelButtonText: 'Back to home',
                    customClass: {
                        actions: 'my-actions',
                        cancelButton: 'order-1 right-gap',
                        confirmButton: 'order-2',
                        denyButton: 'order-3',
                    },
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    preConfirm: () => {
                        redirect = '/document/' + res.data.sonod_name + '/' + res.data.id;
                        window.open(redirect, '_blank');
                        return false; // Prevent confirmed
                    },
                    preDeny: () => {
                        redirect = '/invoice/' + res.data.sonod_name + '/' + res.data.id;
                        window.open(redirect, '_blank');
                        return false; // Prevent denied
                    },
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        // this.$root.$emit('bv::hide::modal', 'info-modal')
                    } else if (result.isDenied) {
                        // this.$root.$emit('bv::hide::modal', 'info-modal')
                    } else if (result.isDismissed) {
                        //cancel
                        this.$router.push({ name: 'home' })
                    }
                })

            }
        },
    },
    mounted() {



        this.getdivisionFun();
        this.getdivisionFunPer();

        this.form.year = new Date().getFullYear();
        this.sonodname();
        setTimeout(() => {
            this.form.sonod_name = this.sonodnamedata.bnname;
        }, 3000);
    }
};
</script>
<style scoped >
.app-heading {
    text-align: center;
    margin: 32px 0;
    font-size: 23px;
    border-bottom: 1px solid #159513;
    color: #ffffff;
    background: #255f95;
}
.form-pannel {
    border: 1px solid #159513;
    padding: 25px 25px 25px 25px;
}
.panel-heading {
    padding: 11px 0px;
    border-top-right-radius: 6px;
    border-top-left-radius: 6px;
    margin-top: 20px;
}
.form-pannel {
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}
.dropdown-menu {
    z-index: 99999;
}
.labelColor {
    color: #493eff;
    font-weight: 600;
}



.text-heading {
    font-size: 21px;
    color: green;
    border-bottom: 2px solid green;
    text-align: center;
    margin-bottom: 25px;
}

</style>
