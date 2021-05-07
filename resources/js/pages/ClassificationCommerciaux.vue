<template>
<div class="panel-header bg-secondary-gradient" >
    <div class="page-inner py-4">
        <div class="row text-white pb-2 fw-bold">
            <h1>Classification Commerciaux</h1>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="card">
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "ClassificationCommerciaux",
    data() {
        return {
            
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
    methods: {
        
    }
}
</script>