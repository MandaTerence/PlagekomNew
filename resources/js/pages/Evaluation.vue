<template>
    <div v-if="!showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <h2 class="text-white pb-2 fw-bold">Evaluation du Personnel</h2>
            </div>
        </div>
        <div class="page-inner">
            <div v-if="!showClassements">
                <h2 class="text-center">
                    <span style="background-color:#f9fbfd">Recherche</span>
                </h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="card">
                    <div class="card-body">
                        <h3>Recherche de personnel</h3>
                        <hr/>
                        <div class="row" id="rechercheNormal">
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
                            <!--<div class="row">
                                <button class=" col-3 col-xs-6 btn btn-secondary btn-round">
                                    recherche par produit
                                </button>
                                <button class=" col-3 col-xs-6 btn btn-secondary btn-round">
                                    intervale de date
                                </button>
                                <button class=" col-3 col-xs-6 btn btn-secondary btn-round">
                                    Date a exclure
                                </button>
                                <button class=" col-3 col-xs-6 btn btn-secondary btn-round">
                                    Taux de vente
                                </button>
                            </div>
                            -->

                            <div>
                                <hr/>
                                    <h4 v-on:click="toogleAdvancedView(0)" >Recherche par Produit</h4>
                                <div class="row" v-if="advancedSearchDisplay[0]">
                                    <div class="col-12">
                                        <SearchProduit v-model:produits="produits"/>
                                    </div>
                                    <div class="col-12">
                                        <ProduitTab v-model:produits="produits"/>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <hr/>
                                    <h4 v-on:click="toogleAdvancedView(1)">Intervale de date</h4>
                                <div class="row" v-if="advancedSearchDisplay[1]">
                                    <div class="form-group col-sm-6">
                                        <label for="inputDateDebut">date de debut</label>
                                        <input class="form-control"  type="Date" placeholder="date debut" v-model="dateDebut">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="inputDateFin">date de fin</label>
                                        <input class="form-control"  type="Date" placeholder="date fin" v-model="dateFin">
                                    </div>  
                                </div>
                            </div>
                            <div>
                                <hr/>
                                    <h4 v-on:click="toogleAdvancedView(2)">Date a exclure</h4>
                                <div class="row" v-if="advancedSearchDisplay[2]">
                                    <div class="form-group col-6">
                                        <label for="inputDateDebut">date a exclure</label>
                                        <input class="form-control"  type="Date" placeholder="date debut" v-model="dateExclu">    
                                    </div>
                                    <div class="form-group col-6">
                                        <button v-on:click="addDateExclu()" class="btn btn-secondary form-control" style="margin-top:30px">
                                            Ajouter
                                        </button>
                                    </div>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-hover">
                                            <thead >
                                                <tr v-if="listeDateExclu.length>0" class="bg-secondary" style="color:white">
                                                    <th scope="col-2">date</th>
                                                    <th scope="col-2"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="date in listeDateExclu" v-bind:key="date">
                                                    <td scope="col-md-2">{{ date }}</td>
                                                    <td scope="col-md-2">
                                                        <button class="btn btn-danger" v-on:click="removeDateExclu(date)">supprimer</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>    
                            <div>
                                <hr/>
                                    <h4 v-on:click="toogleAdvancedView(3)">Taux de vente</h4>
                                <div class="row" v-if="advancedSearchDisplay[3]">
                                    <div class="form-group col-sm-6">
                                        <label for="pourcentage">pourcentage</label>
                                        <input class="form-control"  type="number" v-model="pourcentage" v-on:change="changePourcentage">
                                    </div> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="text-center"><span style="background-color:#f9fbfd">Resultat</span></h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="card">
                    <div class="card-body">
                        <div class="row d-flex justify-content-center" id="resultCommerciaux" >
                            <div class="table-responsive col-12" style="margin-left:25px">
                                <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                    <thead >
                                        <tr class="bg-secondary" style="color:white">
                                            <th class="respText" scope="col-md-2">matricule</th>
                                            <th class="respText" scope="col-md-2 d-none">nom et prenom</th>
                                            <th class="respText" scope="col-md-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="equipe in commerciaux" v-bind:key="equipe">
                                            <td class="respText" scope="col-md-2">{{ equipe.Matricule }}</td>
                                            <td class="respText" scope="col-md-2">{{ equipe.Nom+equipe.Prenom }}</td>
                                            <td class="respText" scope="col-md-1">
                                                <button class="btn btn-danger" v-on:click="remove(equipe.Matricule)">
                                                <div class="d-none d-lg-block">
                                                    supprimer
                                                </diV>
                                                <div class="d-block d-lg-none">
                                                    X
                                                </div>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <div v-if="showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <h2 class="text-white pb-2 fw-bold">Classements</h2>
            </div>
        </div>
        <div class="page-inner"> 
            <!-- v-model:classements="classements" v-model:classementReel="classementReel"/> -->
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                            <thead >
                                <tr class="bg-secondary" style="color:white">
                                    <th class="respText" >Place</th>
                                    <th class="respText" >Matricule</th>
                                    <th class="respText" >Nom et Prenom</th>
                                    <th class="respText" >CA Mission (en Ar)</th>
                                    <th class="respText" >CA Local (en Ar)</th>
                                    <th class="respText" >CA Total (en Ar)</th>
                                    <th class="respText" >ratio de vente</th>
                                    <th class="respText" >assuidite</th>
                                    <th class="respText" >statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="personnel in classements" v-bind:key="personnel">
                                    <td class="respText" >{{ personnel.place }}</td>
                                    <td class="respText" >{{ personnel.Matricule }}</td>
                                    <td class="respText" >{{ personnel.Nom+" "+personnel.Prenom }}</td>
                                    <td class="respText" >{{ personnel.CAMission }}</td>
                                    <td class="respText" >{{ personnel.CALocal }}</td>
                                    <td class="respText" >{{ personnel.CAGlobal }}</td>
                                    <td class="respText" >{{ personnel.pourcentageObjectif.toFixed(2) }}%</td>
                                    <td class="respText" >{{ personnel.assuidite.toFixed(2) }}%</td>
                                    <td class="respText" style="color:green" v-if="personnel.etatVente=='Qualifier'" >{{ personnel.etatVente }}</td>
                                    <td class="respText" style="color:red" v-else="" >{{ personnel.etatVente }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6 d-flex justify-content-start">
                    <button class="btn btn-secondary btn-round" v-on:click="retourClassement">retour </button>
                </div>
                <div class="col-6 d-flex justify-content-end">
                     <button class="btn btn-secondary btn-round" v-on:click="validateEquipe">Valider</button>
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
            idMission: "n",

            idProduit: null,

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

            pourcentage: '30',
            minimumVente: 0
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
        this.loadAdvencedSearchData();
    },
    methods: {
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
            if(this.idMission){
                axios.get('/api/missions/getTaux',{params: {idMission: this.idMission}}).then(response => {
                    this.minimumVente = response.data.taux;
                });
            }
        },
        changeIdMission(){
            alert("Vous avez choisit la mission : "+this.idMission);
            this.loadTauxVente();
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
            this.$axios.get('/api/missions',{params: {criteres: {Statut: 'En_cours'}}}) 
            .then(response => {
                if(response.data.success){
                    this.missions = response.data.missions;
                    this.idMission = this.missions[0].Id_de_la_mission;
                    this.loadTauxVente();
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
                /*
                Matricules: matricules,
                Produits: produits,
                
                dateDebut: this.dateDebut,
                dateFin: this.dateFin,

                listeDateExclu: this.listeDateExclu,

                pourcentage: this.pourcentage,
                minimumVente: this.minimumVente
                */
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
            this.addPersonnelToTable(this.commerciaux,personnel);
        },
        addPersonnel(){
            if(this.customId == null){
                if((this.matricule!=null)&&(this.idFonction!=null)){
                    axios.get('/api/personnels/getFirstWhere',{params: {criteres: {Fonction_actuelle: this.idFonction,Matricule: this.matricule}}}).then(response => {
                        if(response.data.success){
                            if(response.data.personnel.Fonction_actuelle == 2){
                                //this.addToCoachEquipe(response.data.personnel);
                                this.addEquipeFromCoach(response.data.personnel);
                            }else{
                                this.addToEquipe(response.data.personnel);
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
                                //this.addToCoachEquipe(response.data.personnel)
                                this.addEquipeFromCoach(response.data.personnel);
                            }else{
                                this.addToEquipe(response.data.personnel);
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