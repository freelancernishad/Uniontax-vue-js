<template>
    <div>
        <form @submit.stop.prevent="onSubmit">
            <div class="panel-heading"
                style="font-weight: bold; font-size: 20px;background:#159513;text-align:center;color:white">{{
                sonodnamedata.bnname
                }}
            </div>
            <div class="form-pannel">





                <div class="row" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'" >
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor" v-if="sonodnamedata.enname == 'Certificate of Inheritance'">মৃত ব্যাক্তির নাম *</label>
                            <label for="" class="labelColor" v-if="sonodnamedata.enname == 'Inheritance certificate'">জীবিত ব্যক্তির নাম *</label>
                            <input type="text" class="form-control" v-model="form.utname">
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

<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">বৈবাহিক সম্পর্ক</label>
                            <select class="form-control" v-model="form.applicant_marriage_status">
                                <option value="">নির্বাচন করুন</option>
                                <option>বিবাহিত</option>
                                <option>অবিবাহিত</option>
                                <option>তালাক প্রাপ্ত</option>
                                <option>বিধবা</option>
                                <option>অন্যান্য</option>
                            </select>
                        </div>
                    </div> -->


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">পিতা/স্বামীর নাম</label>
                            <input type="text" class="form-control" v-model="form.ut_father_name">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">মাতার নাম</label>
                            <input type="text" class="form-control" v-model="form.ut_mother_name">
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">গ্রাম</label>
                            <input type="text" class="form-control" v-model="form.ut_grame" required>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ওয়ার্ড নং</label>
                            <select v-model="form.ut_word" id="word_no" class="form-control" required>
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


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ডাকঘর</label>
                            <input type="text" class="form-control" v-model="form.ut_post" required>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">উপজেলা</label>
                            <input type="text" class="form-control" v-model="form.ut_thana" required>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">জেলা</label>
                            <input type="text" class="form-control" v-model="form.ut_district" required>
                        </div>
                    </div>


<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">পিতা জীবিত কিনা</label>
                            <select class="form-control" v-model="form.successor_father_alive_status">
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div> -->

<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">মাতা জীবিত কিনা</label>
                            <select class="form-control" v-model="form.successor_mother_alive_status">
                                <option value="">নির্বাচন করুন</option>
                                <option>হ্যাঁ</option>
                                <option>না</option>
                            </select>
                        </div>
                    </div> -->

<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">পেশা</label>
                            <input type="text" class="form-control" v-model="form.applicant_occupation">
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">বাসিন্দার ধরণ</label>
                            <select class="form-control" v-model="form.applicant_resident_status">
                                <option value="">নির্বাচন করুন</option>
                                <option>স্থায়ী</option>
                                <option>অস্থায়ী</option>
                            </select>
                        </div>
                    </div>








                </div>


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


                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Certification of the same name'">
                        <div class="form-group">
                            <label for="" class="labelColor">আবেদনকারীর দ্বিতীয় নাম</label>
                            <input type="text" class="form-control" v-model="form.applicant_second_name">
                        </div>
                    </div>


                    <div class="col-md-4" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>


                    <div class="col-md-4" v-else>
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
                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Family certificate'">
                        <div class="form-group">
                            <label for="" class="labelColor">বংশের নাম</label>
                            <input type="text" class="form-control" v-model="form.family_name">
                        </div>
                    </div>
                    <div class="col-md-4"
                        v-if="sonodnamedata.enname == 'Certificate of annual income' || sonodnamedata.enname == 'Parents Income Certificate'">
                        <div class="form-group">
                            <label for="" class="labelColor">বার্ষিক আয়</label>
                            <input type="text" class="form-control" v-model="form.Annual_income">
                        </div>
                    </div>
                    <div class="col-md-4" v-if="sonodnamedata.enname == 'permit'">
                        <div class="form-group">
                            <label for="" class="labelColor">অনুমতি এর বিষয়</label>
                            <input type="text" class="form-control" v-model="form.Subject_to_permission">
                        </div>
                    </div>
                    <div class="col-md-4" v-if="sonodnamedata.bnname == 'প্রতিবন্ধী সনদপত্র'">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রতিবন্ধী</label>
                            <select class="form-control" v-model="form.disabled">
                                <option value="">নির্বাচন করুন</option>
                                <option>শারীরিক</option>
                                <option>দৃষ্টি</option>
                                <option>শ্রবন</option>
                                <option>বাক</option>
                                <option>বুদ্ধি</option>
                                <option>বহুবিধ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4"
                        v-if="sonodnamedata.enname == 'No Objection Letter to Transfer of Constituency'">
                        <div class="form-group">
                            <label for="" class="labelColor">স্থানান্তরিত এলাকার নাম</label>
                            <input type="text" class="form-control" v-model="form.Name_of_the_transferred_area">
                        </div>
                    </div>
                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Certificate'">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রত্যয়নপত্র এর বিষয়</label>
                            <input type="text" class="form-control" v-model="form.The_subject_of_the_certificate">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4" v-if="sonodnamedata.enname != 'Certificate of Inheritance'">
                        <div class="form-group">
                            <label for="" class="labelColor">ছবি</label>
                            <input type="file" accept="image/*" class="custom-file-input" @change="FileSelected($event, 'image')" id="image">
                            <label class="custom-file-label" style="margin: 0px auto;margin-top: 32px;width: 93%;" for="image">Choose file</label>
                            <img style="    width: 100%;" thumbnail fluid v-if="form.image != null" :src="form.image" alt="Image 3" />
                        </div>
                    </div>
                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রতিষ্ঠানের মালিকানার ধরণ *</label>
                            <select class="form-control" v-model="form.applicant_owner_type">
                                <option value="">নির্বাচন করুন</option>
                                <option>ব্যক্তি মালিকানাধীন</option>
                                <option>যৌথ মালিকানা</option>
                                <option>কোম্পানী</option>
                            </select>
                        </div>
                    </div>


                    <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">সেবার ধরণ</label>
                            <select class="form-control" v-model="form.sonod_name" disabled>
                                <option value="">নির্বাচন করুন</option>
                                <option v-for="(sName, index) in SonodNames" :value="sName.bnname" :key="index">{{
                                sName.bnname }}</option>
                            </select>
                        </div>
                    </div> -->

<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">পাসপোর্ট নং ( ইংরেজিতে )</label>
                            <input type="text" class="form-control" v-model="form.applicant_passport_number">
                        </div>
                    </div> -->

                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রতিষ্ঠানের নাম</label>
                            <input type="text" class="form-control" v-model="form.applicant_name_of_the_organization">
                        </div>
                    </div>
           <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">প্রতিষ্ঠানের ঠিকানা</label>
                            <input type="text" class="form-control" v-model="form.organization_address">
                        </div>
                    </div>
<!--
                    <div class="col-md-4" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'"></div>
                    <div class="col-md-4" v-else>
                        <div class="form-group">
                            <label for="" class="labelColor">বৈবাহিক সম্পর্ক</label>
                            <select class="form-control" v-model="form.applicant_marriage_status">
                                <option value="">নির্বাচন করুন</option>
                                <option>বিবাহিত</option>
                                <option>অবিবাহিত</option>
                                <option>তালাক প্রাপ্ত</option>
                                <option>বিধবা</option>
                                <option>অন্যান্য</option>
                            </select>
                        </div>
                    </div> -->



                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">পেশা</label>
                            <input type="text" class="form-control" v-model="form.applicant_occupation">
                        </div>
                    </div>

<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">শিক্ষাগত যোগ্যতা</label>
                            <input type="text" class="form-control" v-model="form.applicant_education">
                        </div>
                    </div> -->

<!--
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ধর্ম</label>
                            <select class="form-control" v-model="form.applicant_religion">
                                <option value="">নির্বাচন করুন</option>
                                <option>ইসলাম</option>
                                <option>হিন্দু</option>
                                <option>বৌদ্ধ</option>
                                <option>খ্রিস্টান</option>
                                <option>অন্যান্য</option>
                            </select>
                        </div>
                    </div> -->


                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">ভ্যাট আইডি (যদি থাকে)</label>
                            <input type="text" class="form-control" v-model="form.applicant_vat_id_number">
                        </div>
                    </div>
                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">ট্যাক্স আইডি (যদি থাকে)</label>
                            <input type="text" class="form-control" v-model="form.applicant_tax_id_number">
                        </div>
                    </div>
                    <div class="col-md-4" v-if="sonodnamedata.enname == 'Trade license'">
                        <div class="form-group">
                            <label for="" class="labelColor">ব্যবসার ধরন</label>
                            <input type="text" class="form-control" v-model="form.applicant_type_of_business">
                        </div>
                    </div>
                    <div class="col-md-4" style="display:none" v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate' || sonodnamedata.enname == 'Trade license'"></div>
                    <div class="col-md-4" v-else>
                        <div class="form-group">
                            <label for="" class="labelColor">বাসিন্দার ধরণ</label>
                            <select class="form-control" v-model="form.applicant_resident_status">
                                <option value="">নির্বাচন করুন</option>
                                <option>স্থায়ী</option>
                                <option>অস্থায়ী</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">মোবাইল</label>
                            <input  type="tel"  maxlength="11" class="form-control" name="phone" v-model="form.applicant_mobile" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="" class="labelColor">ই-মেইল</label>
                            <input type="email" class="form-control" v-model="form.applicant_email">
                        </div>
                    </div>

                    <div class="col-md-12" v-if="sonodnamedata.enname == 'Miscellaneous certificates'">
                        <div class="form-group">
                            <label for="" class="labelColor">আবেদনকৃত প্রত্যয়নের বিবরণ উল্লেখ করুন</label>
                            <textarea class="form-control" v-model="form.prottoyon" cols="30" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="app-heading">বর্তমান ঠিকানা</div>
                        <div class="col-md-12">
                        </div>



                        <div class="form-group">
                            <label for="" class="labelColor">বিভাগ</label>

                            <select class='form-control' name="division" id="division" v-model="Pdivision" @change="getdistrictFun" disabled >
                            <option value="">বিভাগ নির্বাচন করুন</option>
                                <option v-for="div in getdivisions" :key="div.id" :value="div.id">{{ div.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_district"> -->
                        </div>

                        <div class="form-group">
                            <label for="" class="labelColor">জেলা</label>

                        <!-- <select   class='form-control' name="district" id="district" v-model="applicant_present_district" @change="getthanaFun" >
                            <option value="">জেলা নির্বাচন করুন</option>
                            <option v-for="dist in getdistricts" :key="dist.id" :value="dist.id">{{ dist.bn_name }}</option>
                        </select> -->

                            <input type="text" class="form-control" v-model="form.applicant_present_district" disabled>
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">উপজেলা/থানা</label>

                        <!-- <select  class='form-control' name="thana" id="thana" v-model="form.applicant_present_Upazila" @change="getuniounFun" >
                            <option value="">উপজেলা নির্বাচন করুন</option>
                            <option v-for="thana in getthanas" :key="thana.id" :value="thana.bn_name">{{ thana.bn_name }}</option>
                        </select> -->

                            <input type="text" class="form-control" v-model="form.applicant_present_Upazila" disabled>
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
                        <!-- <div class="col-md-12">
                            <input type="checkbox" id="checkbox" v-model="sameStatus" @change="sameAddress"> <label
                                for="checkbox"> বর্তমান ঠিকানা ও স্থায়ী ঠিকানা একই হলে</label>
                        </div> -->


                        <div class="form-group">
                            <label for="" class="labelColor">বিভাগ</label>

                            <select class='form-control' name="division" id="division" v-model="Perdivision" @change="getdistrictFunPer" disabled >
                            <option value="">বিভাগ নির্বাচন করুন</option>
                                <option v-for="div in getdivisionsPer" :key="div.id" :value="div.id">{{ div.bn_name }}</option>
                        </select>

                            <!-- <input type="text" class="form-control" v-model="form.applicant_present_district"> -->
                        </div>



                        <div class="form-group">
                            <label for="" class="labelColor">জেলা</label>
<!--
                            <select   class='form-control' name="district" id="district" v-model="applicant_permanent_district" @change="getthanaFunPer" >
                            <option value="">জেলা নির্বাচন করুন</option>
                            <option v-for="dist in getdistrictsPer" :key="dist.id" :value="dist.id">{{ dist.bn_name }}</option>
                        </select> -->

                            <input type="text" class="form-control" v-model="form.applicant_permanent_district" disabled>
                        </div>
                        <div class="form-group">
                            <label for="" class="labelColor">উপজেলা/থানা</label>
                            <!-- <select  class='form-control' name="thana" id="thana" v-model="form.applicant_permanent_Upazila" @change="getuniounFunPer" >
                                <option value="">উপজেলা নির্বাচন করুন</option>
                                <option v-for="thana in getthanasPer" :key="thana.id" :value="thana.bn_name">{{ thana.bn_name }}</option>
                            </select> -->
                            <input type="text" class="form-control" v-model="form.applicant_permanent_Upazila" disabled>
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
                <div class="app-heading"
                    v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'">
                    ওয়ারিশগণের
                    তালিকা
                </div>
                <table class="table"
                    v-if="sonodnamedata.enname == 'Certificate of Inheritance' || sonodnamedata.enname == 'Inheritance certificate'">
                    <tr>
                        <th>নাম</th>
                        <th>সম্পর্ক</th>
                        <th>জন্ম তারিখ</th>
                        <th>জাতীয় পরিচয়পত্র/জন্মনিবন্ধন নম্বর</th>
                        <th><button type="button" class="flex justify-start btn btn-info" @click="addMore()">যোগ করুন</button></th>
                    </tr>
                    <tr v-for="(successor, index) in successors" :key="index">
                        <input type="hidden" v-model="successor.w_id = index">
                        <th><input v-model="successor.w_name" placeholder="নাম" class="form-control" /></th>
                        <th>
                            <select v-model="successor.w_relation" class="form-control">
                                <option value="">সম্পর্ক</option>
                                <option>স্ত্রী</option>
                                <option>পুত্র</option>
                                <option>কন্যা</option>
                                <option>পিতা</option>
                                <option>মাতা</option>
                                <option>স্বামী</option>
                                <option>ভাই</option>
                                <option>বোন</option>
                                <option>নাতি</option>
                                <option>নাতনি</option>
                            </select>
                            <!-- <input v-model="successor.w_relation" placeholder="সম্পর্ক" class="form-control" /> -->
                        </th>
                        <th><input v-model="successor.w_age" type="date" placeholder="জন্ম তারিখ"
                                class="form-control" /></th>
                        <th><input v-model="successor.w_nid" type="text" @keydown="portKeydown($event)"
                                placeholder="জাতীয় পরিচয়পত্র নাম্বার/জন্মনিবন্ধন নাম্বার" class="form-control" /></th>
                        <th><button type="button" class="ml-2 btn btn-danger" @click="remove(index)"
                                v-show="index != 0">মুছন</button></th>
                    </tr>
                </table>


                <div class="row" v-if="this.$localStorage.getItem('position')=='super_admin'">

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">খাত</label>
                            <input type="text"  class="form-control" v-model="form.khat"/>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">currently_paid_money</label>
                            <input type="number"  class="form-control" v-model="form.currently_paid_money"/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">total_amount</label>
                            <input type="number"  class="form-control" v-model="form.total_amount"/>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">the_amount_of_money_in_words</label>
                            <input type="text"  class="form-control" v-model="form.the_amount_of_money_in_words"/>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">prottoyon</label>
                            <textarea  class="form-control" cols="30" rows="4" style="height:130px" v-model="form.prottoyon"></textarea>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">sec_prottoyon</label>
                            <textarea  class="form-control" cols="30" rows="4" style="height:130px" v-model="form.sec_prottoyon"></textarea>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">stutus</label>
                            <input type="text"  class="form-control" v-model="form.stutus"/>
                        </div>
                    </div>


                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="">sonod_Id</label>
                            <input type="text"  class="form-control" v-model="form.sonod_Id"/>
                        </div>
                    </div>


                </div>







                <div style="text-align:center">
                    <b-button type="submit" variant="primary">সাবমিট</b-button>
                </div>
                <!-- <b-button class="ml-2" @click="resetForm()">রিসেট</b-button> -->
            </div>
        </form>

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
            waitForPayment: false,
            submitLoad: false,
            sameStatus: '',
            sonodnamedata: {},
            SonodNamesOptions: {},
            form: {
                image: null,
                sonod_Id: '',
                unioun_name: null,
                year: null,
                ut_name: null,
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
            successors: [
                    {
                        w_id: "",
                        w_name: "",
                        w_relation: "",
                        w_age: "",
                        w_nid: "",
                    },
                ],
            getdivisions:{},
            getdistricts:{},
            getthanas:{},
            getuniouns:{},

            getdivisionsPer:{},
            getdistrictsPer:{},
            getthanasPer:{},
            getuniounsPer:{},
            Pdivision:7,
            Perdivision:7,
            applicant_present_district:'',
            applicant_permanent_district:'',
        };
    },

    methods: {


        async getdivisionFun(){
         var res = await this.callApi('get',`/api/getdivisions`,[]);
         this.getdivisions = res.data;
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
         var res = await this.callApi('get',`/api/getdivisions`,[]);
         this.getdivisionsPer = res.data;
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
            //   console.log($event.target.result);
        },
        portKeydown(e) {
            if (/^\+$/.test(e.key)) {
                e.preventDefault();
            }
        },
        addMore() {

            this.successors.push({
                w_name: "",
                w_relation: "",
                w_age: "",
                w_nid: "",
            });
            console.log(this.successors)
        },
        remove(index) {
            this.successors.splice(index, 1);
        },



        address(){
            this.getdivisionFun();

            // this.getdistrictFun();
            // this.getthanaFun();
            // this.getuniounFun();



this.getdivisionFunPer();
        },

        sameAddress() {
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

        async onSubmit() {
            this.form.successors = this.successors;
            var res = await this.callApi('post', '/api/sonod/update', this.form);
            Notification.customSuccess(`Your data has been Updated`);
            this.$router.push({ name: 'sonod', params: { name: this.sonodnamedata.enname.replaceAll(' ', '_'), type: 'new' } })


        },

      async getdata(id) {
            var res = await this.callApi('get', `/api/sonod/single/${id}?admin=true`, []);
        this.form = res.data.sonod
        this.sonodnamedata = res.data.sonodnamedata
        // console.log(res.data.sonod.successor_list)
        this.successors = JSON.parse(res.data.sonod.successor_list);

// console.log(this.successors);


        }
    },
    mounted() {
        this.getdata(this.$route.params.id)
        this.address();




        this.form.year = new Date().getFullYear();
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
</style>
