<template>
    <div>

    <div class="container mt-5">



        <div class="text-right">
            <a :href="'/pdf/sder/download/'+$route.params.tender_id" class="btn btn-info" target="_blank">Pdf Download</a>
        </div>

        <div class="table-responsive">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">দরপত্র নম্বর</th>
                <th scope="col">নাম</th>
                <th scope="col">পিতার নাম</th>
                <th scope="col">ঠিকানা</th>
                <th scope="col">মোবাইল</th>
                <th scope="col">দরের পরিমাণ</th>
                <th scope="col">কথায়</th>
                <th scope="col">জামানতের পরিমাণ</th>
                <th scope="col">files</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="application in applications" :key="application.id">
                    <th scope="row">{{ application.dorId }}</th>
                    <td>{{ application.applicant_orgName }}</td>
                    <td>{{ application.applicant_org_fatherName }}</td>
                    <td>গ্রাম- {{ application.vill }}, ডাকঘর- {{ application.postoffice }}, উপজেলা- {{ application.thana }}, জেলা- {{ application.distric }}</td>
                    <td>{{ application.mobile }}</td>
                    <td>{{ application.DorAmount }}</td>
                    <td>{{ application.DorAmountText }}</td>
                    <td>{{ application.depositAmount }}</td>
                    <td>
                        <button class="btn btn-info" @click="showImage(application)">Files</button>
                    </td>

                </tr>


            </tbody>
            </table>
        </div>

    </div>

    <div class="overlay" v-if="popup">
        <div  class="row fixed">
            <div class="col-md-12 text-right" ><span style="padding: 7px 3px;background: red;color: white;border-radius: 7px;cursor: pointer;" @click="closePoup">Close</span></div>
            <div class="col-md-12">
                <h2>ব্যাংক ড্রাফট/পে-অর্ডারের ছবি</h2>
                <img :src="poupitems.bank_draft_image"  alt="">
                <a :href="poupitems.bank_draft_image" target="_blank" class="btn btn-info">Download</a>
            </div>
            <div class="col-md-12">
                <h2>দরপত্র সিডিউলের ছবি</h2>
                <img :src="poupitems.deposit_details"  alt="">
                <a :href="poupitems.deposit_details" target="_blank" class="btn btn-info">Download</a>
            </div>
        </div>
    </div>





    </div>




</template>
<script>
export default {
    name: "home",
    created() {
        // if (!User.loggedIn()) {
        //     this.$router.push({ name: "/" });
        // }
    },

    data() {
        return {
            applications:{},
            popup:false,
            poupitems:{},
        };
    },
    mounted() {
      this.getApplication();
    },
    methods: {

        getApplication() {
            var tender_id = this.$route.params.tender_id
            axios
                .get(`/api/get/all/aplications/${tender_id}`)
                .then(({ data }) => (this.applications = data))
                .catch();
        },
        showImage(items){
            this.popup = true;
            this.poupitems = items
        },
        closePoup(){
            this.popup = false;
            this.poupitems = {}
        }
    }
};





</script>
<style lang="css" scoped>
#img_size {
    width: 40px;
}
.row.fixed {
    background: #e5e5e5;
    padding: 13px 5px;
    position: fixed;
    width: 75%;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    overflow: auto;
    height: 80vh;
}
.overlay {
    width: 100%;
    height: 100vh;
    position: fixed;
    background: #000000a6;
    top: 0;
    left: 0;
    z-index: 9999;
}
</style>
