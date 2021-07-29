<template>
<div class="panel-header bg-secondary-gradient" >
    <div class="page-inner py-4">
        <div class="row text-white pb-2 fw-bold">
            <h1>Classification Commerciaux</h1>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-secondary" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="pill" role="tab" aria-selected="true" v-on:click="loadClassificationTout">Tous les commerciaux</a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link show" data-toggle="pill" role="tab" aria-selected="false" v-on:click="loadClassificationMission">commerciaux en mission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" data-toggle="pill" role="tab" aria-selected="false" v-on:click="loadClassificationLocaux">commerciaux en local</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" data-toggle="pill" role="tab" aria-selected="false" v-on:click="loadClassificationRepos">commerciaux au repos</a>
                </li>
            </ul>
            <div id="tableau-commerciaux">
                <div class="row" style="margin-top:30px;margin-bottom:30px">
                    <div class="col-md-3">
                        <select class="form-control input-sm " v-model="filtre">
                            <option value="CA" selected>par CA</option>
                            <option value="nbrProduit">par Nombre de Produit</option>
                            <option value="assuidite">par Assuidite</option>
                            <option value="nbrMission">Nombre de mission</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-secondary " v-on:click="filtrer">
                            filtre
                        </button>
                    </div>
                </div>
                <h4>
                    total : {{ classification.length }}
                </h4>
                <div v-if="isLoadingData" class="row col-12 d-flex justify-content-center" >
                    <div class="loader loader-lg loader-primary"></div>
                </div>
                <div class="table-responsive" v-if="!isLoadingData">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="bg-secondary" style="color:white">
                                <th class="respText" v-on:click="reorderClassification('Place')">Classement</th>
                                <th class="respText" v-on:click="reorderClassification('Matricule')">Matricule</th>
                                <th class="respText" v-on:click="reorderClassification('Nom')">Nom et Prenom</th>
                                <th class="respText" v-on:click="reorderClassification('CA')">C.A</th>
                                <th class="respText" v-on:click="reorderClassification('nbrProduit')">Nombre de Produit</th>
                                <th class="respText" v-on:click="reorderClassification('assuidite')">Assuidite</th>
                                <th class="respText" v-on:click="reorderClassification('nbrMission')">Nombre de mission</th>
                            </tr>
                        </thead>
                            <tr v-for="personnel in classification" v-bind:key="personnel">
                                <td class="respText">{{ personnel.Place }}</td>
                                <td class="respText">{{ personnel.Matricule }}</td>
                                <td class="respText">{{ personnel.Nom+" "+personnel.Prenom }}</td>
                                <td class="respText">{{ personnel.CA }}</td>
                                <td class="respText">{{ personnel.nbrProduit}}</td>
                                <td class="respText">{{ personnel.assuidite.toFixed(2) }} %</td>
                                <td class="respText">{{ personnel.nbrMission}}</td>
                            </tr>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "ClassificationCommerciaux",
    data() {
        return {
            classificationSave: [],
            classification: [],
            equipes: [],
            filtre: 'CA',
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
        this.loadClassificationTout();
    },
    methods: {
        filtrer(){
            if(this.classification.length>1){
                let colonne = this.filtre;
                if(typeof this.classification[0][colonne]=='string'){
                    this.classification.sort(function(b, a){
                        if(a[colonne] < b[colonne]) { return -1; }
                        if(a[colonne] > b[colonne]) { return 1; }
                        return 0;
                    })
                    this.recalculplace();
                }
                else{
                    this.classification.sort(function(a,b){
                        return b[colonne]-a[colonne];
                    });
                    this.recalculplace();
                }
            }
        },
        recalculplace(){
            for(let i=0;i<this.classification.length;i++){
                this.classification[i].Place = i+1;
            }
        },
        compareString(a,b){
            if(a>b)
                return 1;
            else if(a<b)
                return -1;
            else
                return 0;
        },
        reorderClassification(colonne){
            if(this.classification.length>1){
                if(typeof this.classification[0][colonne]=='string'){
                    if(this.classification[0][colonne]>this.classification[1][colonne]){
                        /*this.classification.sort(function(a,b){
                            return a[colonne]-b[colonne];
                        });*/
                        //console.log("int sup");
                        this.classification.sort(function(a, b){
                            if(a[colonne] < b[colonne]) { return -1; }
                            if(a[colonne]> b[colonne]) { return 1; }
                            return 0;
                        })
                    }
                    else{
                        /*
                        this.classification.sort(function(a,b){
                            return b[colonne]-a[colonne];
                        });*/
                        this.classification.sort(function(b, a){
                            if(a[colonne] < b[colonne]) { return -1; }
                            if(a[colonne] > b[colonne]) { return 1; }
                            return 0;
                        })
                        //console.log("int inf");
                    }
                }
                else{
                    if(this.classification[0][colonne]-this.classification[1][colonne]>0){
                        this.classification.sort(function(a,b){
                            return a[colonne]-b[colonne];
                        });
                        //console.log("int sup");
                    }
                    else{
                        
                        this.classification.sort(function(a,b){
                            return b[colonne]-a[colonne];
                        });
                        //console.log("int inf");
                    }
                }
            }
        },
        loadClassificationTout(){
            this.isLoadingData = true;
            if(this.classificationSave["tout"] === undefined ){
                axios.get('/api/personnels/getAllWithInfos').then(response => {
                    this.classificationSave["tout"] = response.data.personnels;
                    this.classification = this.classificationSave["tout"];
                    this.isLoadingData = false;
                });
            }
            else{
                this.classification = this.classificationSave["tout"];
                this.isLoadingData = false;
            }
        },
        replaceClassification(classNouveau){
            let classFinal = [];
            for(let i=0;i<classNouveau.length;i++){
                for(let j=0;j<this.classificationSave["tout"].length;j++){
                    if(this.classificationSave["tout"][j].Matricule == classNouveau[i].Matricule){
                        classFinal.push(this.classificationSave["tout"][j]);
                        break;
                    }
                }
            }
            this.classification = classFinal;
            this.recalculplace();
        },
        loadClassificationMission(){
            if(this.classificationSave["mission"] === undefined ){
                axios.get('/api/personnels/getPersonnelEnMission').then(response => {
                    this.classificationSave["mission"] = response.data.personnels;
                    this.replaceClassification(this.classificationSave["mission"]);
                });
            }
            else{
                this.replaceClassification(this.classificationSave["mission"]);
            }
        },
        loadClassificationLocaux(){
            if(this.classificationSave["locaux"] === undefined ){
                axios.get('/api/personnels/getPersonnelLocaux').then(response => {
                    this.classificationSave["locaux"] = response.data.personnels;
                    this.replaceClassification(this.classificationSave["locaux"]);
                });
            }
            else{
                this.replaceClassification(this.classificationSave["locaux"]);
            }
        },
        getClassificationRepos(){
            let classFinal = [];
            for(let i=0;i<this.classificationSave["tout"].length;i++){
                let enMission = false;
                for(let j=0;j<this.classificationSave["mission"].length;j++){
                    if(this.classificationSave["mission"][j].Matricule == this.classificationSave["tout"][i].Matricule){
                        enMission = true;
                        break;
                    }
                }
                if(!enMission){
                    for(let j=0;j<this.classificationSave["locaux"].length;j++){
                        if(this.classificationSave["locaux"][j].Matricule == this.classificationSave["tout"][i].Matricule){
                            enMission = true;
                            break;
                        }
                    }
                }
                if(!enMission){
                    classFinal.push(this.classificationSave["tout"][i]);
                }
            }
            this.classification = classFinal;
        },
        loadClassificationRepos(){
            if(this.classificationSave["mission"] === undefined ){
                axios.get('/api/personnels/getPersonnelEnMission').then(response => {
                    this.classificationSave["mission"] = response.data.personnels;
                    if(this.classificationSave["locaux"] === undefined ){
                        axios.get('/api/personnels/getPersonnelLocaux').then(response => {
                            this.classificationSave["locaux"] = response.data.personnels;
                            this.getClassificationRepos();
                        });
                    }
                    else{
                        this.getClassificationRepos();
                    }
                });
            }
            else{
                if(this.classificationSave["locaux"] === undefined ){
                    axios.get('/api/personnels/getPersonnelLocaux').then(response => {
                        this.classificationSave["locaux"] = response.data.personnels;
                        this.getClassificationRepos();
                    });
                }
                else{
                    this.getClassificationRepos();
                }
            }
        }
    }
}
</script>
 