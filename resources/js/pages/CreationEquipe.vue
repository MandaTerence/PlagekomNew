<template>

    <div v-if="!showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <h2 class="text-white pb-2 fw-bold">Creation d'equipe</h2>
            </div>
        </div>
        <div class="page-inner">
            <h2 class="text-center">
                <span style="background-color:#f9fbfd">Recherche</span>
            </h2>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class="card-body">
                    <h3>Recherche de personnel</h3>
                    <hr/>
                    <div class="row" id="rechercheNormal">
                        <div class="form-group col-12 col-md-3">
                            <label for="inputMission">Mission</label>
                            <select class="form-control " id="inputMission" v-model="idMission" v-on:change="changeIdMission">
                                <option v-bind:key="mission.Id_de_la_mission" v-bind:value="mission.Id_de_la_mission" v-for="mission in missions">{{ mission.Id_de_la_mission }}</option>
                            </select>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="inputFonction">Fonction</label>
                            <select class="form-control " id="inputFonction" v-model="idFonction" v-on:change="changeCustomId">
                                <option v-bind:key="fonction.designation" v-bind:value="fonction.id" v-for="fonction in fonctions">{{ fonction.designation }}</option>
                            </select>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <label for="inputMatricule">Matricule</label>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <input class="form-control"  type="text" placeholder="what are you looking for?" v-model="matricule" v-on:keyup="autoComplete" v-on:click="autoComplete">
                                </div>
                                <div class="panel-footer" style="float:top;position: absolute;z-index: 1;width: -moz-available;" >
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="result in resultats" v-bind:key="result" v-on:click.left="changeMatriculeValue(result.Matricule)" >
                                            <div >{{ result.Matricule }}</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-6 col-md-3">
                            <button class="btn btn-secondary btn-sm justify-content-center" style="margin-top:30px; margin-right:5px" v-on:click="addPersonnel">Ajouter</button>
                            <button class="btn btn-secondary btn-sm justify-content-center" style="margin-top:30px" v-on:click="toogleAdvancedSearch"><i class="fas fa-bars" style="color:white"></i></button>
                        </div>
                    </div>
                    <div v-if="showAdvancedSearch">
                        <hr/>
                        <h3>Recherche avance</h3>
                        <hr/>
                    </div>
                    <div class="row" id="rechercheAvance" v-if="showAdvancedSearch">
                        <div class="col-12">
                            <SearchProduit v-model:produits="produits"/>
                        </div>
                        <div class="col-12">
                            <ProduitTab v-model:produits="produits"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="text-center"><span style="background-color:#f9fbfd">Resultat</span></h2>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <!--testqsdsqd-->
                <!--
                <div class="card-body">
                    <div class="row d-flex justify-content-center" id="resultCoach" >
                        <div class="table-responsive col-12" style="margin-left:25px">
                            <EquipeTab  v-model:equipes="coachs" titre="Coachs"/>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center" id="resultCommerciaux" >
                        <div class="table-responsive col-12" style="margin-left:25px">
                            <EquipeTab  v-model:equipes="commerciaux" titre="Commerciaux"/>
                        </div> 
                    </div>
                    <div class="row" >
                        <div class="col-12 text-right">
                            <button class="btn btn-secondary" v-on:click="getClassement">lancer le classement</button>
                        </div>
                    </div>
                </div>
                -->
                
                <div class="card-body">
                    <div class="row" style="margin-left:20px">
                        <button v-bind:class="buttonTeamA" v-on:click="toogleAvtiveTeamButton(1)">
                            Equipe 1
                            </button>
                        <button v-bind:class="buttonTeamB" v-on:click="toogleAvtiveTeamButton(2)">
                            Equipe 2
                        </button>
                    </div>
                    <div class="row" v-if="buttonTeamA=='btn btn-secondary'">
                        <div class="table-responsive table-sm">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center" id="resultCoach" >
                                    <div class="table-responsive col-12" style="margin-left:25px">
                                        <EquipeTab  v-model:equipes="EquipeA.coachs" titre="Coachs"/>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center" id="resultCommerciaux" >
                                    <div class="table-responsive col-12" style="margin-left:25px">
                                        <EquipeTab  v-model:equipes="EquipeA.commerciaux" titre="Commerciaux"/>
                                    </div> 
                                </div>
                                <div class="row" >
                                    <div class="col-12 text-right">
                                        <button class="btn btn-secondary" v-on:click="getClassement">lancer le classement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-else>
                        <div class="table-responsive table-sm">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center" id="resultCoach" >
                                    <div class="table-responsive col-12" style="margin-left:25px">
                                        <EquipeTab  v-model:equipes="EquipeB.coachs" titre="Coachs"/>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center" id="resultCommerciaux" >
                                    <div class="table-responsive col-12" style="margin-left:25px">
                                        <EquipeTab  v-model:equipes="EquipeB.commerciaux" titre="Commerciaux"/>
                                    </div> 
                                </div>
                                <div class="row" >
                                    <div class="col-12 text-right">
                                        <button class="btn btn-secondary" v-on:click="getClassement">lancer le classement</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <h2 class="text-white pb-2 fw-bold">Classement pour la mission {{ idMission }}</h2>
            </div>
        </div>
        <div class="page-inner">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            Classement Proposé pour l'équipe A du coach {{ EquipeA.coachs[0].Matricule }} 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                    <thead >
                                        <tr class="bg-secondary" style="color:white">
                                            <th class="respText" >matricule</th>
                                            <th class="respText" >nom et prenom</th>
                                            <th class="respText" >place</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="equipe in ClassementA" v-bind:key="equipe">
                                            <td class="respText" >{{ equipe.Matricule }}</td>
                                            <td class="respText" >{{ equipe.Nom }}</td>
                                            <td class="respText" >
                                                <input type="number" v-model="equipe.placeTemp" v-on:change="changeClassement(ClassementA,equipe.place,equipe.placeTemp)"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>        
                            <div class="card">
                                <div class="card-header">             
                                    <h1><a v-on:click="toogleDetail('A')">Detail</a></h1>
                                </div>
                                <div class="card-body" v-if="showDetailA==true">
                                    <div v-for="Classement in ClassementDetailA" v-bind:key="Classement">
                                        <h1>{{ Classement.nom }}</h1>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                                <thead >
                                                    <tr class="bg-secondary" style="color:white">
                                                        <th class="respText" >matricule</th>
                                                        <th class="respText" >nom et prenom</th>
                                                        <th class="respText" >CA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="equipe in Classement.classement" v-bind:key="equipe">
                                                        <td class="respText" >{{ equipe.Matricule }}</td>
                                                        <td class="respText" >{{ equipe.Nom }}</td>
                                                        <td class="respText" >{{ equipe.CA }}</td>
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
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-header">
                            Classement Proposé pour l'équipe B du coach {{ EquipeB.coachs[0].Matricule }} 
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                    <thead >
                                        <tr class="bg-secondary" style="color:white">
                                            <th class="respText" scope="col-md-2">matricule</th>
                                            <th class="respText" scope="col-md-2 d-none">nom et prenom</th>
                                            <th class="respText" scope="col-md-1">place</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="equipe in ClassementB" v-bind:key="equipe">
                                            <td class="respText" scope="col-md-2">{{ equipe.Matricule }}</td>
                                            <td class="respText" scope="col-md-2">{{ equipe.Nom}}</td>
                                            <td class="respText" scope="col-md-1">
                                                <input type="number" v-model="equipe.placeTemp" v-on:change="changeClassement(ClassementB,equipe.place,equipe.placeTemp)"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card">
                                <div class="card-header">             
                                    <h1><a v-on:click="toogleDetail('B')">Detail</a></h1>
                                </div>
                                <div class="card-body" v-if="showDetailB==true">
                                    <div v-for="Classement in ClassementDetailB" v-bind:key="Classement">
                                        <h1>{{ Classement.nom }}</h1>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                                <thead >
                                                    <tr class="bg-secondary" style="color:white">
                                                        <th class="respText" >matricule</th>
                                                        <th class="respText" >nom et prenom</th>
                                                        <th class="respText" >CA</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="equipe in Classement.classement" v-bind:key="equipe">
                                                        <td class="respText" >{{ equipe.Matricule }}</td>
                                                        <td class="respText" >{{ equipe.Nom }}</td>
                                                        <td class="respText" >{{ equipe.CA }}</td>
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
            <div class="row">
                <div class="col-6 d-flex justify-content-start">
                    <button style="margin:20px" class="btn-round btn btn-secondary " v-on:click="retourClassement">
                        <span>retour</span>
                    </button>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <button style="margin:20px" class="btn-round btn btn-secondary d-flex justify-content-end" v-on:click="validateAllEquipe">
                        <span>valider</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import EquipeTab from "../components/EquipeTab";
import SearchPersonnel from "../components/SearchPersonnel";
import SearchProduit from "../components/SearchProduit";
import ProduitTab from "../components/ProduitTab";
import ClassementTab from "../components/ClassementTab";

export default {
    name: "CreationEquipe",
    data() {
        return {
            isSearchingAutoComplete: false,
            showClassements: false,
            showAdvancedSearch: false,
            maxCoach:1,
            maxCommerciaux:8,
            showModal: false,

            matricule: '',

            fonctions: [],
            missions: [],

            commerciaux: [],
            coachs: [],
            produits: [],

            idFonction: null,
            idMission: "%%",

            idProduit: null,

            customId: null,

            resultats: [],
            classements: [],
            classementReel: [],

            EquipeA: {
                coachs : [],
                commerciaux : []
            },
            EquipeB: {
                coachs : [],
                commerciaux : []
            },

            showDetailA: false,
            showDetailB: false,
            ClassementA: [],
            ClassementB: [],

            ClassementDetailA: [],
            ClassementDetailB: [],

            buttonTeamA: "btn btn-secondary btn-border",
            buttonTeamB: "btn btn-secondary"
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    computed: {
        selectedTeam: function () {
            if((this.buttonTeamA=="btn btn-secondary")&&(this.buttonTeamA!="btn btn-secondary btn-border")){
                return "A";
            }   
            else{
                return "B";
            }
        }
    },
    created() {
        this.loadMissions();
        this.loadFonctions();
        this.loadLocalData();
    },
    methods: {
        toogleDetail(equipe){
            if(equipe=="A"){
                if(this.showDetailA){
                    this.showDetailA=false;
                }
                else{
                    this.showDetailA=true;
                }
            }
            else{
                if(this.showDetailB){
                    this.showDetailB=false;
                }
                else{
                    this.showDetailB=true;
                }
            }
            
        },
        changeIdMission(){
            this.EquipeA= {
                coachs : [],
                commerciaux : []
            };
            this.EquipeB= {
                coachs : [],
                commerciaux : []
            };
            alert("Vous avez choisit la mission : "+this.idMission);
        },
        toogleAvtiveTeamButton(team){
            if(team==1){
                this.buttonTeamA="btn btn-secondary";
                this.buttonTeamB="btn btn-secondary btn-border";
            }
            else{
                this.buttonTeamA="btn btn-secondary btn-border";
                this.buttonTeamB="btn btn-secondary ";
            }
        },
        retourClassement(){
            this.toogleClassementsView();
            localStorage.removeItem("classements");
            localStorage.removeItem("classementReel");
        },
        loadLocalData(){
            if(localStorage.getItem('classementReel') !== null){
                this.classementReel = JSON.parse(localStorage.classementReel);
                this.classements= JSON.parse(localStorage.classements);
                this.showClassements = true;
            }
            if(localStorage.getItem('EquipeA')){
                this.EquipeA = JSON.parse(localStorage.EquipeA);
            }
            if(localStorage.getItem('EquipeB')){
                this.EquipeB = JSON.parse(localStorage.EquipeB);
            }
        },
        toogleAdvancedSearch(){
            (this.showAdvancedSearch)?this.showAdvancedSearch = false: this.showAdvancedSearch = true;
        },
        loadMissions(){
            this.$axios.get('/api/missions',{params: {criteres: {Statut: 'En_cours'}}}) 
            .then(response => {
                if(response.data.success){
                    this.missions = response.data.missions;
                    this.idMission = this.missions[0].Id_de_la_mission;
                }
                else{
                    console.log(response.data.message);
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        },
        fillPlaceTemp(classement){
            for(let i= 0;i<classement.length;i++){
                classement[i].placeTemp = classement[i].place;
            }
        },
        fonctionOnChange(){
            this.resultats = [];
            this.matricule = '';
        },
        changeMatriculeValue(newMatricule){
            this.resultats = [];
            this.matricule = newMatricule;
        },
        changeCustomId(){
            this.customId = null;
            for(let i = 0;i< this.fonctions.length;i++){
                if(this.fonctions[i].id == this.idFonction){
                    if(this.fonctions[i].customId){
                        this.customId = this.fonctions[i].customId;
                    }
                }
            }
            this.autoComplete();
        },
        toogleClassementsView(){
            (this.showClassements)? this.showClassements = false : this.showClassements = true;
        },
        autoComplete(){
            if((this.matricule.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingAutoComplete = true;
                if(this.idFonction != null ){
                    setTimeout(this.searchAutoComplete, 1000);
                }
            }    
        },
        validateEquipe(coach,equipe){
            //alert(JSON.stringify(this.getMatriculeAndPlaceFromArray(equipe)));
            if(coach.length<this.maxCoach){
                alert("il manque "+(this.maxCoach-coach.length)+" coach");
            }
            else if(equipe.length<this.maxCommerciaux){
                alert("il manque "+(this.maxCommerciaux-equipe.length)+" commerciaux");
            }
            else{
                axios.post('/api/classements/',{matriculeCoach: coach[0].Matricule,matriculeCommerciaux: this.getMatriculeAndPlaceFromArray(equipe),idMission:this.idMission}).then(response => {
                    if(response.data.success){
                        this.showModal = false;
                        //this.$router.push({ name: 'planning', query: { idMission: this.idMission ,coach: this.coach} });
                    }
                    else if(!response.data.success){
                        alert('insertion echoué');
                    }
                });
            }
        },
        validateAllEquipe(){
            this.validateEquipe(this.EquipeA.coachs,this.ClassementA);
            this.validateEquipe(this.EquipeB.coachs,this.ClassementB);
            /*
            if(this.coachs.length<this.maxCoach){
                alert("il manque "+(this.maxCoach-this.coachs.length)+" coach");
            }
            else if(this.commerciaux.length<this.maxCommerciaux){
                alert("il manque "+(this.maxCommerciaux-this.commerciaux.length)+" commerciaux");
            }
            else{
                axios.post('/api/classements/',{matriculeCoach: this.coachs[0].Matricule,matriculeCommerciaux: this.getMatriculeAndPlaceFromArray(this.classementReel),idMission:this.idMission}).then(response => {
                    if(response.data.success){
                        this.showModal = false;
                        //this.$router.push({ name: 'planning', query: { idMission: this.idMission ,coach: this.coach} });
                    }
                    else if(!response.data.success){
                        alert('insertion echoué');
                    }
                });
            }*/
        },
        getMatriculeAndPlaceFromArray(personnels){
            let matricules = [];
            for(let i=0;i<personnels.length;i++){
                let element = {'Matricule' : personnels[i]['Matricule'], 'Place' : personnels[i]['place'] };
                matricules.push(element);
            }
            return matricules;
        },
        getMatriculeFromArray(personnels){
            let matricules = [];
            for(let i=0;i<personnels.length;i++){
                matricules.push(personnels[i]['Matricule']);
            }
            return matricules;
        },
        getCodeProduitFromArray(produits){
            let codeProduits = [];
            for(let i=0;i<produits.length;i++){
                codeProduits.push(produits[i]['Code_produit']);
            }
            return codeProduits;
        },
        getClassement(){
            /*
            let matricules = this.getMatriculeFromArray(this.commerciaux);
            let produits =  this.getCodeProduitFromArray(this.produits);
            this.classements.splice(0,this.classements.length);
            axios.get('/api/personnels/getClassement',{params: {Matricules: matricules,Produits: produits}}).then(response => { 
                if(response.data.personnels!=null){
                    this.classements = response.data.classements;
                    localStorage.classements = JSON.stringify(this.classements);
                    this.fillPlaceTemp(response.data.classementsReel);
                    this.classementReel = response.data.classementsReel;
                    localStorage.classementReel = JSON.stringify(this.classementReel);
                    this.toogleClassementsView();
                }
            });
            */
            let produits =  this.getCodeProduitFromArray(this.produits);
            let matriculeA = this.getMatriculeFromArray(this.EquipeA.commerciaux);
            let matriculeB = this.getMatriculeFromArray(this.EquipeB.commerciaux);
            this.classements.splice(0,this.classements.length);
            this.savePersonnelOnlocalStorage();
            axios.get('/api/personnels/getClassement',
                {
                    params: {
                        matriculeA: matriculeA,
                        matriculeB: matriculeB,
                        Produits: produits
                    }
                }).then(response => {
                //alert(this.EquipeA.commerciaux);
                if(response.data.resultatEquipeA!=null){
                    this.ClassementA = response.data.resultatEquipeA.classementReel;
                    this.ClassementDetailA = response.data.resultatEquipeA.classementDetail;
                    this.fillPlaceTemp(response.data.resultatEquipeA.classementReel);
                }
                if(response.data.resultatEquipeB!=null){
                    this.ClassementB = response.data.resultatEquipeB.classementReel;
                    this.ClassementDetailB = response.data.resultatEquipeB.classementDetail;
                    this.fillPlaceTemp(response.data.resultatEquipeB.classementReel);
                }
                if((response.data.resultatEquipeB!=null)||((response.data.resultatEquipeB!=null))){
                    this.toogleClassementsView();
                }
            });
        },
        savePersonnelOnlocalStorage(){
            if(this.EquipeA){
                localStorage.EquipeA = JSON.stringify(this.EquipeA);
            }
            if(this.EquipeB){
                localStorage.EquipeB = JSON.stringify(this.EquipeB);
            }
        },
        recalculPlace(Classement){
            let newClassement = [];
            for(let i=0;i<Classement.length;i++){
                newClassement.push(Classement[i]);
                newClassement[i].placeTemp = i+1;
                newClassement[i].place = i+1;
            }
            for(let i=0;i<Classement.length;i++){
                Classement.splice(i,1,newClassement[i]);
            }
        },
        changeClassement(Classement,place,placeTemp){
            if((placeTemp<1)||(placeTemp>Classement.length)){
                alert("changement de place impossible");
                Classement[place-1].placeTemp = place;
            }                        
            else{
                let elementTemp = Classement[place-1];
                Classement.splice(place-1,1);
                Classement.splice(placeTemp-1, 0, elementTemp);
                this.recalculPlace(Classement);
            }
            alert(JSON.stringify(Classement));
        },
        // search perso
        loadFonctions(){
            this.$axios.get('/api/fonctions') 
            .then(response => {
                if(response.data.success){
                    this.fonctions = response.data.fonctions;
                    this.idFonction = this.fonctions[0].id;
                    this.customId = this.fonctions[0].customId;
                }
                else{
                    console.log(response.data.message);
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        },
        searchAutoComplete(){
            this.resultats = [];
            if(this.customId == null){
                axios.get('/api/personnels/getMatriculeByFonction',{params: {fonction: this.idFonction,search: this.matricule}}).then(response => {
                    this.isSearchingAutoComplete = false;
                    if(response.data.success){
                        this.resultats = response.data.personnels;
                    }
                    else{
                        alert(response.data.message);
                    }
                });
            }
            else{
                this.customId.forEach(element => {
                    axios.get('/api/personnels/getMatriculeByFonction',{params: {fonction: element,search: this.matricule}}).then(response => { 
                        if(response.data.success){
                            this.resultats = this.resultats.concat(response.data.personnels);
                        }
                        else{
                            alert(response.data.message);
                        }
                    });
                });
                this.isSearchingAutoComplete = false;
            }
        },
        addToEquipe(personnel){
            if(this.selectedTeam=="A"){
                this.addPersonnelToTable(this.EquipeA.commerciaux,personnel);
            }
            else{
                this.addPersonnelToTable(this.EquipeB.commerciaux,personnel);
            }
        },
        addToCoachEquipe(personnel){
            if(this.selectedTeam=="A"){
                this.addPersonnelToTable(this.EquipeA.coachs,personnel);
            }
            else{
                this.addPersonnelToTable(this.EquipeB.coachs,personnel);
            }
        },
        addPersonnel(){
            if(this.customId == null){
                if((this.matricule!=null)&&(this.idFonction!=null)){
                    axios.get('/api/personnels/getFirstWhere',{params: {criteres: {Fonction_actuelle: this.idFonction,Matricule: this.matricule}}}).then(response => {
                        if(response.data.success){
                            if(response.data.personnel.Fonction_actuelle == 2){
                                if(this.coachs.length > (this.maxCoach-1)){
                                    alert("il existe deja un coach");
                                }else{
                                    this.addToCoachEquipe(response.data.personnel)
                                    this.addEquipeFromCoach(response.data.personnel);
                                }
                            }else{
                                if(this.commerciaux.length > (this.maxCommerciaux-1)){
                                    alert("la limite de commerciaux :"+this.maxCommerciaux+" est deja atteinte");
                                }else{
                                    this.addToEquipe(response.data.personnel);
                                }
                            }
                        }
                        else{
                            alert('aucun resultat trouvé');
                        }
                    });
                }
            }else{
                this.customId.forEach(element => {
                    axios.get('/api/personnels/getFirstWhere',{params: {criteres: {Fonction_actuelle: element,Matricule: this.matricule}}}).then(response => {
                        if(response.data.success){
                            if(response.data.personnel.Fonction_actuelle == 2){
                                if(this.coachs.length > (this.maxCoach-1)){
                                    alert("il existe deja un coach");
                                }else{
                                    this.addToCoachEquipe(response.data.personnel)
                                    this.addEquipeFromCoach(response.data.personnel);
                                }
                            }else{
                                if(this.commerciaux.length > (this.maxCommerciaux-1)){
                                    alert("la limite de commerciaux :"+this.maxCommerciaux+" est deja atteinte");
                                }else{
                                    this.addToEquipe(response.data.personnel);
                                }
                            }
                        }
                    });  
                });
            }
        },
        addPersonnelToTable(table,personnel){
            let exist = false
            table.forEach(element => {
                if(element.Matricule == personnel.Matricule){
                    exist = true;
                }
            });
            if(exist){
                alert(personnel.Matricule+" est deja present");
            }
            else{
                table.push(personnel);
            }
        },
        //addEquipeFromCoach(coach){
        addEquipeFromCoach(coach){
            //this.addPersonnelToTable(this.coachs,coach);
            /*
            if(coach!=''){
                axios.get('/api/personnels/getPersonnelFromCoach',{params: {coach: coach.Matricule,idMission: this.idMission}}).then(response => {
                    for(let i=0;i<response.data.data.length;i++){
                        if(this.commerciaux.length>=this.maxCommerciaux){
                            
                        }
                        else if(response.data.data[i].Matricule!=coach.Matricule){
                            this.addToEquipe(response.data.data[i]);
                        }
                    }
                });
            }
            EquipeA: {
                coachs : [],
                commerciaux : []
            },
            */
            
            if(this.selectedTeam=="A"){
                axios.get('/api/personnels/getPersonnelFromCoach',{params: {coach: coach.Matricule,idMission: this.idMission}}).then(response => {
                    for(let i=0;i<response.data.data.length;i++){
                        if(this.EquipeA.commerciaux.length>=this.maxCommerciaux){
                            
                        }
                        else if(response.data.data[i].Matricule!=coach.Matricule){
                            this.addToEquipe(response.data.data[i]);
                        }
                    }
                });
            }
            else{
                axios.get('/api/personnels/getPersonnelFromCoach',{params: {coach: coach.Matricule,idMission: this.idMission}}).then(response => {
                    for(let i=0;i<response.data.data.length;i++){
                        if(this.EquipeB.commerciaux.length>=this.maxCommerciaux){
                            
                        }
                        else if(response.data.data[i].Matricule!=coach.Matricule){
                            this.addToEquipe(response.data.data[i]);
                        }
                    }
                });
            }
        },
        // search perso
    },   
    components: {
        EquipeTab,
        SearchPersonnel,
        SearchProduit,
        ProduitTab,
        ClassementTab
    }

}

</script>