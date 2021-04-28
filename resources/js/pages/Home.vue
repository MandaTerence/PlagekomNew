<template>
<div class="page-inner">
    <div>
        <h1>Bienvenue sur plagekom</h1>
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