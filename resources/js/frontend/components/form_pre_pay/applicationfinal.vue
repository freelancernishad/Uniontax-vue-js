<template>
    <div>

        <Applicationformprepay  v-if="nidService==0"/>
        <ApplicationformwitnNidprepay v-else/> 





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
          
        }
    },

    methods: {


        async checkNidService(){
            var res = await this.callApi('post',`/api/nid/service/${this.getUnion.subdomainget}`,[])
            this.nidService = res.data;
        },

   


         },
    mounted() {

    },

}
</script>
