<template>
<div class="panel-header bg-secondary-gradient" >

    <div class="page-inner py-4">
        <div class="row text-white pb-2 fw-bold">
            <h1>Fiche Commercial</h1>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 d-none d-sm-block">
                    <img src="assets/img/unknow.jpg" class="rounded mx-auto d-block img-fluid d-flex justify-content-center" style="width:160px;height:160px">
                </div>
                <div class="col-md-6">
                   <table>
                        <tr>
                            <td><strong>Nom et prenom:</strong></td>
                            <td style="text-align:right">{{ personnelData.Nom }} {{ personnelData.Prenom }}</td>
                        </tr>
                        <tr>
                            <td><strong>Matricule:</strong></td>
                            <td style="text-align:right">{{ personnelData.Matricule }}</td>
                        </tr>
                        <tr>
                            <td><strong>Contact Telephone:</strong></td>
                            <td style="text-align:right">{{ personnelData.Contact_du_personnel }}</td>
                        </tr>
                        <tr>
                            <td><strong>Adresse:</strong></td>
                            <td style="text-align:right">{{ personnelData.Adresse_du_personnel }}</td>
                        </tr>
                        <tr>
                            <td><strong>Contact tuteur:</strong></td>
                            <td style="text-align:right">{{ personnelData.Contact_du_tuteur }}</td>
                        </tr>
                        <tr>
                            <td><strong>Adresse tuteur:</strong></td>
                            <td style="text-align:right">{{ personnelData.Adresse_du_tuteur }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-3">
                    <tr>
                        <td><strong>Statut Annuel:</strong></td>
                        <td style="text-align:right"></td>
                    </tr>
                    <tr>
                        <td><strong>Point Annuel:</strong></td>
                        <td style="text-align:right"></td>
                    </tr>
                </div>
            </div>
            <h3 class="text-center"><span style="background-color:#f9fbfd">Chiffre d'affaire mois en cours</span></h3>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class="card-body">
                    <div class='row-fluid'>
                        <div class='span11'>
                            <table class="table table-hover" style="white-space: nowrap">
                                <tbody>
                                    <tr>
                                        <td class="text-left">Vente sur facebook</td>
                                        <td class="text-right">45</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Vente sur terrain</td>
                                        <td class="text-right">12</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">Nombre de produit</td>
                                        <td class="text-right">57</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="respText  text-center"><span style="background-color:#f9fbfd">commission</span></h3>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class="card-body">
                    <div class='row-fluid'>
                        <div class='span11'>
                            <table class="table table-hover" style="white-space: nowrap">
                                <tbody>
                                    <tr>
                                        <td class="respText text-left">Total Commissions</td>
                                        <td class="respText text-right">45</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Commission vente sur facebook</td>
                                        <td class="respText text-right">12</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Commission vente sur terrain</td>
                                        <td class="respText text-right">57</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Salaire previsionnel du mois</td>
                                        <td class="respText text-right">57</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Pourboire</td>
                                        <td class="respText text-right">57</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Total Commande</td>
                                        <td class="respText text-right">57</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center"><span style="background-color:#f9fbfd">Avantage et bonus</span></h3>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class="card-body">
                    <div class='row-fluid'>
                        <div class='span11'>
                            <table class="table table-hover" style="white-space: nowrap">
                                <tbody>
                                    <tr>
                                        <td class="respText text-left">Total Bonus</td>
                                        <td class="respText text-right">45</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Bonus Mensuelle</td>
                                        <td class="respText text-right">12</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Indemnité journalière</td>
                                        <td class="respText text-right">12</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center"><span style="background-color:#f9fbfd">Challenge</span></h3>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class="card-body">
                    <div class='row-fluid'>
                        <div class='span11'>
                            <table class="table table-hover" style="white-space: nowrap">
                                <tbody>
                                    <tr>
                                        <td class="respText text-left">Total Challenge</td>
                                        <td class="respText text-right">45</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Challenge</td>
                                        <td class="respText text-right">12</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="text-center"><span style="background-color:#f9fbfd">Déduction et sanction</span></h3>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class='row-fluid'>
                    <div class='span11'>
                        <table class="table table-hover" style="white-space: nowrap">
                            <tbody>
                                <tr>
                                    <td class="respText text-left">Total Deduction</td>
                                    <td class="respText text-right">45</td>
                                </tr>
                                <tr>
                                    <td class="respText text-left">Malus</td>
                                    <td class="respText text-right">12</td>
                                </tr>
                                <tr>
                                    <td class="respText text-left">Sanction sur controle telephonique</td>
                                    <td class="respText text-right">12</td>
                                </tr>
                                <tr>
                                    <td class="respText text-left">Absence</td>
                                    <td class="respText text-right">12</td>
                                </tr>
                                <tr>
                                    <td class="respText text-left">Manques</td>
                                    <td class="respText text-right">12</td>
                                </tr>
                                <tr>
                                    <td class="respText text-left">Autres deductions</td>
                                    <td class="respText text-right">12</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>
/*
    attributs:
    -force      +2
    -agilité    +1
    -esprit     +0
    -charisme   -1

    combats:
    -melee/parade
    -distance/esquive
    -magie/concentration

    12 		2.77 	100
    11 	 	8.33 	97.22
    10	 	16.66 	91.66
    9	 	27.77 	83.33
    8 	 	41.66 	72.22
    7 	 	58.33 	58.33
    6 	 	72.22 	41.66
    5 	 	83.33 	27.77
    4 	 	91.66 	16.66
    3 	 	97.22 	8.33
    2 		100 	2.77

*/
export default {
    name: "Fiche",
    data() {
        return {
            personnelData: [],
            matricule: '',
            exist: false,
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    created() {
        this.loadURLdata();
    },
    methods: {
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('matricule')){
                this.matricule = urlParams.get('matricule');
                this.getPersonnel();
            }
            else if(localStorage.matricule){
                this.matricule = localStorage.matricule;
                this.getPersonnel();
            }
        },
        getPersonnel(){
            this.$axios.get('/api/personnels/getPersonnelData',{params: {matricule: this.matricule }}) 
            .then(response => {
                this.exist=response.data.success;
                if(this.exist){
                    localStorage.matricule = this.matricule;
                    this.personnelData = response.data.personnel;
                    if(this.personnelData.Id_de_la_mission == "aucune"){
                        alert("attention ce commercial n est actuellement sur aucune mission");
                    }
                }
                else{
                    alert(this.matricule+" n'existe pas ");
                }
            });
        }
    }
}
</script>
 