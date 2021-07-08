<template>
<div class="page-inner justify-content-center">
    <div class="container">
        <div class="row justify-content-center" style="margin-top:100px">
            <div class="col-md-6">
                <div class="card" style="border-radius: 10px;">
                    <div class="card-header">
                        <div class="d-flex justify-content-center">
                            <div id="user_ico" class="logoPk d-flex justify-content-center align-items-center" >
                            <span>Pk</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="box-shadow: 5px 10px 10px rgba(0, 0, 0, 0.15)">
                        <div class="row justify-content-center" style="margin-top:10px">
                            <span style="color: red">
                                {{ error }}
                            </span>
                        </div>
                        <form>
                            <div class="form-group row justify-content-center">
                                <div class="input-group input-login col-12 justify-content-center">
                                    <i class="fa fa-user"></i>
                                    <input id="qsdqs" type="text" class="form-control input-pill respText" v-model="matricule" placeholder="Matricule"
                                    autofocus autocomplete="on">
                                </div>
                            </div>
                            <div class="form-group row justify-content-center">
                                <div class="input-group input-password col-12 justify-content-center">
                                    <i class="fa fa-lock"></i>
                                    <input id="password" type="password" class="form-control input-pill respText" v-model="password" placeholder="mot de passe"
                                    autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-secondary col-12" style="cursor: pointer; border-radius: 20px;" @click="handleSubmit">
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
            e.preventDefault();
            this.error = "";
            if(this.password.length < 1){
                this.error = "veuillez saisir le mot de passe"
            }
            else if(this.matricule.length < 1){
                this.error = "veuillez saisir le inserer matricule"
            }
            else{
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
                            this.error = "impossible de se connecter"
                        }
                    })
                    .catch((error) => {
                        this.error = "impossible de se connecter"
                        //console.warn('Not good man :(');
                    })
                    /*
                    .catch(
                        this.error = "impossible de se connecter"
                    );
                    */
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