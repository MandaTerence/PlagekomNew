<template>
    <div v-if="!showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <ul class="breadcrumbs text-white d-none d-sm-block" style="margin-left: -40px">
                    <li class="nav-item">
                        <i class="fas fa-users"></i>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <span class="text-white">Planning et Accompagnement</span>
                    </li>
                    <li class="separator">
                        <i class="flaticon-right-arrow"></i>
                    </li>
                    <li class="nav-item">
                        <span class="text-white" >Creation d'equipe</span>
                    </li>
                </ul>
                <h2 class="text-white pb-2 fw-bold" style="margin-top: 40px">Creation d'equipe</h2>
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
                <div class="card-body">
                    <div class="row" style="margin-left:20px">
                        <div id="listeButtonEquipe" class="col-9 text-justify-content-start">
                            <div v-bind:class="getButtonClass(index)" v-for="(equipe, index) in Equipes">
                                <span v-on:click="toogleAvtiveTeamButton(index)">
                                    Equipe {{ index+1 }}
                                </span>
                                <a v-if="Equipes.length>1" v-on:click="removeEquipe(index)" style="margin-left:20px">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div id="listeButtonEquipe" class="col-3 text-justify-content-end">
                            <button v-on:click="ajouterNouveauEquipe" class="btn btn-secondary btn-border btn-rounded">
                                ajouter
                            </button>
                        </div>
                        <!-- OLD
                            <button v-bind:class="buttonTeamA" v-on:click="toogleAvtiveTeamButton(1)">
                                Equipe 1
                                </button>
                            <button v-bind:class="buttonTeamB" v-on:click="toogleAvtiveTeamButton(2)">
                                Equipe 2
                            </button>
                        -->
                    </div>
                    <div class="row">
                        <div class="table-responsive table-sm">
                            <div class="card-body">
                                <div class="row d-flex justify-content-center" id="resultCoach" >
                                    <div class="table-responsive col-12" style="margin-left:25px">
                                        <EquipeTab  v-model:equipes="equipeChoisit.coachs" titre="Coachs"/>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center" id="resultCommerciaux" >
                                    <div class="table-responsive col-12" style="margin-left:25px">
                                        <EquipeTab  v-model:equipes="equipeChoisit.commerciaux" titre="Commerciaux"/>
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div style="margin-top:30px">
                            <button class="btn btn-rounded btn-primary" v-on:click="getClassement">
                                lancer le classement
                            </button>
                        </div>
                    </div>
                    <!-- OLD
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
                    -->
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
                <div v-bind:class="classementHtmlClass" v-for="classement in classements">
                    <div v-if="classement.coach.length>0">
                        <div class="card-header row justify-content-center">
                            <h3>
                                Classement Proposé pour l'équipe du coach {{ classement.coach[0].Matricule }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex justify-content-center" style="margin-bottom:20px">
                                <select class="col-12 form-control input-sm" v-model="classement.filtre" v-on:change="filtrer(classement)">
                                    <option value="mp" selected>meilleur proposition</option>
                                    <option value="cal">meilleur de chiffre d'affaire</option>
                                    <option value="cam">meilleur moyenne de chiffre d'affaire moyen</option>
                                    <option value="cal">meilleur chiffre d'affaire local</option>
                                    <option value="cami">meilleur chiffre d'affaire mission</option>
                                    <!-- <option v-if="(missionChoix!='')" value="cat">meilleur chiffre d'affaire {{ missionChoix }}</option> -->
                                </select>
                            </div>
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
                                        <tr v-for="equipe in classement.classementReel" v-bind:key="equipe">
                                            <td class="respText" >{{ equipe.Matricule }}</td>
                                            <td class="respText" >{{ equipe.Nom }}</td>
                                            <td class="respText" >
                                                <input type="number" v-model="equipe.placeTemp" v-on:change="changeClassement(classement.classementReel,equipe.place,equipe.placeTemp)"/>
                                                <!--
                                                    v-on:change="changeClassement(ClassementA,equipe.place,equipe.placeTemp)"
                                                -->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!--  
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
                            -->
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

            selectedEquipe: 0,

            isLoadingData: false,

            Equipes: [
                {
                    coachs : [],
                    commerciaux : []
                },
                {
                    coachs : [],
                    commerciaux : []
                }
            ],

            EquipeA: {
                coachs : [],
                commerciaux : []
            },
            EquipeB: {
                coachs : [],
                commerciaux : []
            }
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
        },
        equipeChoisit: function (){
            if(this.Equipes.length>0){
                return this.Equipes[this.selectedEquipe];
            }
            return {
                coachs : [],
                commerciaux : []
            };
        },
        classementHtmlClass: function (){
            if(this.classements.length<2){
                return "card col-12";
            }
            return "card col-6";
        }
    },
    created() {
        this.loadMissions();
        this.loadFonctions();
        this.loadLocalData();
    },
    methods: {
        filtrer(classement){
            if(classement.filtre=="ca"){
                classement.classementReel.sort(function(a, b) {
                    return b.CAGlobal - a.CAGlobal;
                });
            }
            else if(classement.filtre=="cam"){
                classement.classementReel.sort(function(a, b) {
                    return b.CAMoyen - a.CAMoyen;
                });
            }
            else if(classement.filtre=="cami"){
                classement.classementReel.sort(function(a, b) {
                    return b.CAMission - a.CAMission;
                });
            }
            else if(classement.filtre=="cal"){
                classement.classementReel.sort(function(a, b) {
                    return b.CALocal - a.CALocal;
                });
            }
            else{
                classement.classementReel.sort(function(a, b) {
                    return b.CATotal - a.CATotal;
                });
            }
            for(let i= 0;i<classement.classementReel.length;i++){
                classement.classementReel[i].place = (i+1);
                classement.classementReel[i].placeTemp = (i+1);
            }
        },
        getClassement(){
            let produits =  this.getCodeProduitFromArray(this.produits);
            this.classements.splice(0,this.classements.length);
            let valide = true;
            for(let i=0;i<this.Equipes.length;i++){
                if(this.Equipes[i].coachs.length==0){
                    alert("il manque un coach pour l'equipe "+(i+1));
                    valide = false;
                    break;
                }
            }
            if(valide){
                this.isLoadingData = true;
                axios.get('/api/personnels/getClassement',
                    {
                        params: {
                            equipes: this.Equipes,
                            Produits: produits
                        }
                    }).then(response => {
                        let classements = response.data.resultat;
                        for(let i=0;i<classements.length;i++){
                            classements[i].filtre="mp";
                            for(let j= 0;j<classements[i].classementReel.length;j++){
                                classements[i].classementReel[j].placeTemp = classements[i].classementReel[j].place;
                            }
                        }
                        this.classements = classements;
                        this.toogleClassementsView();
                    }
                );
            }
        },
        removeEquipe(index){
            if(index==this.selectedEquipe){
                if(this.selectedEquipe>0){
                    this.selectedEquipe=index-1;
                }
            }
            this.Equipes.splice(index, 1);
        },
        ajouterNouveauEquipe(){
            let nouveauEquipe = {
                coachs : [],
                commerciaux : []
            };
            this.Equipes.push(nouveauEquipe);
        },
        getButtonClass(index){
            if(index==this.selectedEquipe){
                return "btn btn-secondary";
            }
            else{
                return "btn btn-secondary btn-border";
            }
        },
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
            this.loadEquipeFromMission();
        },
        loadEquipeFromMission(){
            this.isLoadingData = true;
            this.$axios.get('/api/missions/getEquipe',{params: {Id_de_la_mission: this.idMission }}) 
            .then(response => {
                this.selectedEquipe = 0;
                this.Equipes = response.data.equipes;
                this.isLoadingData = false;
            })
            .catch(function (error) {

            });
        },
        toogleAvtiveTeamButton(teamIndex){
            this.selectedEquipe = teamIndex;
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
                    this.loadEquipeFromMission();
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
            axios.post('/api/classements/',{
                matriculeCoach: coach[0].Matricule,
                matriculeCommerciaux: this.getMatriculeAndPlaceFromArray(equipe),
                idMission:this.idMission})
            .then(response => {
                /*
                if(response.data.success){
                    this.showModal = false;
                    //this.$router.push({ name: 'planning', query: { idMission: this.idMission ,coach: this.coach} });
                }
                else if(!response.data.success){
                    alert('insertion echoué');
                }*/
            });
        },
        validateAllEquipe(){
            for(let i=0;i<this.classements.length;i++){
                //alert(JSON.stringify(this.classements[i].classementReel))
                this.validateEquipe(this.classements[i].coach,this.classements[i].classementReel);
            }
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
        getMatriculesEquipes(){
            let matricules = [];
            for(let i=0;i<this.Equipes.length;i++){
                matricules.push(this.Equipes[i].commerciaux);
            }
            return matricules;
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
        },
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
            this.addPersonnelToTable(this.Equipes[this.selectedEquipe].commerciaux,personnel);
        },
        addToCoachEquipe(personnel){
            this.addPersonnelToTable(this.Equipes[this.selectedEquipe].coachs,personnel);
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
        addEquipeFromCoach(coach){
            axios.get('/api/personnels/getPersonnelFromCoach',{params: {coach: coach.Matricule,idMission: this.idMission}}).then(response => {
                for(let i=0;i<response.data.data.length;i++){
                    if(
                        (!(this.Equipes[this.selectedEquipe].commerciaux.length>=this.maxCommerciaux))
                        &&(response.data.data[i].Matricule!=coach.Matricule)
                    )
                    {
                        this.addToEquipe(response.data.data[i]);
                    }
                }
            });
        },
        test(){
            alert("test ok");
        }
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