<template>
    <div>
        <loader v-if="preLooding" object="#ff9633" color1="#ffffff" color2="#17fd3d" size="5" speed="2" bg="#343a40" objectbg="#999793" opacity="80" name="circular"></loader>
<div class="breadcrumbs-area">
    <h3>Sonod fees</h3>
    <ul>
        <li>
            <router-link :to="{name:'Dashboard'}">Home</router-link>
        </li>
        <li>Sonod fees</li>
    </ul>
</div>

    <form @submit.stop.prevent="onSubmit">


        <table width="100%" class="table">
            <thead>
                <tr>
                    <th>সনদের নাম</th>
                    <th>সনদের ফি</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="(row,index) in rows" :key="index">
                    <th>{{ row.bnname }}</th>
                    <th><input type="number" v-model="form.sonodfee[row.service_id]" class="form-control"  placeholder="" aria-describedby="helpId"></th>
                </tr>
            </tbody>

        </table>









        <div class="col-md-12">
    <button class="btn btn-info" type="submit">Submit</button>
</div>
    </form>


    </div>
</template>

<script>
export default {
    data(){
        return {
            rows:{},
            form:{
                sonodfee:{},
                unionname:'',
            },
            preLooding:true,
        }
    },
    methods:{



        async getsonods(){
           var id =  this.$route.params.id;
            var res = await this.callApi('get', `/api/get/sonodname/list`, []);
            this.rows = res.data;
        },
        async sonodFees(){
            var res = await this.callApi('get',`/api/sonod/fee/list?unioun=${localStorage.getItem('unioun')}`,[])
            this.form.sonodfee = res.data
            this.preLooding = false

        },
        async onSubmit() {
            this.preLooding = true
            var res = await this.callApi('post', '/api/sonod/fee/setup', this.form);
            //  this.$router.push({ name: 'sonodFees'})
            Notification.customSuccess('Sonod Fee Update Success');
            this.preLooding = false
            this.getsonods();
            this.sonodFees();


        }
    },
    mounted(){

            this.getsonods();
            this.sonodFees();
            this.form.unionname = localStorage.getItem('unioun');
        }
}
</script>
