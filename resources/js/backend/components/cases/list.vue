<template>
    <div class="container mt-4">
      <h1 class="text-center mb-4">Village Court List</h1>
      <div class="table-responsive">
        <table class="table table-striped table-bordered">
          <thead class="table-light">
            <tr>
              <th>আবেদনকারীর নাম</th>
              <th>পিতা/স্বামীর নাম</th>
              <th>পূর্ণ ঠিকানা</th>
              <th>মোবাইল নম্বর</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="court in villageCourts" :key="court.id">
              <td>{{ court.applicant_name }}</td>
              <td>{{ court.applicant_father_husband_name }}</td>
              <td>{{ court.applicant_address }}</td>
              <td>{{ court.applicant_mobile }}</td>
              <td>
                <button class="btn btn-primary" @click="showDetails(court)">আবেদন দেখুন</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <pagination
        :current-page="currentPage"
        :total="totalItems"
        :per-page="perPage"
        @page-changed="fetchVillageCourts"
      />
      
      <modal v-if="form" @close="form = null" :isVisible="true">
      <template v-slot:header>
        <h3>{{ form.applicant_name }}</h3>
      </template>
      <template v-slot:body>
        <div class="card mt-4" v-if="form">
            <div class="card-header bg-success text-white">সিঙ্গেশনের তথ্য</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>জেলা:</strong> <span>{{ form.district }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>উপজেলা:</strong> <span>{{ form.upazila }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>মৌজা:</strong> <span>{{ form.mouza }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <strong>বিষয়:</strong> <span>{{ form.subject }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>মাধ্যম:</strong> <span>{{ form.medium }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>আরএস/বিএস:</strong> <span>{{ form.rs_bs }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <strong>খতিয়ান নম্বর:</strong> <span>{{ form.khatian_no }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>দাগ নম্বর:</strong> <span>{{ form.dag_no }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>আদিবাসী ভূমি:</strong> <span>{{ form.land_amount }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>পরিমাণের ধরন:</strong> <span>{{ form.amount_type }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>মোট খতিয়ান ভূমি:</strong> <span>{{ form.total_khatian_land }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>মোট ভূমির পরিমাণ:</strong> <span>{{ form.total_land_amount }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>মোট ভূমি কথায়:</strong> <span>{{ form.total_land_in_words }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4" v-if="form">
            <div class="card-header bg-success text-white">আবেদনকারীর নাম ও পূর্ণ ঠিকানা</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>আবেদনকারীর নাম:</strong> <span>{{ form.applicant_name }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>পিতা/স্বামীর নাম:</strong> <span>{{ form.applicant_father_husband_name }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>পূর্ণ ঠিকানা:</strong> <span>{{ form.applicant_address }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>ই-মেইল:</strong> <span>{{ form.applicant_email }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>মোবাইল নম্বর:</strong> <span>{{ form.applicant_mobile }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>ন্যাশনাল আইডি নম্বর:</strong> <span>{{ form.applicant_nid_no }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>পাসপোর্ট সাইজের ছবি:</strong> <img :src="form.applicant_photo" alt="Applicant Photo" class="img-fluid" />
                    </div>
                    <div class="col-md-6">
                        <strong>স্বাক্ষর:</strong> <img :src="form.applicant_signature" alt="Applicant Signature" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4" v-if="form">
            <div class="card-header bg-success text-white">প্রতিনিধি / বিধির তথ্য</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>প্রতিনিধির নাম:</strong> <span>{{ form.representative_name }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>পিতা/স্বামীর নাম:</strong> <span>{{ form.representative_father_husband_name }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>পূর্ণ ঠিকানা:</strong> <span>{{ form.representative_address }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>ই-মেইল:</strong> <span>{{ form.representative_email }}</span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>মোবাইল নম্বর:</strong> <span>{{ form.representative_mobile }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>বয়স:</strong> <span>{{ form.representative_age }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>সম্পর্ক:</strong> <span>{{ form.representative_relationship }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>পাসপোর্ট সাইজের ছবি:</strong> <img :src="form.representative_photo" alt="Representative Photo" class="img-fluid" />
                    </div>
                    <div class="col-md-6">
                        <strong>স্বাক্ষর:</strong> <img :src="form.representative_signature" alt="Representative Signature" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4" v-if="form">
            <div class="card-header bg-success text-white">কাগজপত্রের তথ্য সার্বিক তথ্য</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <strong>কাগজপত্রের ফাইল:</strong> <a :href="form.document" target="_blank">View Document</a>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <strong>মিসকেসের ধরন:</strong> <span>{{ form.miscaseType }}</span>
                    </div>
                    <div class="col-md-12">
                        <strong>স্ট্যাটাস:</strong> <span>{{ form.status }}</span>
                    </div>
                </div>
            </div>
        </div>
      </template>
    </modal>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import Pagination from './Pagination.vue'; // Adjust path as necessary
  import Modal from './Modal.vue'; // Adjust path as necessary
  
  export default {
    components: { Pagination, Modal },
    data() {
      return {
        villageCourts: [],
        currentPage: 1,
        perPage: 10,
        totalItems: 0,
        form: null,
      };
    },
    methods: {
      fetchVillageCourts(page = 1) {
        this.currentPage = page;
        axios.get(`/api/village-courts?page=${this.currentPage}&perPage=${this.perPage}`)
          .then(response => {
            this.villageCourts = response.data.data;
            this.totalItems = response.data.total;
          });
      },
      showDetails(court) {
        this.form = court;
      },
    },
    mounted() {
      this.fetchVillageCourts();
    },
  };
  </script>
  
  <style scoped>
  .table th, .table td {
    text-align: center;
  }
  </style>
  