<template>

<div class="panel-header bg-secondary-gradient" >
    <div class="page-inner py-4">
        <ul class="breadcrumbs text-white d-none d-sm-block" style="margin-left: -40px">
            <li class="nav-item">
                <i class="fas fa-phone-volume"></i>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <span class="text-white">Controlle télephonique</span>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <span class="text-white" >Fiche Commercial</span>
            </li>
        </ul>
        <div class="row text-white pb-2 fw-bold" style="margin-top:40px">
            <h1>Fiche Commercial</h1>
        </div>
    </div>
</div>

<div style="margin-top: 30px" class="row justify-content-center" v-if="isLoadingData">
    <div class="loader loader-lg"></div>
</div>

<div v-else>
    <div>
        <div class="card">
            <div class="card-body ">
                <div class="form-group input-group">
                    <input type="text" class="form-control" id="matricule"  placeholder="Matricule" v-model="matricule">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary" v-on:click="getPersonnel">voir la fiche commerciale</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="!(matricule == '')" class="page-inner">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 d-none d-sm-block">
                        <img src="assets/img/unknow.jpg" class="mx-auto img-fluid d-flex justify-content-center" style="width:160px;height:160px">
                    </div>
                    <div class="col-md-3 d-block d-sm-none">
                        <img src="assets/img/unknow.jpg" class="avatar-img rounded-circle mx-auto img-fluid d-flex justify-content-center" style="width:160px;height:160px">
                    </div>
                    <div class="col-md-5 textresp">
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
                    <div class="col-md-4">
                        <table >
                            <tr>
                                <td><strong>Statut Annuel:</strong></td>
                                <td><strong>Point Annuel:</strong></td>
                            </tr>
                            <tr>
                                <td>{{ personnelData.statutAnnuel }}</td>
                                <td>{{ personnelData.pointAnnuel }}</td>
                            </tr>
                        </table>
                        <table >
                            <tr>
                                <td><strong>Statut Mensuel:</strong></td>
                                <td><strong>Point Mensuel:</strong></td>
                            </tr>
                            <tr>
                                <td>{{ personnelData.statutMensuel }}</td>
                                <td>{{ personnelData.pointMensuel }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div style="margin-top: 40px">
                    <h3 class="text-center"><span style="background-color:#f9fbfd;margin-top:30px">Chiffre d'affaire mois en cours</span></h3>
                    <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                    <div class="card" style="margin-top: 20 px;margin-bottom: 30 px">
                        <div class="card-body">
                            <div class='row-fluid'>
                                <div class='span11'>
                                    <table class="table table-hover" style="white-space: nowrap">
                                        <tbody>
                                            <tr>
                                                <td class="text-left">Vente sur facebook</td>
                                                <td class="text-right">{{  getMoneyFormat(personnelData.CAFacebook) }} Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Vente sur terrain</td>
                                                <td class="text-right">{{  getMoneyFormat(personnelData.CATerrain) }} Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="text-left">Nombre de produit</td>
                                                <td class="text-right">{{ getMoneyFormat(personnelData.nbrProduit) }} </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3 class="text-center"><span style="background-color:#f9fbfd">commission</span></h3>
                    <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                    <div class="card">
                        <div class="card-body">
                            <div class='row-fluid'>
                                <div class='span11'>
                                    <table class="table table-hover" style="white-space: nowrap">
                                        <tbody>
                                            <tr>
                                                <td class="respText text-left">Total Commissions</td>
                                                <td class="respText text-right">0 Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Commission vente sur facebook</td>
                                                <td class="respText text-right">0 Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Commission vente sur terrain</td>
                                                <td class="respText text-right">0 Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Salaire previsionnel du mois</td>
                                                <td class="respText text-right">0 Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Pourboire</td>
                                                <td class="respText text-right">0 Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Total Commande</td>
                                                <td class="respText text-right">0 Ar</td>
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
                                                <td class="respText text-right">{{ getMoneyFormat(personnelData.bonusMensuel + personnelData.IndemniteNormaux + personnelData.Indemnitelocaux) }} Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Bonus Mensuelle</td>
                                                <td class="respText text-right">{{ getMoneyFormat(personnelData.bonusMensuel) }} Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Indemnité journalière</td>
                                                <td class="respText text-right">{{ getMoneyFormat(personnelData.IndemniteNormaux + personnelData.Indemnitelocaux) }} Ar</td>
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
                                                <td class="respText text-right">0 Ar</td>
                                            </tr>
                                            <tr>
                                                <td class="respText text-left">Challenge</td>
                                                <td class="respText text-right">0 Ar</td>
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
                                        <td class="respText text-left">total de deduction</td>
                                        <td class="respText text-right">{{ getMoneyFormat(personnelData.sommeSanctions + personnelData.malusVente) }} Ar</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Malus</td>
                                        <td class="respText text-right">{{ getMoneyFormat(personnelData.malusVente) }} Ar</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Sanction sur controle telephonique</td>
                                        <td class="respText text-right">{{ getMoneyFormat(personnelData.sommeSanctions) }} Ar</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Absence</td>
                                        <td class="respText text-right">0 Ar</td>
                                        <!--{{ personnelData.malusAbsence }} -->
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Manques</td>
                                        <td class="respText text-right">0 Ar</td>
                                    </tr>
                                    <tr>
                                        <td class="respText text-left">Autres deductions</td>
                                        <td class="respText text-right">0 Ar</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
</template>
<script>
export default {
    name: "Fiche",
    data() {
        return {
            personnelData: [],
            matricule: '',
            exist: false,
            isLoadingData: false
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
        getMoneyFormat(monnaie){
            if(monnaie)
                return Number(monnaie).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& '); 
            else
                return 0;
        },
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('matricule')){
                this.matricule = urlParams.get('matricule');
                this.getPersonnel();
            }
            /*else if(localStorage.matricule){
                this.matricule = localStorage.matricule;
                this.getPersonnel();
            }*/
        },
        getPersonnel(){
            this.isLoadingData = true;
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
                this.isLoadingData = false;
            });
        }
    }
}
</script>
 