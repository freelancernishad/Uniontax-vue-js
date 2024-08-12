<template>
    <div>
        <Form_without_nid  v-if="nidService==0"/>
        <Form_with_nid_image_check  v-else-if="nidService==2"/>
        <Form_with_nid :nid_balance="nidServicebalace" @check_nid_balace="checkNidBalace" v-else/>
    </div>
</template>

<script>

export default {
created() {
    this.checkNidService();
},
    data() {
        return {
            nidService:0,
            nidServicebalace:0,


        }
    },
    watch: {
        '$route': {
            handler(newValue, oldValue) {
                this.checkNidService();
            },
            deep: true
        }
    },
    methods: {

        async checkNidBalace(unioun_name){
            var unioncheck = await this.callApi('post',`/api/nid/check/${unioun_name}`,[]);

            if(unioncheck.data==404){
                this.nidServicebalace = 0
            }else{
                this.nidServicebalace = unioncheck.data.nidService

            }
        },


        async checkNidService(){
            var res = await this.callApi('post',`/api/nid/service/${this.getUnion.subdomainget}`,[])
            this.nidService = res.data.nidServicestatus;
            this.nidServicebalace = res.data.nidServicebalace;
        }
    },

}
</script>
