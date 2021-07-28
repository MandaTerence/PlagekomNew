<template>
    <div v-if="showModal.detailSanction" @close="showModal.detailSanction = false">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container card">
                        <div class="modal-body card-body">
                            <slot name="body">
                                <div class="row justify-content-center">
                                    Sanctions de {{ selectedCommercial.Nom }}
                                </div>
                                <div class="row">
                                   <table class="table">
                                        <thead>
                                            <tr>
                                                <th>code Sanction</th>
                                                <th>sanction</th>
                                                <th>montant</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="sanction in selectedCommercial.sanctions ">
                                                <td>{{ sanction.code_sanction}}</td>
                                                <td>{{ sanction.titre }}</td>
                                                <td>{{ getMoneyFormat(Number(sanction.valeur)) }}</td>
                                            </tr>
                                        </tbody>
                                   </table>
                                </div>
                                <div style="margin-top:30px" class="row justify-content-center">
                                    <button class="btn btn-primary" @click="showModal.detailSanction = false">
                                        OK
                                    </button>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>

    <div v-if="showModal.detailControle" @close="showModal.detailControle = false">
        <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                    <div class="modal-container card">
                        <div class="modal-body card-body">
                            <slot name="body">
                                <div class="row justify-content-center">
                                    Controles de {{ selectedCommercial.Nom }}
                                </div>
                                <div class="row">
                                   <table class="table">
                                        <thead>
                                            <tr>
                                                <th>debut</th>
                                                <th>fin</th>
                                                <th>duree</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="controle in selectedCommercial.controles ">
                                                <td>{{ controle.debut}}</td>
                                                <td>{{ controle.fin }}</td>
                                                <td>{{ controle.duree }}</td>
                                            </tr>
                                        </tbody>
                                   </table>
                                </div>
                                <div style="margin-top:30px" class="row justify-content-center">
                                    <button class="btn btn-primary" @click="showModal.detailControle = false">
                                        OK
                                    </button>
                                </div>
                            </slot>
                        </div>
                    </div>
                </div>
            </div>
        </transition>
    </div>

    <div class="page-inner" v-if="!thereIsPersonnel">
        <div class="row">
            <div class="card col-md-12">
                <div class="card-body">
                    <div class="form-group">
                        <label for="dateMission">Selectionner la date</label>
                        <div class="form-control" id="dateMission">
                            <input type="date" class="form-control"  v-model="dateMission">
                        </div>
                    </div>
                    <div class="form-group">
                    </div>
                    <div class="form-group row justify-content-center" v-if="dateMission!=null">
                        <button class="btn btn-secondary form-control btn-round col-md-2" id="btnCheck" v-on:click="loadMissionDate()">
                            verifier
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-header bg-secondary-gradient" v-if="thereIsPersonnel">
        <div class="page-inner py-5">
            <h2 class="text-white pb-2 fw-bold">Timeline du {{ dateMission }}</h2>
        </div>
    </div>
    <div class="page-inner" v-if="thereIsPersonnel">
        <div class="card">
            <div class="card-body">
                <div class="row" style="margin-bottom:60px;">
                    <div class="col-2">
                        <button v-on:click="retour" class="btn btn-secondary btn-round">
                            <i class="fas fa-angle-left" style="margin-right: 10px;"></i>
                            <span >retour</span>
                        </button>
                    </div>
                </div>
                <div v-for="mission in missions" v-bind:key="mission">
                    <div v-if="mission.Commerciaux.length>1" style="margin:20px">
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
                                <strong>CA total Sanction : {{ getMoneyFormat(getCATotalSanction(mission.Commerciaux)) }} Ar</strong>
                            </div>
                        </div>
                        <hr>
                        <div class="row"><h3>Commerrciaux :</h3></div>
                        <div class="row">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr class="bg-secondary" style="color:white">
                                        <th scope="col-md-2">Matricule</th>
                                        <th scope="col-md-2">Heure de controle</th>
                                        <th scope="col-md-2">Ville d'animation</th>
                                        <th scope="col-md-2">Duree de controle</th>
                                        <th scope="col-md-2">code de sanction</th>
                                        <th scope="col-md-2">CA sanction</th>
                                        <th scope="col-md-2">Etat Controle</th>
                                        <th scope="col-md-2">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="commercial in mission.Commerciaux" v-bind:key="commercial">
                                        <td v-on:click="goToPlanning(commercial.Matricule)">
                                            {{ commercial.Matricule }}</td>
                                        <td>
                                            <div v-if="commercial.controles.length>0" v-on:click="showControle(commercial)">
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
                                            <div v-if="commercial.sanctions.length>0" v-on:click="showSanction(commercial)">
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
                                                {{ getMoneyFormat(getTotalCASanction(commercial.sanctions)) }} Ar
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
                                        <td>
                                            <button v-on:click="goToPlanning(commercial.Matricule)" class="btn btn-primary btn-sm">
                                                controller
                                            </button>
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
            thereIsPersonnel: false,
            showModal: {
                "detailSanction": false,
                "detailControle": false
            },
            selectedCommercial: ''
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
        getMoneyFormat(monnaie){
            if(monnaie)
                return monnaie.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); 
            else
                return 0;
        },
        showSanction(commercial){
            this.selectedCommercial = commercial;
            this.showModal.detailSanction = true;
        },
        showControle(commercial){
            this.selectedCommercial = commercial;
            this.showModal.detailControle = true;
        },
        checkMission(){
            for(let i=0;i<this.missions.length;i++){
                if(this.missions[i].Commerciaux.length>0){
                    return true;
                }
            }
            return false;
        },
        retour(){
            localStorage.removeItem('dateMission');
            this.missions = [];
            this.thereIsPersonnel = false;
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
                   this.thereIsPersonnel = this.checkMission();
                   if(!this.thereIsPersonnel){
                       alert("aucune mission trouvé");
                   }
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