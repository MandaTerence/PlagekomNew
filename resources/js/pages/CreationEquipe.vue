<template>
    <div v-if="!showClassements">
        <div>

        </div>
        <div v-bind:class="{ }">
            
        </div>
        <SearchProduit v-model:produits="produits"/>
        <ProduitTab v-model:produits="produits"/>
        <div class="form-group col-md-4">
            <label for="inputMission">Mission</label>
            <select class="form-control" id="inputMission" v-model="idMission">
                <option v-bind:key="mission.Id_de_la_mission" v-bind:value="mission.Id_de_la_mission" v-for="mission in missions">{{ mission.Id_de_la_mission }}</option>
            </select>
        </div>
        <SearchPersonnel v-model:commerciaux="commerciaux" v-model:coachs="coachs" v-model:idMission="idMission"/>
        <EquipeTab v-model:equipes="coachs" titre="Coachs"/>
        <EquipeTab v-model:equipes="commerciaux" titre="Commerciaux"/>
        <div class="row" >
            <div class="col-12 text-right">
                <button class="btn btn-secondary" v-on:click="getClassement">lancer le classement</button>
            </div>
        </div>
    </div> 
    <div v-if="showClassements">
        <ClassementTab v-model:classements="classements" v-model:classementReel="classementReel"/>
        <button class="btn btn-secondary" v-on:click="toogleClassementsView()">retour </button>
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
                                        <th scope="col-md-2"><input type="number" v-model="classement.placeTemp" v-on:change="changeClassement(classement.place,classement.placeTemp)"/></th>
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
            classementReel: []
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
    },
    methods: {
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
                        this.$router.push({ name: 'planning', query: { idMission: this.idMission ,coach: this.coach} });
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
                    this.classementReel = response.data.classementsReel;
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
            }
            
        },
        test(){
            alert(this.idMission);
            //let te =  this.getCodeProduitFromArray(this.produits);
            //alert(te);
        },
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