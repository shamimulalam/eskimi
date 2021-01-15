<template>
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-12">
                <div class="links text-right">

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-6">
                <router-view></router-view>
            </div>
            <div class="col-md-3">

            </div>
        </div>
        <footer class="fixed-bottom">
            <div class="row">
                <div class="col text-left" style="margin-left: 15px">
                    All rights reserved by Eskimi DSP
                </div>
            </div>
        </footer>
        <FlashMessage></FlashMessage>
    </div>
</template>

<script>
export default {
name: "mainApp"
}
</script>

<style scoped>

</style>
