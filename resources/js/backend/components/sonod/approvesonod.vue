<template>
    <div>
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40"
            objectbg="#999793" opacity="80" name="circular"></loader>

    <form v-on:submit.prevent="formsubmit">
        <div class="row">
            <div class="col-md-12" v-if="Details.sonod_name == 'বিবিধ প্রত্যয়নপত্র'">
                <h5>আবেদনকৃত প্রত্যয়নের বিবরণ</h5>
                <p>{{ sonodlist.prottoyon }}</p>
            </div>
            <div class="col-md-12" v-if="Details.sonod_name == 'বিবিধ প্রত্যয়নপত্র'">
                <div class="form-group">
                    <label for="amountab">প্রত্যয়ন প্রদানের বিবরণ </label>
                    <textarea v-model="form.sec_prottoyon" class="form-control"
                        style="height:100px;resize:none" :readonly="readonly"></textarea>
                </div>
            </div>
            <div class="col-md-6" v-if="sonodlist.payment_status == 'Unpaid'">
                <div class="form-group">
                    <label for="khat">ফি আদায়ের খাত </label>
                    <select v-model="form.khat" id="khat" class="form-control" required>
                        <option value="বসতবাড়ীর বাৎসরিক মূল্যের উপর কর ">বসতবাড়ীর বাৎসরিক মূল্যের উপর কর </option>
                        <option value="ব্যবসা/পেশা/জীবিকার উপর কর">ব্যবসা/পেশা/জীবিকার উপর কর</option>
                        <option value="সিনেমা/যাত্রা/থিয়েটার/ অন্যান্য বিনোদনমূলক অনুষ্ঠানের উপর কর">
                            সিনেমা/যাত্রা/থিয়েটার/ অন্যান্য বিনোদনমূলক অনুষ্ঠানের উপর কর</option>
                        <option value="লাইসেন্স ও পারমিট ফি">লাইসেন্স ও পারমিট ফি</option>
                        <option value="হাট-বাজার/ফেরীঘাট/ জলমহাল/অন্যান্য ইজারা বাবদ">হাট-বাজার/ফেরীঘাট/ জলমহাল/অন্যান্য
                            ইজারা বাবদ</option>
                        <option value="ভূমি/ ইমারত ভাড়া/ রপ্তানী কর">ভূমি/ ইমারত ভাড়া/ রপ্তানী কর</option>
                        <option value="নিলামে বিক্রয়লব্ধ আয়">নিলামে বিক্রয়লব্ধ আয়</option>
                        <option value="জরিমানা (যদি থাকে)">জরিমানা (যদি থাকে)</option>
                        <option value="অন্যান্য দাবী আদায় (যদি থাকে)">অন্যান্য দাবী আদায় (যদি থাকে)</option>
                        <option value="পশু জবেহ ফিস">পশু জবেহ ফিস</option>
                        <option value="যানবাহন ফিস">যানবাহন ফিস</option>
                        <option value="ওয়ারিশান সনদ ফিস">ওয়ারিশান সনদ ফিস</option>
                        <option value="বিবিধ সনদপত্র/প্রত্যয়ন পত্র ফিস">বিবিধ সনদপত্র/প্রত্যয়ন পত্র ফিস</option>
                        <option value="বিবিধ ফিস">বিবিধ ফিস</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6" v-if="sonodlist.payment_status == 'Unpaid'">
                <div class="form-group">
                    <label for="amountab">বিগত বছরের টাকা (অংকে) </label>
                    <input id="amountab" class="form-control" @keyup="totalAmount" type="number"
                        v-model="form.last_years_money" required>
                </div>
            </div>
            <div class="col-md-6" v-if="sonodlist.payment_status == 'Unpaid'">
                <div class="form-group">
                    <label for="amountabb">বর্তমানে পরিশোধকৃত টাকা (অংকে) </label>
                    <input id="amountabb" class="form-control" @keyup="totalAmount"  type="number"
                        v-model="form.currently_paid_money" required>
                </div>
            </div>
            <div class="col-md-6" v-if="sonodlist.payment_status == 'Unpaid'">
                <div class="form-group">
                    <label for="amounta">মোট (অংকে) </label>
                    <input id="amounta" class="form-control"  type="number" v-model="form.amounta" required>
                </div>
            </div>
            <div class="col-md-12">
                <input id="submit" class="btn btn-info" type="submit" value="অনুমোদন করুন">
            </div>
        </div>
    </form>
</div>
</template>
<script>
export default {
    props: {
        ApproveData: {
            type: String,
            default: 'sec_approved'
        },
        SonodId: {
            type: String,
            default: '0'
        },
        'Details': {
            type: Object,
            default: {}
        },
    },
    data() {

        return {
            preLooding: false,
            readonly: true,
            prottoyon: true,
            sonodlist: {},
            uniun: {},
            form: {
                sec_prottoyon: '',
                khat: '',
                last_years_money: '0',
                currently_paid_money: '0',
                amounta: '0',
            }
        }
    },
    methods: {
        totalAmount() {
            var amountab, amountabb;
            amountab = parseInt(this.form.last_years_money);
            amountabb = parseInt(this.form.currently_paid_money);
            this.form.amounta = amountab + amountabb;
        },
        async formsubmit() {
            this.preLooding = true

            this.form.approeDatav = this.ApproveData;
            var res = await this.callApi('post', `/api/sonod/sec/approve/${this.SonodId}`, this.form);
            this.$root.$emit('bv::hide::modal', 'action-modal')
            this.preLooding = false

            this.$emit('event-name')
            Notification.customSuccess(`Your data has been Approved`);
        },
        async Getsonod() {
            // var res = await this.callApi('get',`/api/sonod/single/${this.SonodId}`,[])
            // this.sonodlist = res.data;
            this.sonodlist = this.Details;
        },
        //  getunionInfo(){
        //     var unionname = undefined;
        //          setTimeout(() => {
        //             unionname = this.getUsers.unioun
        //         // var res =  this.callApi('post',`/api/union/info?union=${unionname}`,[]);
        //             axios.post(`/api/union/info?union=${unionname}`)
        //             .then((res)=>{
        //                 // console.log(unionname);
        //                 // console.log(res);
        //                 this.uniun = res.data
        //             })
        //         }, 2000);
        //     },
        sonodText(name) {
        },

        age(dateOf = '2001-08-25') {
            var dateofbirth = dateOf.split("-");
            var y1 = dateofbirth[0];
            var m1 = dateofbirth[1];
            var d1 = dateofbirth[2];
            var date = new Date();
            var d2 = date.getDate();
            var m2 = 1 + date.getMonth();
            var y2 = date.getFullYear();
            var month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            if (d1 > d2) {
                d2 = d2 + month[m2 - 1];
                m2 = m2 - 1;
            }
            if (m1 > m2) {
                m2 = m2 + 12;
                y2 = y2 - 1;
            }
            var d = d2 - d1;
            var m = m2 - m1;
            var y = y2 - y1;
            return y + ' বছর ' + m + ' মাস ' + d + ' দিন ';
        },

    },
    mounted() {
        this.Getsonod();
        // this.getunionInfo();
        if (this.Details.sonod_name == 'নাগরিকত্ব সনদ') {
            this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে কোন রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তাই তাকে ${this.Details.sonod_name} প্রদান করা হলো ।`;
        } else if (this.Details.sonod_name == 'ট্রেড লাইসেন্স') {
             this.readonly = false
        } else if (this.Details.sonod_name == 'ওয়ারিশান সনদ') {
             this.readonly = true
        } else if (this.Details.sonod_name == 'উত্তরাধিকারী সনদ') {
             this.readonly = true
        } else if (this.Details.sonod_name == 'বিবিধ প্রত্যয়নপত্র') {
             this.readonly = false
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। ${this.sonodlist.prottoyon}`;


        } else if (this.Details.sonod_name == 'চারিত্রিক সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তার স্বভাব চরিত্র ভালো এবং উন্নত চরিত্রের অধিকারী।ইহা আমার জানামতে সত্য ।`;
        } else if (this.Details.sonod_name == 'ভূমিহীন সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই। আমার জানা মতে তার থাকার মতো এবং চাষাবাদ করার মত নিজস্ব কোনো জমি নেই । তিনি একজন ভূমিহীন মানুষ তাই তাকে ${this.Details.sonod_name} প্রদান করা হলো ।`;
        } else if (this.Details.sonod_name == 'পারবারিক সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। আমার জানা মতে সে ${this.Details.family_name} বংশের একজন উত্তরাধিকারী । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'অবিবাহিত সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। আমার জানামতে সে একজন অবিবাহিত পুরুষ । বিগত সময়ে তার কোন বিবাহ ছিলনা বা বিবাহ করেনি । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই ।`;
        } else if (this.Details.sonod_name == 'পুনঃ বিবাহ না হওয়া সনদ') {
             this.readonly = true



            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে একজন বিবাহিত ${this.Details.applicant_gender} এবং তাহার কোনো পুনঃ বিবাহ হয়নি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'বার্ষিক আয়ের প্রত্যয়ন') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তার বার্ষিক আয় ${this.Details.Annual_income}/=  হাজার টাকা । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'একই নামের প্রত্যয়ন') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। প্রকাশ থাকে যে "${this.Details.applicant_name}" ও "${this.Details.applicant_second_name}" একই ব্যক্তি । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'অনুমতি পত্র') {
             this.readonly = false
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তাকে ${this.Details.Subject_to_permission} অনুমতি দেওয়া হল ।`;
        } else if (this.Details.sonod_name == 'প্রতিবন্ধী সনদপত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। আমার জানামতে সে একজন ${this.Details.disabled} প্রতিবন্ধী । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'অনাপত্তি সনদপত্র') {
             this.readonly = false
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সেই বর্তমানে প্রোগ্রামার পদে নিযুক্ত আছেন । তার পাসপোর্ট আবেদনের প্রয়োজনীয় কাগজপত্র এর সঙ্গে পেরন করা হলো  । ইতিপূর্বে পুলিশ ভেরিফিকেশন সম্পন্ন হয়েছে  । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'অগভীর নলকূপ স্থাপন') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তার বসতবাড়িতে বর্তমানে কোন টিউবওয়েল নেই । তাই তাকে অগভীর নলকূপ বসানোর অনুমতি দেওয়া হল ।`;
        } else if (this.Details.sonod_name == 'অবকাঠামো নির্মাণের অনুমতি পত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। বর্তমানে তার থাকার জন্য কোনো অবকাঠামো ও বসতবাড়ি নেই । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।  তাই তাকে অবকাঠামো নির্মাণের অনুমতি প্রদান করা হল ।`;
        } else if (this.Details.sonod_name == 'অভিভাবকের আয়ের সনদপত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তার বাবার বাৎসরিক আয় ${this.Details.Annual_income}/= হাজার টাকা । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'আনুমানিক বয়স প্রত্যয়ন পত্র') {
             this.readonly = true

            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তার আনুমানিক বয়স ${this.age(this.Details.applicant_date_of_birth)} । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'প্রত্যয়নপত্র') {
             this.readonly = false
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তাকে ${this.Details.The_subject_of_the_certificate} অনুমতি দেওয়া হল ।`;
        } else if (this.Details.sonod_name == 'ভোটার এলাকা স্থানান্তর অনাপত্তি পত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি।  বর্তমানে তার স্থায়ী কমস্থল স্থানান্তরিত হয়েছে । তার স্থায়ী কর্মস্থান এখন ${this.Details.Name_of_the_transferred_area} । তার দৈনন্দিন সকল কার্যক্রম সুন্দরভাবে পরিচালনার জন্য ভোটার এলাকা পরিবর্তন করা খুবই জরুরী। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;


        } else if (this.Details.sonod_name == 'জাতীয় পরিচয়পত্র সংশোধন প্রত্যয়ন') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তার জাতীয় পরিচয় পত্র কিছু তথ্য অনাকাঙ্ক্ষিত ভুল হয়েছে এটি সংশোধন করা অতীব জরুরী । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'নিঃসন্তান প্রত্যয়ন') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। আমার জানামতে সে বিবাহিত কিন্তু তার কোন সন্তান নেই । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই। `;
        } else if (this.Details.sonod_name == 'ভোটার তালিকায় নাম অন্তর্ভুক্ত না হওয়ার প্রত্যয়ন') {
             this.readonly = false
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে অসুস্থ থাকার কারণে ভোটার তালিকায় তার নাম অন্তর্ভুক্তি করন করা হয়নি । তার নামটি ভোটার তালিকায় অন্তর্ভুক্ত করার জন্য অনুরোধ করা হলো । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'সম্প্রদায় সনদপত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সম্প্রদায় নিয়ে লেখাগুলো এখানে হবে । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'আর্থিক অস্বচ্ছলতার সনদপত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে আমার ইউনিয়নের স্থায়ী বাসিন্দা এবং সে আর্থিকভাবে খুবি অসচ্ছল । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'জীবিত ব্যক্তির ওয়ারিশ সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে কোন রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তাই তাকে ${this.Details.sonod_name} প্রদান করা হলো ।`;
        } else if (this.Details.sonod_name == 'এতিম সনদপত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। আমার জানা মতে তার বাবা-মা জীবিত নেই, সে একজন এতিম । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'জীবিত সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। তিনি জীবিত এবং সুস্থ আছেন । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'রিনিউ সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।  তাকে সনদ রিনিউ করার জন্য অনুমোদন দেওয়া হল ।`;
        } else if (this.Details.sonod_name == 'বসতবাড়ি হোল্ডিং নিবন্ধন সনদ') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে তার বসত বাড়ির জন্য হোল্ডিং নাম্বার নিয়েছে । সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'রোহিঙ্গা নয় মর্মে প্রত্যয়ন পত্র') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে রোহিঙ্গা নয়, সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে রাষ্ট্রদ্রোহিতার অভিযোগ নেই।`;
        } else if (this.Details.sonod_name == 'ইউনিয়ন পরিষদ নাগরিক লিস্ট') {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে কোন রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তাই তাকে ${this.Details.sonod_name} প্রদান করা হলো ।`;
        } else {
             this.readonly = true
            this.form.sec_prottoyon = `জনাব ${this.Details.applicant_name} কে আমি ব্যক্তিগতভাবে চিনি ও জানি। সে জন্মসূত্রে বাংলাদেশের নাগরিক এবং অত্র ইউনিয়ন পরিষদের স্থায়ী বাসিন্দা। আমার জানামতে তার বিরুদ্ধে কোন রাষ্ট্রদ্রোহিতার অভিযোগ নেই। তাই তাকে ${this.Details.sonod_name} প্রদান করা হলো ।`;
        }
    }
}
</script>
