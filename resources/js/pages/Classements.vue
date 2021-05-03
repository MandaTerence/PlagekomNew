<template>
<div class="panel-header bg-secondary-gradient" >
    <div class="page-inner py-4">
        <div class="row text-white pb-2 fw-bold">
            <h1>Classements</h1>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="row" id="searchMission">
        <div class="form-group col-8">
            <label for="inputMission">Mission</label>
            <select class="form-control " id="inputMission" v-model="idMission">
                <option v-bind:key="mission.Id_de_la_mission" v-bind:value="mission.Id_de_la_mission" v-for="mission in missions">{{ mission.Id_de_la_mission }}</option>
            </select>
        </div>
        <div class="form-group col-4">
            <button class="btn btn-secondary" style="margin-top:30px" v-on:click="test">
                test
            </button>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Classements",
    data() {
        return {
            idMission: '',
            missions: [],
            classements: []
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
    },
    methods: {
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('matricule')){
                this.matricule = urlParams.get('matricule');
                this.getPersonnel();
            }
        },
        getClassement(){
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
        test(){
            alert(this.idMission);
        }
    }
}
</script>