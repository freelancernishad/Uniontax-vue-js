<template>
    <div>
        <Applicationform  v-if="nidService==0"/>
        <ApplicationformwitnNid v-else/>
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
    watch: {
        '$route': {
            handler(newValue, oldValue) {
                this.checkNidService();
            },
            deep: true
        }
    },
    methods: {
        async checkNidService(){
            var res = await this.callApi('post',`/api/nid/service/${this.getUnion.subdomainget}`,[])
            this.nidService = res.data;
        }
    },

}
</script>
