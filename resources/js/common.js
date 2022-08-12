import { mapGetters } from 'vuex'
export default {
    data(){
        return {

        }
    },

    methods: {
        async callApi(method, url, dataObj ){
            try {
              return await axios({
                    method: method,
                    url: url,
                    data: dataObj
                });
            } catch (e) {
                return e.response
            }
        },


  


        checkUserPermission(key){
            if(!this.userPermission) return true
            let isPermitted = false;
            for(let d of this.userPermission){
                if(this.$route.name==d.name){
                    if(d[key]){
                        isPermitted = true
                        break;
                    }else{
                        break
                    }
                }

            }
            return isPermitted
            // return this.$route.name;
        }

    },
    computed: {



        ...mapGetters({
            'SonodName' : 'getUpdateSonodName',
            'SonodNames' : 'getUpdateSonodNames',
            'Users' : 'getUpdateUser',
            // 'userPermission' : 'getUserPermission',
            // 'getUserRoles' : 'getUserRoles',
            'getUnions' : 'getUnions',
            'getType' : 'getType',
            'getUnion' : 'getUnion',
            'getunionInfos' : 'getunionInfos',
            'getvatTax' : 'getvatTax',
        }),

        getUsers(){
            return this.$store.getters.getUpdateUser;

        },

        // isReadPermitted(){
        //     return this.checkUserPermission('read')
        //  },
        //  isWritePermitted(){
        //      return this.checkUserPermission('write')
        //  },
        //  isUpdatePermitted(){
        //      return this.checkUserPermission('update')
        //  },
        //  isDeletePermitted(){
        //      return this.checkUserPermission('delete')
        //  },

    },




}
