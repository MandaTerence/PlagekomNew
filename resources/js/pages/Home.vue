<template>
<div class="page-inner">
    <div class="row justify-content-center" >
        <div class="card col-md-6">
            <div class="card-body">
                bienvenu
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            //
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    created() {
    },
    methods: {}
}
</script>