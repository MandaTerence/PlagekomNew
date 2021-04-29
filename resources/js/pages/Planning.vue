<template>
<div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
        <h2 class="text-white pb-2 fw-bold">Planning d accompagnement</h2>
    </div>
</div>
<div class="page-inner">
    <div class="row">
        <div class="card col-md-4" >
            <div class="card-body">
                <div class="form-group">
                    <label for="inputMission">Mission</label>
                    <select class="form-control" id="inputMission" v-model="idMission" v-on:change="reloadPlannig();">
                        <option v-bind:key="mission.Id_de_la_mission" v-bind:value="mission.Id_de_la_mission" v-for="mission in missions">{{ mission.Id_de_la_mission }}</option>
                    </select> 
                </div>
            </div>
        </div>
    </div>
    <div>
        <div v-for="planningCoach in plannings" v-bind:key="planningCoach">
            <div class="row">
                <div class="card col-md-4">
                    <div class="form-group">
                        <div class="card-body">   
                            <label for="equipeList">
                                <a v-on:click="toogleDisplayEquipe()">
                                    <div v-if="planningCoach.accompagnement.length>0" v-on:click="displayPlanning(planningCoach.coach )">Equipe du coach : {{ planningCoach.coach.Coach  }}</div>
                                </a>
                            </label>
                            <div  id="equipeList" v-if="equipeDisplay">
                                <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                    <thead>
                                        <tr>
                                            <th> personnel </th>            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="commercial in planningCoach.Commerciaux" v-bind:key="commercial">
                                            <td>{{ commercial.Commercial }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <h2 class="text-center"><span style="background-color:#f9fbfd">Planning d accompagnement</span></h2>
                    <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
            <div class="row">
                <div class="card col-md-12">
                    <div class="card-body">
                        <div class="row" style="margin-top:20px">
                            <table class="table table-hover d-flex justify-content-center" id="listePlanning"> 
                                <tbody>
                                    <div v-for="planning in planningCoach.accompagnement" v-bind:key="planning">
                                        <tr class="d-flex"  style="text-align:center">
                                            <td class="col-12">
                                                <div v-on:click="toogleVisibility(planning['jour'])" >
                                                    <h3><a >{{ getJourSemaine(planning['jour']) }}</a></h3>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr v-if="planning.visibility==true">
                                            <td>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h3>Matin</h3>
                                                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary align-items-center">
                                                            <thead>
                                                                <tr>
                                                                    <th> HEURE </th>
                                                                    <th> MATRICULE </th>            
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td> {{ formatHeure(planning.matin[0].Heure_debut) }} à {{ formatHeure(planning.matin[0].Heure_fin) }}  </td>
                                                                    <td v-on:click="goToPlanning(planning.matin[0].Commercial)"> {{ planning.matin[0].Commercial }}</td>                    
                                                                </tr>
                                                                <tr>
                                                                    <td> {{ formatHeure(planning.matin[1].Heure_debut) }} à {{ formatHeure(planning.matin[1].Heure_fin) }}  </td>
                                                                    <td v-on:click="goToPlanning(planning.matin[1].Commercial)"> {{ planning.matin[1].Commercial }} </td>                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                            
                                                    <div class="col-md-6">
                                                        <h3>Apres Midi</h3>
                                                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary align-items-center">
                                                            <thead>
                                                                <tr>
                                                                    <th> HEURE </th>
                                                                    <th> MATRICULE </th>            
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td> {{ formatHeure(planning.apresMidi[0].Heure_debut) }} à {{ formatHeure(planning.apresMidi[1].Heure_fin) }}  </td>
                                                                    <td v-on:click="goToPlanning(planning.apresMidi[0].Commercial)"> {{ planning.apresMidi[0].Commercial }} </td>                    
                                                                </tr>
                                                                <tr>
                                                                    <td> {{ formatHeure(planning.apresMidi[1].Heure_debut) }} à {{ formatHeure(planning.apresMidi[1].Heure_fin) }}  </td>
                                                                    <td v-on:click="goToPlanning(planning.apresMidi[1].Commercial)"> {{ planning.apresMidi[1].Commercial }} </td>                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr> 
                                    </div>
                                </tbody>
                            </table>
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
    name: "Planning",
    data() {
        return {
            equipeDisplay: false,
            Display: [],
            missions: [],
            idMission: '',
            plannings: [],
            coach: 'all',
            showPlanning: true,
            isSearchingAutoComplete: false,
            jourSemainde: [
                'Dimanche',
                'Lundi',
                'Mardi',
                'Mercredi',
                'jeudi',
                'Vendredi',
                'Samedi',
            ]
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
        this.loadURLdata();
        this.loadPlannig();
    },
    methods: {
        getJourSemaine(d){
            let day =new Date(d);
            return this.jourSemainde[day.getDay()]+" "+d;
        },
        goToPlanning(matricule){
            this.$router.push({ path: 'controleTelephonique', query: { matricule: matricule } });
        },
        toogleVisibility(jour){
            if(this.plannings.length>0){
                for(let i = 0;i<this.plannings[0].accompagnement.length;i++){
                    if(this.plannings[0].accompagnement[i]['jour'] == jour){
                        if(this.plannings[0].accompagnement[i].visibility == true){
                            this.plannings[0].accompagnement[i].visibility = false;
                        }
                        else{
                            this.plannings[0].accompagnement[i].visibility = true;
                        }
                    }
                }
            }
        },
        toogleDisplayEquipe(){
            (this.equipeDisplay==true)?this.equipeDisplay = false:this.equipeDisplay = true;
        },
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('idMission')){
                this.idMission = urlParams.get('idMission');
            }
            else if(localStorage.idMission){
                this.idMission = localStorage.idMission;
            }
            if(urlParams.get('coach')){
                this.coach = urlParams.get('coach');
            }
            else if(localStorage.coach){
                this.coach = localStorage.coach;
            }
        },
        loadMissions(){
            this.$axios.get('/api/missions',{params: {criteres: {Statut: 'En_cours'}}}) 
            .then(response => {
                if(response.data.success){
                    this.missions = response.data.missions;
                    this.idMission = this.missions[0];  
                }
                else{
                    console.log(response.data.message);
                }
            })
            .catch(function (error) {
                console.error(error);
            });
        },
        displayPlanning(coach){
            for(let i=0;i<this.plannings.length;i++){
                if(this.plannings[i].coach==coach){
                    this.plannings[i].visibility? this.plannings[i].visibility=false:this.plannings[i].visibility=true;
                }
            }
        },
        loadPlannig(){
            if((this.idMission!=null)&&(this.idMission!='')&&(this.coach!=null)&&(this.coach!='')){
                localStorage.coach = this.coach;
                localStorage.idMission = this.idMission;
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('/api/classements/planning',{params: {idMission : this.idMission,coach : this.coach}}).then(response => {
                        this.plannings = response.data.plannings;
                        for(let i=0;i<this.plannings[0].accompagnement.length;i++){
                            this.plannings[0].accompagnement[i].visibility = false;
                        }
                    });  
                });
            }
        },
        getPeriodeJour(heure){
            if(this.hourToTime(heure)<this.hourToTime('12:00:00')){
                return 'MATIN';
            }
            else{
                return 'APRES MIDI';
            }
        },
        formatHeure(heure){
            let arr = heure.split(':')
            return ''+(parseInt(arr[0])<10? '0'+parseInt(arr[0]): parseInt(arr[0]))+'h '+(parseInt(arr[1])<10? '0'+parseInt(arr[1]): parseInt(arr[1]));
        },
        searchAutoComplete(){
            this.$axios.get('/api/missions',{params: {criteres: {Statut: 'En_cours',Id_de_la_mission: '%'+this.idMission+'%'}}}).then(response => {
                this.isSearchingAutoComplete = false;
                for(let i=0;i<this.missions.length;i++){
                    this.missions.pop();
                }
                for(let i=0;i<response.data.data.length;i++){
                    this.missions.push(response.data.data[i].Id_de_la_mission);
                }
            });
        },
        autoComplete(){
            if((this.idMission.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingAutoComplete = true;
                if(this.idMission != null ){
                    setTimeout(this.searchAutoComplete, 1000);
                }
            }  
        },
        reloadPlannig(){
            //this.coach = 'all',
            this.loadPlannig();
        },
    }
}
</script>