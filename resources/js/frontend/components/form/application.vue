<template>
    <div>
        <Applicationform v-if="getunionInfos.nidService==0"/>
        <ApplicationformwitnNid v-else/>
    </div>
</template>

<script>

export default {

}
</script>
