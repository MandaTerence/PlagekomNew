<template>
<div class="page-inner justify-content-center">
    <div class="container">
        <div class="row justify-content-center" style="margin-top:100px">
            <div class="col-md-6">
                <div class="alert alert-danger" role="alert" v-if="error !== null">
                    {{ error }}
                </div>
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <div id="user_ico" class="d-flex justify-content-center align-items-center" >
                            <span>Pk</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="form-group row justify-content-center">
                                <div class="input-group input-login col-md-6 justify-content-center">
                                    <i class="fa fa-user"></i>
                                    <input id="qsdqs" type="text" class="form-control input-pill" v-model="matricule" placeholder="Matricule"
                                    autofocus autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="input-group input-password col-md-6 justify-content-center">
                                 
                                        <i class="fa fa-lock"></i>

                                    <input id="password" type="password" class="form-control input-pill" v-model="password" placeholder="mot de passe"
                                    autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-secondary" style="cursor: pointer; border-radius: 20px;" @click="handleSubmit">
                                        se connecter
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            matricule: "",
            password: "",
            error: null
        }
    },
    methods: {
        handleSubmit(e) {
            e.preventDefault()
            if (this.password.length > 0) {
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    this.$axios.post('api/login', {
                        matricule: this.matricule,
                        password: this.password
                    })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            this.$router.go('/dashboard')
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(
                    );
                })
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        if (window.Laravel.isLoggedin) {
            return next('dashboard');
        }
        next();
    }
}
</script>
<style>
#user_ico
{
    font-size: 40pt;
    color: rgb(255, 255, 255);
    background-color: #6861ce;
    height: 100px;
    width: 100px;
    border-radius: 50%;
    position: absolute;
    margin-top: -60px;
    font-weight: 400;
    text-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    z-index:10;
}
.fa
{
    background-color: white;
    color: #6861ce;
    border-color: white;
    font-size: 20px;
    margin: 10px;
}
</style>