<template>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="inputFonction">Fonction</label>
            <select class="form-control" id="inputFonction" v-model="idFonction" v-on:change="changeCustomId">
                <option v-bind:key="fonction.designation" v-bind:value="fonction.id" v-for="fonction in fonctions">{{ fonction.designation }}</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="inputMatricule">Matricule</label>
            <input type="text" placeholder="what are you looking for?" v-model="matricule" class="form-control" v-on:keyup="autoComplete" v-on:click="autoComplete">
            <div class="panel-footer" style="float:top;position: absolute;z-index: 1;" >
                <ul class="list-group">
                    <li class="list-group-item" v-for="result in resultats" v-bind:key="result" v-on:click.left="changeMatriculeValue(result.Matricule)" >
                        <div >{{ result.Matricule }}</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="form-group col-md-4">
            <button class="d-none d-lg-block btn btn-secondary " style="margin:30px" v-on:click="addPersonnel">Ajouter</button>
        </div>
    </div>
    <button class="d-block d-lg-none btn btn-secondary " style="margin:30px" v-on:click="addPersonnel">Ajouter</button>
</template>

<script>
export default {
    name: "SearchPersonnel",
    data() {
        return {
            matricule: '',
            fonctions: [],
            resultats: [],
            idFonction: null,
            isSearchingAutoComplete: false,
            customId: null,
        }
    },
    props: {
        idMission:{
            type: String,
            required: true
        },
        commerciaux: {
            type: Array,
            required: true
        },
        coachs: {
            type: Array,
            required: true
        }, 
        maxCoach: {
            type: Number,
            default: 1
        },
        maxCommerciaux: {
            type: Number,
            default: 8
        },
    },
    created() {
        this.loadFonctions();
    },
    methods: {
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
        autoComplete(){
            if((this.matricule.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingAutoComplete = true;
                if(this.idFonction != null ){
                    setTimeout(this.searchAutoComplete, 1000);
                }
            }    
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
        changeMatriculeValue(newMatricule){
            this.resultats = [];
            this.matricule = newMatricule;
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
    }
}
</script>