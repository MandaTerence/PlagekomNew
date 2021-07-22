<template>
    <div class="wrapper">
        <header v-bind:style="{width: 'calc(100% + '+sideBarWidth+'px)'}">
            <div class="banniere">
                <h1>Plagekom</h1>
            </div>
            <!-- Logo Header -->
                <div class="logo-header" data-background-color="blue">
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
            <div class="navigation">
                <nav class="d-none d-lg-block navbar navbar-expand-lg navbar-dark bg-primary">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="isLoggedIn">
                    <a class="nav-item nav-link" style="cursor: pointer;" v-on:click="flipSideBar"><span class="navbar-toggler-icon"></span></a>
                    <router-link to="/dashboard" class="nav-item nav-link">Dashboard</router-link>
                    <router-link to="/books" class="nav-item nav-link">Books</router-link>
                    <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Logout</a>
                    <div class="navbar-nav ml-auto">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" style="color:white">{{ name }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <router-link to="/" class="nav-item nav-link">Home</router-link>
                    <router-link to="/login" class="nav-item nav-link">login</router-link>
                    <router-link to="/register" class="nav-item nav-link">Register</router-link>
                    <router-link to="/about" class="nav-item nav-link">About</router-link>
                </div>
                </nav>
                <nav class="d-block d-lg-none navbar navbar-expand-lg navbar-dark bg-primary">
                    <!-- for logged-in user-->
                    <div class="navbar-nav" v-if="isLoggedIn">
                        <a class="nav-item nav-link" style="cursor: pointer;" v-on:click="flipSideBar"><span class="navbar-toggler-icon"></span></a>
                    </div>
                    <!-- for non-logged user-->
                    <div class="navbar-nav" v-else>
                        <router-link to="/login" class="nav-item nav-link">login</router-link>
                    </div>
                </nav>
            </div>
</header>
    <div class="container">
        
        <div class="row">
            <!--
            <div id="mySidebar" class="sidebar" v-bind:style="{ width: sideBarWidth + 'px'}">
                <a href="javascript:void(0)" class="closebtn" v-on:click="flipSideBar">&times;</a>
                <router-link to="/" class="nav-item nav-link"><div v-on:click="flipSideBar">Acceuil</div></router-link>
                <button class="dropdown-btn" v-on:click="dropdown(0)">Controle telephonique</button>
                <div class="dropdown-container">
                    <router-link to="/dashboard" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[0] }"><div v-on:click="flipSideBar"> -Controle</div></router-link>
                    <router-link to="/books" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[0] }"><div v-on:click="flipSideBar"> -Etat Controle du mois</div></router-link>
                    <router-link to="/planning" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[0] }"><div v-on:click="flipSideBar"> -Calendrier du mois</div></router-link>
                    <router-link to="/" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[0] }"><div v-on:click="flipSideBar"> -Fiche commerciale</div></router-link>
                </div>
                <button class="dropdown-btn" v-on:click="dropdown(1)">Planning et Accompagnement</button>
                <div class="dropdown-container">
                    <router-link to="/creationEquipe" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[1] }"><div v-on:click="flipSideBar" > -Génerer planning d accompagnement</div></router-link>
                    <router-link to="/dashboard" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[1] }"><div v-on:click="flipSideBar" > -Classification commerciaux</div></router-link>
                </div>
                <button class="dropdown-btn" v-on:click="dropdown(2)">Salaire</button>
                <div class="dropdown-container">
                    <router-link to="/dashboard" class="nav-item nav-link sub-category" v-bind:style="{ display: dropdownListDisplay[2] }"><div v-on:click="flipSideBar" > -Salaire du mois</div></router-link>
                </div>
                <a class="nav-item nav-link" style="cursor: pointer;" @click="logout">Déconnexion</a>
            </div>
            -->
            <!-- Sidebar -->
		<div class="sidebar sidebar-style-2">			
			<div class="sidebar-wrapper scrollbar scrollbar-inner">
				<div class="sidebar-content">
					<ul class="nav nav-primary">
						<li class="nav-item active">
							<a data-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
								<i class="fas fa-home"></i>
								<p>Dashboard</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="dashboard">
								<ul class="nav nav-collapse">
									<li>
										<a href="../demo1/index.html">
											<span class="sub-item">Dashboard 1</span>
										</a>
									</li>
									<li>
										<a href="../demo2/index.html">
											<span class="sub-item">Dashboard 2</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-section">
							<span class="sidebar-mini-icon">
								<i class="fa fa-ellipsis-h"></i>
							</span>
							<h4 class="text-section">Components</h4>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#base">
								<i class="fas fa-layer-group"></i>
								<p>Base</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="base">
								<ul class="nav nav-collapse">
									<li>
										<a href="components/avatars.html">
											<span class="sub-item">Avatars</span>
										</a>
									</li>
									<li>
										<a href="components/buttons.html">
											<span class="sub-item">Buttons</span>
										</a>
									</li>
									<li>
										<a href="components/gridsystem.html">
											<span class="sub-item">Grid System</span>
										</a>
									</li>
									<li>
										<a href="components/panels.html">
											<span class="sub-item">Panels</span>
										</a>
									</li>
									<li>
										<a href="components/notifications.html">
											<span class="sub-item">Notifications</span>
										</a>
									</li>
									<li>
										<a href="components/sweetalert.html">
											<span class="sub-item">Sweet Alert</span>
										</a>
									</li>
									<li>
										<a href="components/font-awesome-icons.html">
											<span class="sub-item">Font Awesome Icons</span>
										</a>
									</li>
									<li>
										<a href="components/simple-line-icons.html">
											<span class="sub-item">Simple Line Icons</span>
										</a>
									</li>
									<li>
										<a href="components/flaticons.html">
											<span class="sub-item">Flaticons</span>
										</a>
									</li>
									<li>
										<a href="components/typography.html">
											<span class="sub-item">Typography</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#sidebarLayouts">
								<i class="fas fa-th-list"></i>
								<p>Sidebar Layouts</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="sidebarLayouts">
								<ul class="nav nav-collapse">
									<li>
										<a href="sidebar-style-1.html">
											<span class="sub-item">Sidebar Style 1</span>
										</a>
									</li>
									<li>
										<a href="overlay-sidebar.html">
											<span class="sub-item">Overlay Sidebar</span>
										</a>
									</li>
									<li>
										<a href="compact-sidebar.html">
											<span class="sub-item">Compact Sidebar</span>
										</a>
									</li>
									<li>
										<a href="static-sidebar.html">
											<span class="sub-item">Static Sidebar</span>
										</a>
									</li>
									<li>
										<a href="icon-menu.html">
											<span class="sub-item">Icon Menu</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#forms">
								<i class="fas fa-pen-square"></i>
								<p>Forms</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="forms">
								<ul class="nav nav-collapse">
									<li>
										<a href="forms/forms.html">
											<span class="sub-item">Basic Form</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#tables">
								<i class="fas fa-table"></i>
								<p>Tables</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="tables">
								<ul class="nav nav-collapse">
									<li>
										<a href="tables/tables.html">
											<span class="sub-item">Basic Table</span>
										</a>
									</li>
									<li>
										<a href="tables/datatables.html">
											<span class="sub-item">Datatables</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#maps">
								<i class="fas fa-map-marker-alt"></i>
								<p>Maps</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="maps">
								<ul class="nav nav-collapse">
									<li>
										<a href="maps/jqvmap.html">
											<span class="sub-item">JQVMap</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#charts">
								<i class="far fa-chart-bar"></i>
								<p>Charts</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="charts">
								<ul class="nav nav-collapse">
									<li>
										<a href="charts/charts.html">
											<span class="sub-item">Chart Js</span>
										</a>
									</li>
									<li>
										<a href="charts/sparkline.html">
											<span class="sub-item">Sparkline</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="nav-item">
							<a href="widgets.html">
								<i class="fas fa-desktop"></i>
								<p>Widgets</p>
								<span class="badge badge-success">4</span>
							</a>
						</li>
						<li class="nav-item">
							<a data-toggle="collapse" href="#submenu">
								<i class="fas fa-bars"></i>
								<p>Menu Levels</p>
								<span class="caret"></span>
							</a>
							<div class="collapse" id="submenu">
								<ul class="nav nav-collapse">
									<li>
										<a data-toggle="collapse" href="#subnav1">
											<span class="sub-item">Level 1</span>
											<span class="caret"></span>
										</a>
										<div class="collapse" id="subnav1">
											<ul class="nav nav-collapse subnav">
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li>
										<a data-toggle="collapse" href="#subnav2">
											<span class="sub-item">Level 1</span>
											<span class="caret"></span>
										</a>
										<div class="collapse" id="subnav2">
											<ul class="nav nav-collapse subnav">
												<li>
													<a href="#">
														<span class="sub-item">Level 2</span>
													</a>
												</li>
											</ul>
										</div>
									</li>
									<li>
										<a href="#">
											<span class="sub-item">Level 1</span>
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="mx-4 mt-2">
							<a href="http://themekita.com/atlantis-bootstrap-dashboard.html" class="btn btn-primary btn-block"><span class="btn-label mr-2"> <i class="fa fa-heart"></i> </span>Buy Pro</a> 
						</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- End Sidebar -->
            <div id="main" class="col-md-12" v-bind:style="{'margin-left': sideBarWidth + 'px'}">
                <router-view/>
            </div>
        </div>
        <footer>
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
            dropdownListDisplay: ["none","none","none"]
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
    },
}
</script>