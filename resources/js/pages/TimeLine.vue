<template>
<div class="page-inner" v-if="!(missions.length>0)">
    <div class="row">
        <div class="card col-md-4">
            <div class="card-body">
                <div class="form-group">
                    <label for="dateMission">Selectionner la date</label>
                    <div class="form-control" id="dateMission">
                        <input type="date" class="form-control"  v-model="dateMission">
                    </div>
                </div>
                <div class="form-group">
                </div>
                <div v-if="dateMission!=null" >
                    <div class="form-group text-center">
                        <button class="btn btn-secondary form-control" id="btnCheck" v-on:click="loadMissionDate()">
                            verifier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="panel-header bg-secondary-gradient" v-if="(missions.length>0)">
    <div class="page-inner py-5">
        <h2 class="text-white pb-2 fw-bold">Timeline du {{ dateMission }}</h2>
    </div>
</div>
<div class="page-inner">
    <div v-for="mission in missions" v-bind:key="mission">
        <div v-if="mission.Commerciaux.length>1" class="card">
            <div class="card-body">
                <div style="margin:20px">
                    <div class="row"><h3>{{ mission.idMission }}</h3></div>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Nombre equipe : {{ getTotalPersonnel(mission) }}</strong>
                        </div>
                        <div class="col-md-3">
                            <strong>Ville d animation : {{ mission.ville }}</strong>
                        </div>
                        <div class="col-md-3">
                            <strong>Durée totale controle :{{ getDureeTotalControle(mission.Commerciaux) }}</strong>
                        </div>
                        <div class="col-md-3">
                            <strong>CA total Sanction : {{ getCATotalSanction(mission.Commerciaux) }} Ar</strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row"><h3>Commerrciaux :</h3></div>
                    <div class="row">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-secondary" style="color:white">
                                    <th scope="col-md-2">Matricule</th>
                                    <th scope="col-md-2">Heure de controle</th>
                                    <th scope="col-md-2">Ville d'animation</th>
                                    <th scope="col-md-2">Duree de controle</th>
                                    <th scope="col-md-2">code de sanction</th>
                                    <th scope="col-md-2">CA sanction</th>
                                    <th scope="col-md-2">Etat Controle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="commercial in mission.Commerciaux" v-bind:key="commercial">
                                    <td v-on:click="goToPlanning(commercial.Matricule)">
                                        {{ commercial.Matricule }}</td>
                                    <td>
                                        <div v-if="commercial.controles.length>0">
                                            <div v-for="controle in commercial.controles" v-bind:key="controle">
                                                {{ getHeure(controle.debut) }}
                                            </div>
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        {{ mission.ville }}
                                    </td>
                                    <td>
                                        <div v-if="commercial.controles.length>0">
                                            {{ getDureeControle(commercial.controles) }}
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="commercial.sanctions.length>0">
                                            <div v-for="sanction in commercial.sanctions" v-bind:key="sanction">
                                                {{ sanction.code_sanction }}
                                            </div>
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="commercial.sanctions.length>0">
                                            {{ getTotalCASanction(commercial.sanctions) }}
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="commercial.controles.length>0">
                                            effectué
                                        </div>
                                        <div v-else>
                                            non effectué
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="row"><h3>Coach :</h3></div>
                    <div class="row">
                        <table class="table table-hover">
                            <thead>
                                <tr class="bg-secondary" style="color:white">
                                    <th scope="col-md-2">Matricule</th>
                                    <th scope="col-md-2">Heure de controle</th>
                                    <th scope="col-md-2">Ville d'animation</th>
                                    <th scope="col-md-2">Duree de controle</th>
                                    <th scope="col-md-2">code de sanction</th>
                                    <th scope="col-md-2">CA sanction</th>
                                    <th scope="col-md-2">Etat Controle</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="coach in mission.Coach" v-bind:key="coach">
                                    <td v-on:click="goToPlanning(coach.Matricule)">
                                        {{ coach.Matricule }}</td>
                                    <td>
                                        <div v-if="coach.controles.length>0">
                                            <div v-for="controle in coach.controles" v-bind:key="controle">
                                                {{ getHeure(controle.debut) }}
                                            </div>
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        {{ mission.ville }}
                                    </td>
                                    <td>
                                        <div v-if="coach.controles.length>0">
                                            {{ getDureeControle(coach.controles) }}
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="coach.sanctions.length>0">
                                            <div v-for="sanction in coach.sanctions" v-bind:key="sanction">
                                                {{ sanction.code_sanction }}
                                            </div>
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="coach.sanctions.length>0">
                                            {{ getTotalCASanction(coach.sanctions) }}
                                        </div>
                                        <div v-else>
                                            aucun 
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="coach.controles.length>0">
                                            effectué
                                        </div>
                                        <div v-else>
                                            non effectué
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>
<script>

export default {
    name: "TimeLine",
    data() {
        return {
            dateMission: null,
            missions: [],
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    mounted() {
        if (localStorage.dateMission) {
            this.dateMission = localStorage.dateMission;
            this.loadMissionDate();
        }
    },
    methods: {
        test(){

        },
        getTotalCASanction(sanctions){
            let valeur = 0;
            for(let i=0;i<sanctions.length;i++){
                valeur+=sanctions[i].valeur;
            }
            return valeur;
        },
        completeZero(chiffre,mot){
            let res = "";
            if(chiffre<10){
                res = "0"+chiffre+mot;
            }
            else{
                res = ""+chiffre+mot;
            }
            return res;
        },
        getCATotalSanction(Commerciaux){
            let caTotal = 0;
            for(let j=0;j<Commerciaux.length;j++){
                for(let i=0;i<Commerciaux[j].sanctions.length;i++){
                    caTotal += Commerciaux[j].sanctions[i].valeur;
                }
            }
            return caTotal;
        },
        getDureeTotalControle(Commerciaux){
            let tempsTotal = 0;
            for(let j=0;j<Commerciaux.length;j++){
                for(let i=0;i<Commerciaux[j].controles.length;i++){
                    let t = Commerciaux[j].controles[i].duree.split(":");
                    tempsTotal+=parseInt(t[0]*3600);
                    tempsTotal+=parseInt(t[1]*60);
                    tempsTotal+=parseInt(t[2]);
                }
            }
            let heure = Math.floor(tempsTotal/3600);
            let minute = Math.floor((tempsTotal-(heure*3600))/60);
            let seconde = Math.floor(tempsTotal-(heure*3600)-(minute*60));
            return this.completeZero(heure,"H ")+this.completeZero(minute,"m ")+this.completeZero(seconde,"s");
        },
        getDureeControle(controles){
            let tempsTotal = 0;
            for(let i=0;i<controles.length;i++){
                let t = controles[i].duree.split(":");
                tempsTotal+=parseInt(t[0]*3600);
                tempsTotal+=parseInt(t[1]*60);
                tempsTotal+=parseInt(t[2]);
            }
            let heure = Math.floor(tempsTotal/3600);
            let minute = Math.floor((tempsTotal-(heure*3600))/60);
            let seconde = Math.floor(tempsTotal-(heure*3600)-(minute*60));
            return this.completeZero(heure,"H ")+this.completeZero(minute,"m ")+this.completeZero(seconde,"s");
        },
        goToPlanning(matricule){
            this.$router.push({ path: 'controleTelephonique', query: { matricule: matricule } });
        },
        loadMissionDate(){
            if(this.dateMission!=null){
                localStorage.dateMission = this.dateMission;
                axios.get('/api/personnels/getAllFromMission',{params: {jour: this.dateMission}}).then(response => {
                   this.missions = response.data.missions;
                });
            }
        },
        getTotalPersonnel(mission){
            return mission.Commerciaux.length+mission.Coach.length;
        },
        getHeure(heure){
            let res = (heure.split(" ")[1]).split(":");
            return ""+res[0]+"H "+res[1];
        }
    },
    components: {
        
    },
}
</script>