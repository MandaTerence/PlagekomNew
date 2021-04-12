<template>
    <div class="row">
        <div class="card" >
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
            <h3 v-if="planningCoach.accompagnement.length>0" v-on:click="displayPlanning(planningCoach.coach )">{{ planningCoach.coach.Coach  }}</h3>
            <div v-if="planningCoach.visibility==true">
                <div>
                    <h3>Equipe</h3>
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
                <div style="margin-top:50px" v-for="planning in planningCoach.accompagnement" v-bind:key="planning">
                    <div class="row">
                        <div class="col-3">
                            <h3>{{ planning['jour'] }}</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Matin</h3>
                            <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                <thead>
                                    <tr>
                                        <th> HEURE </th>
                                        <th> MATRICULE </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> {{ formatHeure(planning.matin[0].Heure_debut) }} à {{ formatHeure(planning.matin[0].Heure_fin) }}  </td>
                                        <td> {{ planning.matin[0].Commercial }} </td>                    
                                    </tr>
                                    <tr>
                                        <td> {{ formatHeure(planning.matin[1].Heure_debut) }} à {{ formatHeure(planning.matin[1].Heure_fin) }}  </td>
                                        <td> {{ planning.matin[1].Commercial }} </td>                    
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h3>Apres Midi</h3>
                            <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                                <thead>
                                    <tr>
                                        <th> HEURE </th>
                                        <th> MATRICULE </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> {{ formatHeure(planning.apresMidi[0].Heure_debut) }} à {{ formatHeure(planning.apresMidi[1].Heure_fin) }}  </td>
                                        <td> {{ planning.apresMidi[0].Commercial }} </td>                    
                                    </tr>
                                    <tr>
                                        <td> {{ formatHeure(planning.apresMidi[1].Heure_debut) }} à {{ formatHeure(planning.apresMidi[1].Heure_fin) }}  </td>
                                        <td> {{ planning.apresMidi[1].Commercial }} </td>                    
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                    <hr style="background-color: #3490dc;">
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
            missions: [],
            idMission: '',
            plannings: [],
            coach: 'all',
            showPlanning: true,
            isSearchingAutoComplete: false
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
        this.loadPlannig();
        this.loadURLdata();
    },
    methods: {
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('idMission')){
                this.idMission = urlParams.get('idMission');
            }
            if(urlParams.get('coach'))
            this.coach = urlParams.get('coach');
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
                this.$axios.get('/sanctum/csrf-cookie').then(response => {
                    axios.get('/api/classements/planning',{params: {idMission : this.idMission,coach : this.coach}}).then(response => {
                        this.plannings = response.data.plannings;
                        for(let i=0;i<this.plannings.length;i++){
                            this.plannings[i].visibility = true;
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
            this.coach = 'all',
            this.loadPlannig();
        },
    }
}
</script>