<template>
    <div>
        <Applicationform v-if="!getunionInfos.nidService"/>
        <ApplicationformwitnNid v-else/>
    </div>
</template>

<script>

export default {

}
</script>
