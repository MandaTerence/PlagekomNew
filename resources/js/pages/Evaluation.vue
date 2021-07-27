<template>
    <div v-if="!showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <h2 class="text-white pb-2 fw-bold">Evaluation du Commerciale</h2>
            </div>
        </div>
        <div v-if="showModal.detailPersonnel" @close="showModal.detailPersonnel = false">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container card">
                            <div class="modal-body card-body">
                                <slot name="body">
                                    <div class="row justify-content-center">
                                        <h3>{{ selectedCommercial.Matricule }}</h3>
                                    </div>
                                    <div class="row justify-content-center">
                                        <h4>évaluation du {{ dateDebut }} à {{ dateFin }} ({{ nbrDeJourIntervale }} jours)</h4>
                                    </div>
                                    <div class="row">
                                        <table class="table">
                                            <tr>
                                                <th>
                                                    Chiffre d'Affaire Mission
                                                </th>
                                                <td class="text-right">
                                                    {{ getMoneyFormat(selectedCommercial.CAMission) }} Ar
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Chiffre d'Affaire Local
                                                </th>
                                                <td class="text-right">
                                                    {{ getMoneyFormat(selectedCommercial.CALocal) }} Ar
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Chiffre d'Affaire
                                                </th>
                                                <td class="text-right">
                                                    {{ getMoneyFormat(selectedCommercial.CAGlobal) }} Ar
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Chiffre d'Affaire Moyen par jour
                                                </th>
                                                <td class="text-right">
                                                    {{ getMoneyFormat(selectedCommercial.CAMoyen) }} Ar
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </slot>
                            </div>
                            <div class="modal-footer card-footer">
                                <slot name="footer">
                                default footer
                                <button class="modal-default-button" @click="showModal.detailPersonnel = false">
                                    OK
                                </button>
                                </slot>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="page-inner">
            <h2 class="text-center">
                <span style="background-color:#f9fbfd">Recherche</span>
            </h2>
            <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="card">
                <div class="card-header">
                    Recherche
                </div>
                <div class="card-body">
                    <div class="row" id="parametreMission">
                        <div class="col-md-6 form-group">
                            <label for="inputTypeMission">Type mission</label>
                            <select class="form-control " id="inputTypeMission" v-model="idMission" v-on:change="changeIdMission">
                                <option v-bind:key="mission.Id" v-bind:value="mission.Id" v-for="mission in missions">{{ mission.designation }}</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 form-group">
                            <label for="inputDateDebut">date de debut</label>
                            <input class="form-control"  type="Date" id="inputDateDebut" v-model="dateDebut">
                        </div>
                        <div class="col-md-3 col-sm-6 form-group">
                            <label for="inputDateFin">date de fin</label>
                            <input class="form-control"  type="Date" id="inputDateFin"  v-model="dateFin">
                        </div>
                    </div>
                    <hr/>
                    <div class="row" id="dateAExclure">
                        <div class="col-6 form-group">
                            <label>Date a exclure</label>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input class="form-control" type="Date" id="inputDateFin"  v-model="dateExclu"> 
                                </div>
                                <div class="col-6 form-group">
                                    <button v-on:click="addDateExclu()" class="btn btn-secondary form-control col-6">
                                        Exclure
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="listeDateExclu.length>0" class="row">
                        <div class="col-6 form-group">
                            <label>liste des dates éxclus</label>
                        </div>
                    </div>
                    <div id="listeDateExclu" class="row">
                        <div v-for="date in listeDateExclu" class="col-3">
                            <div style="margin-top:5px" class="btn btn-primary btn-border btn-block">
                                {{ date }}
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row" id="tauxDeVente">
                        <div class="col-6 form-group">
                            <label>pourcentage minimale de vente par jour</label>
                        </div>
                        <div class="col-6 form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">plus de</span>
                                </div>
                                <input class="form-control"  type="number" v-model="pourcentage" v-on:change="changePourcentage">
                                <div class="input-group-append">
                                    <span class="input-group-text">% des ventes</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row" id="produit">
                        <div class="col-6 form-group">
                            <label>Produits utilisés</label>
                        </div>
                        <div class="col-6">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input class="form-control" type="text" id="produitDesignation" v-model="produitDesignation" v-on:keyup="autoCompleteProduit" v-on:click="autoCompleteProduit"> 
                                    <div class="panel-footer" style="float:top;position: absolute;z-index: 1;">
                                        <ul class="list-group">
                                            <li class="list-group-item" v-for="result in resultats" v-bind:key="result" v-on:click.left="changeProduit(result.Designation)" >
                                                <div >{{ result.Designation }}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-6 form-group">
                                    <button v-on:click="addProduit()" class="btn btn-secondary form-control col-6">
                                        ajouter
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="listeProduit" class="row">
                        <div v-for="produit in produits" class="col-3">
                            <div style="margin-top:5px" class="btn btn-primary btn-border btn-block">
                                {{ produit.Code_produit }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row" >
                        <div class="col-12 text-center">
                            <button v-on:click="getProposition" class="btn btn-primary btn-rounded">Proposer</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h6>
                        Resultat
                    </h6>
                </div>
                <div class="card-body">

                        <div class="form-group">

                            <label for="RecherchePersonnel">
                                Recherche de Personnel
                            </label>
                            <div class="input-group">
                                <input type="text" id="RecherchePersonnel" placeholder="Matricule" class="form-control" v-model="matriculeClassement" v-on:keyup="autoComplete('classement',matriculeClassement,resultMatriculeClassement)" v-on:click="autoComplete('classement',matriculeClassement,resultMatriculeClassement)">
                                <div class="panel-footer" style="float:top;position: absolute;z-index: 1;width: -moz-available;">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="result in resultMatriculeProposition" v-bind:key="result" v-on:click.left="changeMatriculeValue(result.Matricule)" >
                                            <div >{{ result.Matricule }}</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="input-group-append">
                                    <button v-on:click="addPersonnel" class="btn btn-primary" type="button">
                                        ajouter
                                    </button>
                                </div>
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <label for="rechercheEnGros">
                                Insertion en gros
                            </label>
                            <div class="input-group">
                                <textarea id="rechercheEnGros" aria-label="With textarea" placeholder="ex: VP00000,VP00001,VP00002... " v-model="listeMatricule" class="col-12 form-control input-sm"></textarea>
                            </div>
                        </div>
                        <div class="row input-group d-flex justify-content-center" style="margin-bottom:20px">
                            <button v-on:click="addListePersonnel" class="btn btn-primary btn-rounded" type="button">
                                ajouter
                            </button>
                        </div>
                    <div class="row" id="resultatProposition">
                        <div class="col-md-6 card" style="border-color: blue;">
                            <div class="card-header">
                                propositions
                            </div>
                            <div class="card-body">
                                <div v-if="propositions.length>0" class="row d-flex justify-content-center" style="margin-bottom:20px">
                                    <select class="col-12 form-control input-sm" v-model="filtreProposition" v-on:change="filtrer(filtreProposition,propositions)">
                                        <option value="mp" selected>meilleur proposition</option>
                                        <option value="cal">meilleur de chiffre d'affaire</option>
                                        <option value="cam">meilleur moyenne de chiffre d'affaire moyen</option>
                                        <option value="cal">meilleur chiffre d'affaire local</option>
                                        <option value="cami">meilleur chiffre d'affaire mission</option>
                                        <option v-if="(missionChoix!='')" value="cat">meilleur chiffre d'affaire {{ missionChoix }}</option>
                                    </select>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-head-bg-primary table-bordered-bd-primary">
                                        <thead v-if="propositions.length>0">
                                            <tr>
                                                <th style="font-size:11px" >matricule</th>
                                                <th style="font-size:11px" >nom</th>
                                                <th style="font-size:11px" ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="proposition in propositions">
                                                <td style="font-size:11px" >{{ proposition.Matricule }}</td>
                                                <td style="font-size:11px" v-on:click="showDetailCommercial(proposition)">{{ proposition.Nom+" "+proposition.Prenom }}</td>
                                                <td style="font-size:11px" ><button class="btn btn-success btn-sm" v-on:click="validateProposition(proposition)">ajouter</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 card" style="border-color: green;">
                            <div class="card-header">
                                personnels validés
                            </div>
                            <div class="card-body">
                                <div v-if="classements.length>0" class="row input-group d-flex justify-content-center" style="margin-bottom:20px">
                                    <select class="col-12 form-control input-sm" v-model="filtreClassement" v-on:change="filtrer(filtreClassement,classements)">
                                        <option value="mp" selected>meilleur proposition</option>
                                        <option value="cal">meilleur de chiffre d'affaire</option>
                                        <option value="cam">meilleur moyenne de chiffre d'affaire moyen</option>
                                        <option value="cal">meilleur chiffre d'affaire local</option>
                                        <option value="cami">meilleur chiffre d'affaire mission</option>
                                        <option v-if="(missionChoix!='')" value="cat">meilleur chiffre d'affaire {{ missionChoix }}</option>
                                    </select>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hover table-head-bg-success table-bordered-bd-success" >
                                        <thead v-if="classements.length>0">
                                            <tr>
                                                <th style="font-size:11px" >matricule</th>
                                                <th style="font-size:11px" >nom</th>
                                                <th style="font-size:11px" ></th>
                                                <th style="font-size:11px" ></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="classement in classements">
                                                <td style="font-size:11px" >{{ classement.Matricule }}</td>
                                                <td style="font-size:11px" v-on:click="showDetailCommercial(classement)">{{ classement.Nom+" "+classement.Prenom }}</td>
                                                <td style="font-size:11px" >
                                                    <input type="number" v-model="classement.placeTemp" v-on:change="changeClassement(classements,classement.place,classement.placeTemp)"/>
                                                </td>
                                                <td style="font-size:11px" ><button class="btn btn-danger btn-sm" v-on:click="removeClassement(classement)">supprimer</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center" id="barreAction">
                        <button class="btn btn-success btn-rounded" v-on:click="exportEquipe">
                            exporter XLS
                        </button>
                    </div>
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
            showAdvancedSearch: true,
            maxCoach:1,
            maxCommerciaux:8,
            showModal: {
                "detailPersonnel": false
            },
            selectedCommercial: '',


            matricule: '',

            matriculeProposition: '',
            matriculeClassement: '',
            resultMatriculeProposition: '',
            resultMatriculeClassement: '',

            fonctions: [],
            missions: [],

            commerciaux: [],
            coachs: [],
            produits: [],

            propositions:[],

            idFonction: null,
            idMission: "n",
            missionChoix: "",

            produitDesignation: "",
            idProduit: null,

            isSearchingProduit: false,

            customId: null,

            resultats: [],
            classements: [],
            classementReel: [],

            buttonTeamA: "btn btn-secondary btn-border",
            buttonTeamB: "btn btn-secondary",
            
            advancedSearchDisplay:
            [false,false,false,false],

            dateDebut: '',
            dateFin: '',

            dateExclu: '',
            listeDateExclu: [],

            pourcentage: '70',
            minimumVente: 0,

            filtreProposition: 'mp',
            filtreClassement:  'mp',

            listeMatricule: ''
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
        nbrDeJourIntervale: function() {
            var Difference_In_Time = new Date(this.dateFin).getTime() - new Date(this.dateDebut).getTime();
            var Difference_In_Days = Difference_In_Time / (1000 * 3600 * 24);
            return Difference_In_Days;
        }
    },
    created() {
        this.loadMissions();
        this.loadFonctions();
        this.loadLocalData();
        this.loadAdvencedSearchData();
    },
    methods: {
        addListePersonnel(){
            let matricules=[];
            let tableMatricule = this.listeMatricule.split(",");
            let produits =  this.getCodeProduitFromArray(this.produits);
            
            tableMatricule.forEach((matricule, index) => {
                matricules.push(matricule.trim());
            })
            

            if(matricules.length>0){
                matricules.forEach((matricule, index) => {
                    if(matricule.length>0){
                        axios.get('/api/personnels/getFirstForEvaluation',{params: {
                            idType: this.idMission,
                            dateDebut: this.dateDebut,
                            dateFin: this.dateFin,
                            produits: produits,
                            listeDateExclu: this.listeDateExclu,
                            matricule: matricule,
                        }})
                        .then(response => {
                            if(response.data.success){
                                let p = response.data.personnel;
                                p.placeTemp = this.classements.length+1;
                                this.classements.push(p);
                                this.filtrer(this.filtreProposition,this.propositions);
                            }
                        })
                    }
                })
            }

            
        },
        getMoneyFormat(monnaie){
            if(monnaie)
                return monnaie.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
            else
                return 0;
        },
        showDetailCommercial(commercial){
            this.selectedCommercial = commercial;
            this.showModal.detailPersonnel=true;
        },
        autoCompleteProduit(){
            if((this.produitDesignation.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingProduit = true;
                if(this.produitDesignation != null ){
                    setTimeout(this.searchProduitAutoComplete, 1000);
                }
            } 
        },
        getProposition(){
            let produits =  this.getCodeProduitFromArray(this.produits);
            axios.get('/api/personnels/getProposition',{params: {
                idType: this.idMission,
                dateDebut: this.dateDebut,
                dateFin: this.dateFin,
                produits: produits,
                listeDateExclu: this.listeDateExclu,
                
            }}).then(response => {
                //this.fillPlaceTemp(response.data.propositions);
                //this.propositions = response.data.propositions;
                for(let i=0;i<response.data.propositions.length;i++){
                    this.addProposition(response.data.propositions[i]);
                }
                let miss = this.getMissionFromId(this.idMission);
                if(miss!=""){
                    this.missionChoix = miss.designation;
                }
            });
        },
        filtrer(critere,presonnels){
            if(critere=="ca"){
                presonnels.sort(function(a, b) {
                    return b.CAGlobal - a.CAGlobal;
                });
            }
            else if(critere=="cam"){
                presonnels.sort(function(a, b) {
                    return b.CAMoyen - a.CAMoyen;
                });
            }
            else if(critere=="cami"){
                presonnels.sort(function(a, b) {
                    return b.CAMission - a.CAMission;
                });
            }
            else if(critere=="cal"){
                presonnels.sort(function(a, b) {
                    return b.CALocal - a.CALocal;
                });
            }
            else{
                presonnels.sort(function(a, b) {
                    return b.CATotal - a.CATotal;
                });
            }
        },
        addProposition(personnel){
            for(let i=0;i<this.propositions.length;i++){
                if(personnel.Matricule==this.propositions[i].Matricule){
                    return;
                }
            }
            this.propositions.push(personnel);
        },
        getMissionFromId(idMission){
            this.missions.forEach((mission, index) => {
                if(mission.id==idMission){
                    return mission;
                }
            })
            return "";
        },
        searchProduitAutoComplete(){
            this.resultats = [];
            if(this.customId == null){
                axios.get('/api/produits/getProduitByDesignation',{params: {Designation: this.produitDesignation}}).then(response => {
                    this.isSearchingAutoComplete = false;
                    if(response.data.success){
                        this.resultats = response.data.produits;
                    }
                    else{
                        alert(response.data.message);
                    }
                });
            }
        },
        addProduit(){
            let produitExist = false;
            for(let i=0;i<this.produits.length;i++){
                if(this.produits[i].Designation == this.produitDesignation){
                    produitExist = true;
                    break;
                }
            }
            if(!produitExist){
                axios.get('/api/produits/getFirst',{params: {criteres: {Designation: this.produitDesignation}}}).then(response => {
                    if(response.data.success){
                        this.produits.push(response.data.produit);
                        this.produitDesignation = "";
                    }
                    else{
                        alert('aucun resultat trouvé');
                    }
                });
            }
            else{
                alert('ce produit a deja etait ajouter');
            }
        },
        changeProduit(designation){
            this.resultats = [];
            this.produitDesignation = designation;
        },
        remove(matricule){
            for( var i = 0; i < this.commerciaux.length; i++){ 
                if ( this.commerciaux[i].Matricule ==  matricule) { 
                    this.commerciaux.splice(i, 1);
                    i--; 
                }
            }
        },
        toogleAdvancedView(place){
            this.advancedSearchDisplay[place]=!this.advancedSearchDisplay[place];
        },
        addDateExclu(){
            if(this.dateExclu==""){
                alert("veuillez inserer une date valide")
            }
            else if(this.listeDateExclu.includes(this.dateExclu)){
                alert("la date "+this.dateExclu+" est deja exclu");
            }
            else{
                this.listeDateExclu.push(this.dateExclu);
                this.dateExclu = "";
            }
            
        },
        removeDateExclu(date){
            for(let i=0;i<this.listeDateExclu.length;i++){
                if(this.listeDateExclu[i] == date){
                    this.listeDateExclu.splice(i, 1);
                }
            }
        },
        changeMinimumVente(){
            if(this.minimumVente<0){
                alert("valeur de vente incorrect");
                this.minimumVente=0;
            }
        },
        changePourcentage(){
            if((this.pourcentage<0)||(this.pourcentage>100)){
                alert("valeur de pourcentage incorrect");
                this.pourcentage=30;
            }
        },
        loadTauxVente(){
            /*
            if(this.idMission){
                axios.get('/api/missions/getTaux',{params: {idMission: this.idMission}}).then(response => {
                    this.minimumVente = response.data.taux;
                });
            }*/
        },
        changeIdMission(){
            //alert("Vous avez choisit la mission : "+this.idMission);
            //this.loadTauxVente();
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
        dateToString(today){
            var dd = today.getDate();

            var mm = today.getMonth()+1; 
            var yyyy = today.getFullYear();
            if(dd<10) 
            {
                dd='0'+dd;
            } 

            if(mm<10) 
            {
                mm='0'+mm;
            }
            return yyyy+'-'+mm+'-'+dd;
        },
        loadAdvencedSearchData(){
            var today = new Date();
            var datePassee = new Date();
            datePassee.setDate(datePassee.getDate() - 30);
            this.dateDebut = this.dateToString(datePassee);
            this.dateFin = this.dateToString(today);
        },
        loadLocalData(){
            if(localStorage.getItem('classementReel') !== null){
                this.classementReel = JSON.parse(localStorage.classementReel);
                this.classements= JSON.parse(localStorage.classements);
                this.showClassements = true;
            }
        },
        toogleAdvancedSearch(){
            (this.showAdvancedSearch)?this.showAdvancedSearch = false: this.showAdvancedSearch = true;
        },
        loadMissions(){
            this.$axios.get('/api/missions/getAllTypesMission') 
            .then(response => {
                if(response.data.success){
                    this.missions = response.data.missions;
                    this.idMission = this.missions[0].Id;   //this.loadTauxVente();
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
            this.resultMatriculeClassement = [];
            this.matriculeClassement = newMatricule;
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
        /*
        autoComplete('classement',matriculeClassement,resultMatriculeClassement)
        */
        autoComplete(type,matricule,resultats){
            //alert(type);
            if(type=="classement"){
                if((matricule.length > 2)&&(!this.isSearchingAutoComplete)){
                    this.isSearchingAutoComplete = true;
                    setTimeout(this.searchAutoComplete(matricule,resultats), 1000);
                }  
            }
            else if(type=="proposition"){
                if((matricule.length > 2)&&(!this.isSearchingAutoComplete)){
                    this.isSearchingAutoComplete = true;
                    setTimeout(this.searchAutoComplete(matricule,resultats), 1000);
                }  
            }
        },
        searchAutoComplete(matricule,resultats){
            resultats = [];
            this.customId.forEach(element => {
                axios.get('/api/personnels/getMatriculeByFonction',{params: {fonction: element,search: matricule}}).then(response => { 
                    if(response.data.success){
                        this.resultMatriculeProposition = resultats.concat(response.data.personnels);
                    }
                    else{
                        alert(response.data.message);
                    }
                });
            });
            this.isSearchingAutoComplete = false;
        },
        exportEquipe(){
            let matricules = this.getMatriculeFromArray(this.classements);
            let produits =  this.getCodeProduitFromArray(this.produits);
            let data = {
                "excel":"evaluation",
                "Matricules":matricules, 
                "Produits": produits,
                
                "dateDebut": this.dateDebut,
                "dateFin": this.dateFin,

                "listeDateExclu": this.listeDateExclu,

                "pourcentage": this.pourcentage,
                "minimumVente": this.minimumVente

            };
            data = JSON.stringify(data);
            data ='/excel'+data
            axios.get(data,{
                responseType: 'blob',
            }).then(response => {
                
                this.download(response);
            });
        }, 
        validateEquipe(){
            let matricules = this.getMatriculeFromArray(this.commerciaux);
            let produits =  this.getCodeProduitFromArray(this.produits);
            let data = {
                "excel":"evaluation",
                "Matricules":matricules, 
                "Produits": produits,
                
                "dateDebut": this.dateDebut,
                "dateFin": this.dateFin,

                "listeDateExclu": this.listeDateExclu,

                "pourcentage": this.pourcentage,
                "minimumVente": this.minimumVente

            };
            data = JSON.stringify(data);
            data ='/excel'+data
            axios.get(data,{
                responseType: 'blob',
            }).then(response => {
                this.download(response);
            });
        },      
        download(data) {
            if(!data){
                return
            }
            var blob = new Blob([data.data], {type: 'application/vnd.ms-excel;charset=utf-8'})
            var url = window.URL.createObjectURL(blob);
            var aLink = document.createElement("a");
            aLink.style.display = "none";
            aLink.href = url;
            //aLink.setAttribute("Data Template", "Data Template.xls");
            document.body.appendChild(aLink)
            aLink.click()
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
        validateProposition(proposition){
            this.classements.forEach((classement, index) => {
                if(classement.Matricule.trim()==proposition.Matricule.trim()){
                    alert("le commercial "+classement.Matricule+" est deja present");
                    return;
                }
            })
            this.classements.push(proposition);
            this.classementReel.push(proposition);
            
            this.removeProposition(proposition);
            this.recalculPlace();
        },
        removeProposition(personnel){
            this.propositions.forEach((proposition, index) => {
                if(proposition.Matricule.trim() == personnel.Matricule.trim()){
                    this.propositions.splice(index,1);
                }
            })
        },
        removeClassement(personnel){
            this.classements.forEach((classement, index) => {
                if(classement.Matricule.trim() == personnel.Matricule.trim()){
                    this.classements.splice(index,1);
                }
            });
            this.classementReel.forEach((classement, index) => {
                if(classement.Matricule.trim() == personnel.Matricule.trim()){
                    this.classements.splice(index,0);
                }
            })
        },
        getClassement(){
            let matricules = this.getMatriculeFromArray(this.commerciaux);
            let produits =  this.getCodeProduitFromArray(this.produits);
            this.classements.splice(0,this.classements.length);
            axios.get('/api/personnels/getEvaluation',{params: {

                Matricules: matricules,
                Produits: produits,

                dateDebut: this.dateDebut,
                dateFin: this.dateFin,

                listeDateExclu: this.listeDateExclu,

                pourcentage: this.pourcentage,
                minimumVente: this.minimumVente

            }}).then(response => {
                this.showClassements = true;
                this.classements = response.data.classements;
                localStorage.classements = JSON.stringify(this.classements);
                this.fillPlaceTemp(response.data.classements);
                /*
                if(response.data.personnels!=null){
                    this.classements = response.data.classements;
                    localStorage.classements = JSON.stringify(this.classements);
                    this.fillPlaceTemp(response.data.classementsReel);
                    this.classementReel = response.data.classementsReel;
                    localStorage.classementReel = JSON.stringify(this.classementReel);
                }*/
            });
        },
        
        recalculPlace(){
            let newClassement = [];
            for(let i=0;i<this.classements.length;i++){
                newClassement.push(this.classements[i]);
                newClassement[i].placeTemp = i+1;
                newClassement[i].place = i+1;
            }
            for(let i=0;i<this.classements.length;i++){
                this.classements.splice(i,1,newClassement[i]);
            }
        },
        /*
        changeClassement(place,placeTemp){
            if((placeTemp<1)||(placeTemp>this.classements.length)){
                alert("changement de place impossible");
                this.classements[place-1].placeTemp = place;
            }                        
            else{
                let elementTemp = this.classements[place-1];
                this.classements.splice(place-1,1);
                this.classements.splice(placeTemp-1, 0, elementTemp);
                this.recalculPlace();
                localStorage.sclassements = JSON.stringify(this.classements);
                localStorage.classementReel = JSON.stringify(this.classementReel);
            }
        },
        */
        // search perso
        loadFonctions(){
            this.$axios.get('/api/fonctions') 
            .then(response => {
                if(response.data.success){
                    this.fonctions = response.data.fonctions;
                    this.idFonction = this.fonctions[0].id;
                    this.customId = this.fonctions[1].customId;
                }
                else{
                    console.log(response.data.message);
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        },
        
        addToEquipe(personnel){
            this.addPersonnelToTable(this.commerciaux,personnel);
        },
        addPersonnel(matricule){
            let produits =  this.getCodeProduitFromArray(this.produits);
            axios.get('/api/personnels/getFirstForEvaluation',{params: {
                idType: this.idMission,
                dateDebut: this.dateDebut,
                dateFin: this.dateFin,
                produits: produits,
                listeDateExclu: this.listeDateExclu,
                matricule: this.matriculeClassement,
            }})
            .then(response => {
                if(response.data.success){
                    let p = response.data.personnel;
                    p.placeTemp = this.classements.length+1;
                    this.classements.push(p);
                    this.filtrer(this.filtreProposition,this.propositions);
                }
            })
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