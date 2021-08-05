<template>
<div class="wrapper" v-if="!isLoggedIn">
    <div class="content">
        <router-view/>
    </div>
</div>
<div class="wrapper" v-if="isLoggedIn">

    <div class="main-header">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="purple">
            <a href="index.html" class="logo">
                <h1 alt="navbar brand" class="navbar-brand" style="color:white">Plagekom</h1>
            </a>
            <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="icon-menu"></i>
                </span>
            </button>
            <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="icon-menu"></i>
                </button>
            </div>
        </div>

        <nav class="navbar navbar-header navbar-expand-lg" data-background-color="purple">
            <div class="container-fluid">
                <div class="collapse" id="search-nav">
                    <form class="navbar-left navbar-form nav-search mr-md-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-search pr-1">
                                    <i class="fa fa-search search-icon" style="background-color: transparent"></i>
                                </button>
                            </div>
                            <input v-model="matricule" type="text" placeholder="Search ..." class="form-control" v-on:keyup="autoComplete" v-on:click="autoComplete">
                        </div>
                        <div class="panel-footer" style="float:top;position: absolute;z-index: 1;width: 380px;" >
                            <ul class="list-group">
                                <li class="list-group-item" style="padding-left: 70px;" v-for="result in resultats" v-bind:key="result" v-on:click.left="changeMatriculeValue(result.Matricule)" >
                                    <div >{{ result.Matricule }}</div>
                                </li>
                            </ul>
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <li class="nav-item toggle-nav-search hidden-caret">
                        <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                            <i class="fa fa-search" style="background-color: transparent"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a @click="logout" class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fas fa-power-off"></i>
                        </a>
                        <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                            <div class="quick-actions-header">
                                <span class="title mb-1">Quick Actions</span>
                                <span class="subtitle op-8">Shortcuts</span>
                            </div>
                            <div class="quick-actions-scroll scrollbar-outer">
                                <div class="quick-actions-items">
                                    <div class="row m-0">
                                        <a class="col-6 col-md-4 p-0" href="#">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-file-1"></i>
                                                <span class="text">Generated Report</span>
                                            </div>
                                        </a>
                                        <a class="col-6 col-md-4 p-0" href="#">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-database"></i>
                                                <span class="text">Create New Database</span>
                                            </div>
                                        </a>
                                        <a class="col-6 col-md-4 p-0" href="#">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-pen"></i>
                                                <span class="text">Create New Post</span>
                                            </div>
                                        </a>
                                        <a class="col-6 col-md-4 p-0" href="#">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-interface-1"></i>
                                                <span class="text">Create New Task</span>
                                            </div>
                                        </a>
                                        <a class="col-6 col-md-4 p-0" href="#">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-list"></i>
                                                <span class="text">Completed Tasks</span>
                                            </div>
                                        </a>
                                        <a class="col-6 col-md-4 p-0" href="#">
                                            <div class="quick-actions-item">
                                                <i class="flaticon-file"></i>
                                                <span class="text">Create New Invoice</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm">
                                <img v-bind:src="profileImageSrc" @error="imageUrlAlt"  alt="..." class="avatar-img rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg"><img v-bind:src="profileImageSrc" @error="imageUrlAlt"  alt="image profile" class="avatar-img rounded" style="background-color: white"></div>
                                        <div class="u-text">
                                            <h4>{{ name }}</h4>
                                            <p class="text-muted">hello@example.com</p><a href="profile.html" class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">My Profile</a>
                                    <a class="dropdown-item" href="#">My Balance</a>
                                    <a class="dropdown-item" href="#">Inbox</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Account Setting</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">Logout</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="sidebar" v-if="isLoggedIn">			
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">imageUrlAlt
                        <img v-bind:src="profileImageSrc" @error="imageUrlAlt"  alt="..." class="avatar-img rounded-circle" style="background-color: white">
                    </div>
                    <div class="info">
                        <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                            <span>
                                {{ name }}
                                <span class="user-level">Coach</span>
                                <span class="caret"></span>
                            </span>
                        </a>
                        <div class="clearfix"></div>
                        <div class="collapse in" id="collapseExample">
                            <ul class="nav">
                                <li>
                                    <a href="#edit">
                                        <span class="link-collapse">Edit Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#settings">
                                        <span class="link-collapse">Settings</span>
                                    </a>
                                </li>
                                <li>
                                    <a style="cursor: pointer;" @click="logout">
                                        <span class="link-collapse"> Déconnexion </span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-secondary">
                    <li class="nav-item">
                        <a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <router-link to="/">
                                <p class="sub-item">Acceuil</p>
                            </router-link>
                        </a>
                    </li>
                    <li v-bind:class="displaySideBar[0]['navClass']">
                        <a  v-on:click="toogleDisplaySideBar('controle')">
                            <i class="fas fa-phone-volume"></i>
                            <p>Controle telephonique</p>
                            <span class="caret"></span>
                        </a>
                        <div v-if="displaySideBar[0]['display']==true">
                            <ul class="nav nav-collapse">
                                <li>
                                    <router-link to="/controleTelephonique"><span class="sub-item">Controle</span></router-link>
                                </li>
                                <li>
                                    <router-link to="/TimeLine"><span class="sub-item">Etat Controle du mois</span></router-link>
                                </li>
                                <li>
                                    <router-link to="/planning"><span class="sub-item">Calendrier du mois</span></router-link>
                                </li>
                                <li>
                                    <router-link to="/Fiche"><span class="sub-item">Fiche commerciale</span></router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li v-bind:class="displaySideBar[1]['navClass']">
                        <a v-on:click="toogleDisplaySideBar('planning')">
                            <i class="fas fa-users"></i>
                            <p>Planning et Accompagnement</p>
                            <span class="caret"></span>
                        </a>
                        <div v-if="displaySideBar[1]['display']==true">
                            <ul class="nav nav-collapse">
                                <li>
                                    <router-link to="/Evaluation" class="nav-item nav-link sub-category">
                                        <span class="sub-item">Evaluation des commerciaux</span>
                                    </router-link>   
                                </li>
                                <li class="active">
                                    <router-link to="/creationEquipe" class="nav-item nav-link sub-category">
                                        <span class="sub-item">Génerer planning d accompagnement</span>
                                    </router-link>   
                                </li>
                                <li>
                                    <router-link to="/classificationCommerciaux" class="nav-item nav-link sub-category">
                                        <span class="sub-item">Classification commerciaux</span>
                                    </router-link>   
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li v-bind:class="displaySideBar[2]['navClass']">
                        <a v-on:click="toogleDisplaySideBar('salaire')">
                            <i class="fas fa-money-check-alt"></i>
                            <p>Salaire</p>
                            <span class="caret"></span>
                        </a>
                        <div v-if="displaySideBar[2]['display']==true">
                            <ul class="nav nav-collapse">
                                <li>
                                    <router-link to="/Salaire" class="nav-item nav-link sub-category">
                                        <span class="sub-item">Salaire du mois</span>
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-panel">
        <div class="content" >
            <!-- <div class="page-inner"> -->
            <router-view/>
            <!-- </div> -->
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.themekita.com">
                                ThemeKita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto">
                    2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com">ThemeKita</a>
                </div>
            </div>
        </footer>
    </div>
</div>
</template>

<script>

export default {
    name: "App",
    data() {
        return {
            
            name: null,
            isLoggedIn: false,
            displayMenu: true,
            sideBarWidth: 0,
            matricule: "",
            isSearchingAutoComplete: false,
            resultats: [],
            profileImageSrc: "",

            dropdownListDisplay: ["none","none","none"],
            displaySideBar: [
                {
                    nom:"controle",
                    navClass:"nav-item submenu",
                    display:false
                },
                {
                    nom:"planning",
                    navClass:"nav-item submenu",
                    display:false
                },
                {
                    nom:"salaire",
                    navClass:"nav-item submenu",
                    display:false
                }
            ]
        }
    },
    created() {
        if (window.Laravel.isLoggedin) {
            this.isLoggedIn = true
        }
        if (window.Laravel.user) {
            this.name = window.Laravel.user.Nom;
            this.profileImageSrc="http://komone.combo.fun/images/personnel/"+window.Laravel.user.Matricule+".jpg";
        }
    },
    methods: {
        imageUrlAlt(event) {
            //event.target.src = "alt-image.jpg"
            this.profileImageSrc="assets/img/profile.jpg";
        },
        changeMatriculeValue(newMatricule){
            this.resultats = [];
            this.matricule = newMatricule;
        },
        autoComplete(){
            if((this.matricule.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingAutoComplete = true;
                setTimeout(this.searchAutoComplete, 1000);
            }    
        },
        searchAutoComplete(){
            this.resultats = [];
            axios.get('/api/personnels/getMatricule',{params: {search: this.matricule}}).then(response => {
                this.isSearchingAutoComplete = false;
                if(response.data.success){
                    this.resultats = response.data.personnels;
                }
                else{
                    alert(response.data.message);
                }
            });
        },
        toogleDisplaySideBar(sideItemName){
            for(let i=0;i<this.displaySideBar.length;i++){
                if(sideItemName == this.displaySideBar[i]["nom"]){
                    if(this.displaySideBar[i]["display"]==true){
                        this.displaySideBar[i]["display"]=false;
                        this.displaySideBar[i]["navClass"]="nav-item submenu";
                    }
                    else{
                        this.displaySideBar[i]["display"]=true;
                        this.displaySideBar[i]["navClass"]="nav-item active submenu";
                    } 
                    break;
                }
            }
        },
        logout(e) {
            console.log('ss')
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/login"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        flipSideBar(){
            //this.sideBarWidth == 0 ?  this.sideBarWidth = 250: this.sideBarWidth = 0;
            if(this.sideBarWidth == 0){
                this.sideBarWidth = 250;
            }
            else{
                this.sideBarWidth = 0;
            }
        },
        dropdown(i) {
            //this.dropdownListDisplay[i] == "none" ? this.dropdownListDisplay[i] = "block":this.dropdownListDisplay[i] = "block";
            if(this.dropdownListDisplay[i] == "none"){
                this.dropdownListDisplay[i] = "block";
            }
            else{
                this.dropdownListDisplay[i] = "none";
            }
        }
    }
}
</script>
<style>

</style>