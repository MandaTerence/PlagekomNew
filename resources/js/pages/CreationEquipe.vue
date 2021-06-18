<template>
    <div v-if="!showClassements">
        <div class="panel-header bg-secondary-gradient">
            <div class="page-inner py-4">
                <h2 class="text-white pb-2 fw-bold">Creation d'equipe</h2>
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
                            <div class="form-group col-12 col-md-3">
                                <label for="inputMission">Mission</label>
                                <select class="form-control " id="inputMission" v-model="idMission">
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
                    </div>
                </div>
                <h2 class="text-center"><span style="background-color:#f9fbfd">Resultat</span></h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="card">
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
                        <div class="row">
                            <button v-bind:class="buttonTeamA" v-on:click="toogleAvtiveTeamButton(1)">
                                Equipe 1
                             </button>
                            <button v-bind:class="buttonTeamB" v-on:click="toogleAvtiveTeamButton(2)">
                                Equipe 2
                            </button>
                        </div>
                        <div class="row">
                            <div class="table-responsive table-sm">
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
            <ClassementTab v-model:classements="classements" v-model:classementReel="classementReel"/>
            <button class="btn btn-secondary" v-on:click="retourClassement">retour </button>
            <button class="btn btn-secondary" v-on:click="validateEquipe">Valider</button>
            <div name="modal" v-if="showModal" @close="showModal = false">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-container">
                            <div class="modal-body">
                                <table class="table table-hover">
                                    <thead >
                                        <tr class="bg-secondary" style="color:white">
                                            <th scope="col-md-2">matricule</th>
                                            <th scope="col-md-2">nom et prenom</th>
                                            <th scope="col-md-2">C.A</th>
                                            <th scope="col-md-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="coach in coachs" v-bind:key="coach">
                                            <td scope="col-md-2">{{ coach.Matricule }}</td>
                                            <td scope="col-md-2">{{ coach.Nom+" "+coach.Prenom }}</td>
                                            <td scope="col-md-2">{{ coach.CA }}</td>
                                            <td scope="col-md-1">
                                                <button class="btn btn-danger" v-on:click="remove(coachs,coach.Matricule)">
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
                                <table class="table table-hover">
                                    <thead >
                                        <tr class="bg-secondary" style="color:white">
                                            <th scope="col-md-2">matricule</th>
                                            <th scope="col-md-2 d-none">nom et prenom</th>
                                            <th scope="col-md-2">C.A</th>
                                            <th scope="col-md-2">place</th>
                                            <th scope="col-md-1"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="classement in classements" v-bind:key="classement">
                                            <td scope="col-md-2" v-if="classement.place == classement.placeOriginal">{{ classement.Matricule }}</td>
                                            <td scope="col-md-2" style="color:red" v-else-if="classement.place > classement.placeOriginal">{{ classement.Matricule }} ({{  classement.placeOriginal - classement.place }} place)</td>
                                            <td scope="col-md-2" style="color:green" v-else>{{ classement.Matricule }} (+{{  classement.placeOriginal - classement.place }} place)</td>
                                            <td scope="col-md-2">{{ classement.Nom+classement.Prenom }}</td>
                                            <td scope="col-md-2">{{ classement.CA }}</td>
                                            <th scope="col-md-2">
                                                <input type="number" v-model="classement.placeTemp" v-on:change="changeClassement(classement.place,classement.placeTemp)"/>
                                            </th>
                                            <td scope="col-md-1">
                                                <button class="btn btn-danger" v-on:click="remove(classement,classement.Matricule)">
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
                            <div class="modal-footer">
                                <slot name="footer">
                                    <button class="btn btn-secondary" v-on:click="validateEquipe">Valider</button>
                                    <button class="btn btn-secondary" v-on:click="showModal = false">retour</button>
                                </slot>
                            </div>
                        </div>
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

            EquipeA: [],
            EquipeB: [],

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
    created() {
        this.loadMissions();
        this.loadFonctions();
        this.loadLocalData();
    },
    methods: {
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
        validateEquipe(){
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
            }
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
        addPersonnel(){
            if(this.customId == null){
                if((this.matricule!=null)&&(this.idFonction!=null)){
                    axios.get('/api/personnels/getFirstWhere',{params: {criteres: {Fonction_actuelle: this.idFonction,Matricule: this.matricule}}}).then(response => {
                        if(response.data.success){
                            if(response.data.personnel.Fonction_actuelle == 2){
                                if(this.coachs.length > (this.maxCoach-1)){
                                    alert("il existe deja un coach");
                                }else{
                                    this.addEquipeFromCoach(response.data.personnel);
                                }
                            }else{
                                if(this.commerciaux.length > (this.maxCommerciaux-1)){
                                    alert("la limite de commerciaux :"+this.maxCommerciaux+" est deja atteinte");
                                }else{
                                    this.addPersonnelToTable(this.commerciaux,response.data.personnel);
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
                                    this.addPersonnelToTable(this.coachs,response.data.personnel);
                                }
                            }else{
                                if(this.commerciaux.length > (this.maxCommerciaux-1)){
                                    alert("la limite de commerciaux :"+this.maxCommerciaux+" est deja atteinte");
                                }else{
                                    this.addPersonnelToTable(this.commerciaux,response.data.personnel);
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
            this.addPersonnelToTable(this.coachs,coach);
            if(coach!=''){
                axios.get('/api/personnels/getPersonnelFromCoach',{params: {coach: coach.Matricule,idMission: this.idMission}}).then(response => {
                    for(let i=0;i<response.data.data.length;i++){
                        if(this.commerciaux.length>=this.maxCommerciaux){
                            
                        }
                        else if(response.data.data[i].Matricule!=coach.Matricule){
                            this.addPersonnelToTable(this.commerciaux,response.data.data[i]);
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