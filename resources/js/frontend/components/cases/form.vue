<template>
    <div>
        <div class="container mt-5">
            <form @submit.prevent="submitForm">
                <h3 class="text-center mb-4">সিধেশনের আবেদন ফরম (লাল চিহ্নিত স্থানগুলো অবশ্যই পূরণীয়)</h3>

                <div class="form-group">
                    <label class="form-label">মিসকেসের ধরন</label>
                    <div>
                        <input type="radio" id="land" value="জমি সংক্রান্ত" v-model="form.miscaseType">
                        <label for="land">জমি সংক্রান্ত</label>
                        <input type="radio" id="other" value="অন্যান্য" v-model="form.miscaseType">
                        <label for="other">অন্যান্য</label>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5>সিধেশনের তথ্য</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="form-label">জেলা</label>
                                <input type="text" class="form-control" v-model="form.district" placeholder="জেলা">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">উপজেলা</label>
                                <input type="text" class="form-control" v-model="form.upazila" placeholder="উপজেলা">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">মৌজা</label>
                                <input type="text" class="form-control" v-model="form.mouza" placeholder="মৌজা">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">বিষয়</label>
                            <input type="text" class="form-control" v-model="form.subject" placeholder="বিষয়">
                        </div>
                        <div class="form-group">
                            <label class="form-label">মাধ্যম</label>
                            <textarea class="form-control" v-model="form.medium" rows="3" placeholder="আবেদনকৃত মাধ্যম"></textarea>
                        </div>
                    </div>
                </div>

                <div v-if="form.miscaseType === 'জমি সংক্রান্ত'" class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5>আবেদিত জমির তথ্য</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="form-label">আর এস/বি এস</label>
                                <input type="text" class="form-control" v-model="form.rs_bs" placeholder="আর এস/বি এস">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">খতিয়ান নং</label>
                                <input type="text" class="form-control" v-model="form.khatian_no" placeholder="খতিয়ান নং">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">দাগ নং</label>
                                <input type="text" class="form-control" v-model="form.dag_no" placeholder="দাগ নং">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="form-label">জমির পরিমাণ</label>
                                <input type="text" class="form-control" v-model="form.land_amount" placeholder="জমির পরিমাণ">
                            </div>
                            <div class="form-group col-md-1">
                                <label class="form-label">পরিমাণ ধরণ</label>
                                <select v-model="form.amount_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="একর">একর</option>
                                    <option value="শতক">শতক</option>
                                    <option value="ওযুতাংশ">ওযুতাংশ</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="form-label">খতিয়ানে মোট জমির পরিমান (একর)</label>
                                <input type="text" class="form-control" v-model="form.total_khatian_land" placeholder="মোট তফসিল পরিমাণ">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">মোট জমির পরিমাণ (একর)</label>
                                <input type="text" class="form-control" v-model="form.total_land_amount" placeholder="মোট জমির পরিমাণ (একর)">
                            </div>
                            <div class="form-group col-md-4">
                                <label class="form-label">মোট জমির পরিমাণ (কথায়)</label>
                                <input type="text" class="form-control" v-model="form.total_land_in_words" placeholder="মোট জমির পরিমাণ (কথায়)">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5>আবেদনকারীর নাম ও পূর্ণ ঠিকানা</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="form-label">আবেদনকারীর নাম</label>
                                <input type="text" class="form-control" v-model="form.applicant_name" placeholder="আবেদনকারীর নাম">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">পিতা/স্বামীর নাম</label>
                                <input type="text" class="form-control" v-model="form.applicant_father_husband_name" placeholder="পিতা/স্বামীর নাম">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">পিতা/স্বামীর পূর্ণ ঠিকানা</label>
                                <input type="text" class="form-control" v-model="form.applicant_address" placeholder="পিতা/স্বামীর পূর্ণ ঠিকানা">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">মোবাইল নাম্বার</label>
                                <input type="text" class="form-control" v-model="form.applicant_mobile" placeholder="মোবাইল নাম্বার">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="form-label">ই-মেইল</label>
                                <input type="text" class="form-control" v-model="form.applicant_email" placeholder="ই-মেইল">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">জাতীয় পরিচয় পত্র নম্বর</label>
                                <input type="text" class="form-control" v-model="form.applicant_nid_no" placeholder="জাতীয় পরিচয় পত্র নম্বর">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">পাসপোর্ট সাইজের ছবি</label>
                                <input type="file" class="form-control-file" @change="handleFileUpload('applicant_photo')">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">স্বাক্ষর</label>
                                <input type="file" class="form-control-file" @change="handleFileUpload('applicant_signature')">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5>প্রতিনিধি / বিবাদীর তথ্য</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="form-label">প্রতিনিধির নাম</label>
                                <input type="text" class="form-control" v-model="form.representative_name" placeholder="প্রতিনিধির নাম">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">পিতা/স্বামীর নাম</label>
                                <input type="text" class="form-control" v-model="form.representative_father_husband_name" placeholder="পিতা/স্বামীর নাম">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">পিতা/স্বামীর পূর্ণ ঠিকানা</label>
                                <input type="text" class="form-control" v-model="form.representative_address" placeholder="পিতা/স্বামীর পূর্ণ ঠিকানা">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">মোবাইল নাম্বার</label>
                                <input type="text" class="form-control" v-model="form.representative_mobile" placeholder="মোবাইল নাম্বার">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="form-label">ই-মেইল</label>
                                <input type="text" class="form-control" v-model="form.representative_email" placeholder="ই-মেইল">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">বয়স</label>
                                <input type="text" class="form-control" v-model="form.representative_age" placeholder="বয়স">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">সম্পর্ক</label>
                                <input type="text" class="form-control" v-model="form.representative_relationship" placeholder="সম্পর্ক">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">পাসপোর্ট সাইজের ছবি</label>
                                <input type="file" class="form-control-file" @change="handleFileUpload('representative_photo')">
                            </div>
                            <div class="form-group col-md-3">
                                <label class="form-label">স্বাক্ষর</label>
                                <input type="file" class="form-control-file" @change="handleFileUpload('representative_signature')">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-success text-white">
                        <h5>কাগজপত্রের স্বল সার্বিক তথ্য</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label">কাগজপত্রের স্বল সার্বিক তথ্য</label>
                            <input type="file" class="form-control-file" @change="handleFileUpload('document')">
                        </div>
                        <div class="form-group">
                            <label class="form-label">নির্দেশাবলী</label>
                            <div class="instruction-text">
                                ১। আবেদনকারীর সাথে পরিচয়পত্রের কাগজপত্র সংযুক্ত করতে হবে।<br>
                                ২। অনুগ্রহ করে ফাইলটি ২৫ মেগাবাইট (MB) এর কম হতে হবে।<br>
                                ৩। ফাইল কম্প্রেস করার জন্য নিচের লিঙ্কগুলো ব্যবহার করুন:<br>
                                &emsp;- https://www.sejda.com/compress-pdf<br>
                                &emsp;- https://www.pdf2go.com/resize-pdf
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">জমা দিন</button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            form: {
                miscaseType: '',
                district: '',
                upazila: '',
                mouza: '',
                subject: '',
                medium: '',
                rs_bs: '',
                khatian_no: '',
                dag_no: '',
                land_amount: '',
                amount_type: '',
                total_khatian_land: '',
                total_land_amount: '',
                total_land_in_words: '',
                applicant_name: '',
                applicant_father_husband_name: '',
                applicant_address: '',
                applicant_mobile: '',
                applicant_email: '',
                applicant_nid_no: '',
                applicant_photo: '',
                applicant_signature: '',
                representative_name: '',
                representative_father_husband_name: '',
                representative_address: '',
                representative_mobile: '',
                representative_email: '',
                representative_age: '',
                representative_relationship: '',
                representative_photo: '',
                representative_signature: '',
                document: '',
            },
            files: {
                applicant_photo: null,
                applicant_signature: null,
                representative_photo: null,
                representative_signature: null,
                document: null,
            },
        };
    },
    methods: {
        handleFileUpload(field) {
            this.files[field] = event.target.files[0];
        },
        async submitForm() {
            let formData = new FormData();

            for (let key in this.form) {
                formData.append(key, this.form[key]);
            }

            for (let key in this.files) {
                if (this.files[key]) {
                    formData.append(key, this.files[key]);
                }
            }

            try {
                let response = await axios.post('/api/village-courts', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                });
                alert('Form submitted successfully');
            } catch (error) {
                console.error(error);
                alert('There was an error submitting the form');
            }
        }
    }
};
</script>

<style scoped>
.instruction-text {
    font-size: 0.9em;
    color: #555;
}
</style>
