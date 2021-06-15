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
        <!-- End Logo Header -->

        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-expand-lg" data-background-color="purple">
            <div class="container-fluid">
                <div class="collapse" id="search-nav">
                    <form class="navbar-left navbar-form nav-search mr-md-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="submit" class="btn btn-search pr-1">
                                    <i class="fa fa-search search-icon"></i>
                                </button>
                            </div>
                            <input type="text" placeholder="Search ..." class="form-control">
                        </div>
                    </form>
                </div>
                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                    <li class="nav-item toggle-nav-search hidden-caret">
                        <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                            <i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-envelope"></i>
                        </a>
                        <ul class="dropdown-menu messages-notif-box animated fadeIn" aria-labelledby="messageDropdown">
                            <li>
                                <div class="dropdown-title d-flex justify-content-between align-items-center">
                                    Messages 									
                                    <a href="#" class="small">Mark all as read</a>
                                </div>
                            </li>
                            <li>
                                <div class="message-notif-scroll scrollbar-outer">
                                    <div class="notif-center">
                                        <a href="#">
                                            <div class="notif-img"> 
                                                <img src="assets/img/jm_denis.jpg" alt="Img Profile">
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Jimmy Denis</span>
                                                <span class="block">
                                                    How are you ?
                                                </span>
                                                <span class="time">5 minutes ago</span> 
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img"> 
                                                <img src="assets/img/chadengle.jpg" alt="Img Profile">
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Chad</span>
                                                <span class="block">
                                                    Ok, Thanks !
                                                </span>
                                                <span class="time">12 minutes ago</span>
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img"> 
                                                <img src="assets/img/mlane.jpg" alt="Img Profile">
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Jhon Doe</span>
                                                <span class="block">
                                                    Ready for the meeting today...
                                                </span>
                                                <span class="time">12 minutes ago</span> 
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img"> 
                                                <img src="assets/img/talha.jpg" alt="Img Profile">
                                            </div>
                                            <div class="notif-content">
                                                <span class="subject">Talha</span>
                                                <span class="block">
                                                    Hi, Apa Kabar ?
                                                </span>
                                                <span class="time">17 minutes ago</span> 
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="javascript:void(0);">See all messages<i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="notification">4</span>
                        </a>
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                            <li>
                                <div class="dropdown-title">You have 4 new notification</div>
                            </li>
                            <li>
                                <div class="notif-scroll scrollbar-outer">
                                    <div class="notif-center">
                                        <a href="#">
                                            <div class="notif-icon notif-secondary"> <i class="fa fa-user-plus"></i> </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    New user registered
                                                </span>
                                                <span class="time">5 minutes ago</span> 
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-icon notif-success"> <i class="fa fa-comment"></i> </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    Rahmad commented on Admin
                                                </span>
                                                <span class="time">12 minutes ago</span> 
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-img"> 
                                                <img src="assets/img/profile2.jpg" alt="Img Profile">
                                            </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    Reza send messages to you
                                                </span>
                                                <span class="time">12 minutes ago</span> 
                                            </div>
                                        </a>
                                        <a href="#">
                                            <div class="notif-icon notif-danger"> <i class="fa fa-heart"></i> </div>
                                            <div class="notif-content">
                                                <span class="block">
                                                    Farrah liked Admin
                                                </span>
                                                <span class="time">17 minutes ago</span> 
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="javascript:void(0);">See all notifications<i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown hidden-caret">
                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                            <i class="fas fa-layer-group"></i>
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
                                <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <div class="user-box">
                                        <div class="avatar-lg"><img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
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
        <!-- End Navbar -->
    </div>

    <div class="sidebar" v-if="isLoggedIn">			
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <div class="user">
                    <div class="avatar-sm float-left mr-2">
                        <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
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
                            <p>Acceuil</p>
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
        }
    },
    methods: {
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