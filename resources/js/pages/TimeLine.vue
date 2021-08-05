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
                                                <td style="white-space: nowrap;overflow: hidden;">{{ getMoneyFormat(Number(sanction.valeur)) }}</td>
                                            </tr>
                                        </tbody>
                                   </table>
                                </div>
                                <div style="margin-top:30px" class="row justify-content-center">
                                    <button class="col-4 btn btn-primary btn-rounded" @click="showModal.detailSanction = false">
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
                                    <button class="col-4 btn btn-primary btn-rounded" @click="showModal.detailControle = false">
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

    <div class="page-inner" v-if="false">
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
    <!-- <div class="panel-header bg-secondary-gradient" v-if="thereIsPersonnel">-->
    <div class="panel-header bg-secondary-gradient">
        <div class="page-inner py-4">
            <ul class="breadcrumbs text-white d-none d-sm-block" style="margin-left: -40px">
                <li class="nav-item">
                    <i class="fas fa-phone-volume"></i>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <span class="text-white">Controlle télephonique</span>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <span class="text-white" >Etat controlle du mois</span>
                </li>
                <li class="separator">
                    <i class="flaticon-right-arrow"></i>
                </li>
                <li class="nav-item">
                    <span class="text-white">{{ dateMission }}</span>
                </li>
            </ul>
            <h2 class="text-white pb-2 fw-bold" style="margin-top: 40px">Timeline du {{ dateMission }}</h2>
        </div>
    </div>
    <!-- <div class="page-inner" v-if="thereIsPersonnel"> -->
    <div class="page-inner">
        <div class="card">
            <div class="card-body">
                <div>
                    <label for="dateMission">Selectionner la date</label>
                </div>
                <div class="row">
                    <div class="form-group input-group col-12">
                        <input type="date" class="form-control" id="dateMission" v-model="dateMission">
                        <div class="input-group-append">
                            <button class="btn btn-secondary " id="btnCheck" v-on:click="loadMissionDate()">
                                Controller
                            </button>
                        </div>
                    </div>
                </div>
                <div v-for="mission in missions" v-bind:key="mission">
                    <div v-if="mission.Commerciaux.length>1" style="margin:10px">
                        <hr>
                        <div class="row"><h3>{{ mission.idMission }}</h3></div>
                        <div class="row" style="margin-top: 30px">
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
                                <strong>CA total Sanction : {{ getMoneyFormat(getCATotalSanction(mission.Commerciaux)) }}</strong>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 30px"><h3>Commerciaux :</h3></div>
                        <div class="row table-responsive">
                            <table class="table table-hover table-striped col-12">
                                <thead>
                                    <tr class="bg-secondary" style="color:white">
                                        <th class="respText" scope="col-md-2">Matricule</th>
                                        <th class="respText" scope="col-md-2">Heure de controle</th>
                                        <th class="respText" scope="col-md-2">Ville d'animation</th>
                                        <th class="respText" scope="col-md-2">Duree de controle</th>
                                        <th class="respText" scope="col-md-2">code de sanction</th>
                                        <th class="respText" scope="col-md-2">CA sanction</th>
                                        <th class="respText" scope="col-md-2">Etat Controle</th>
                                        <th class="respText" scope="col-md-2">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="commercial in mission.Commerciaux" v-bind:key="commercial">
                                        <td class="respText" v-on:click="goToPlanning(commercial.Matricule)">
                                            {{ commercial.Matricule }}</td>
                                        <td class="respText" >
                                            <div v-if="commercial.controles.length>0" v-on:click="showControle(commercial)">
                                                <div v-for="controle in commercial.controles" v-bind:key="controle">
                                                    {{ getHeure(controle.debut) }}
                                                </div>
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            {{ mission.ville }}
                                        </td>
                                        <td class="respText" >
                                            <div v-if="commercial.controles.length>0">
                                                {{ getDureeControle(commercial.controles) }}
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <div v-if="commercial.sanctions.length>0" v-on:click="showSanction(commercial)">
                                                <div v-for="sanction in commercial.sanctions" v-bind:key="sanction">
                                                    {{ sanction.code_sanction }}
                                                </div>
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <div v-if="commercial.sanctions.length>0">
                                                {{ getMoneyFormat(getTotalCASanction(commercial.sanctions)) }}
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <div class="text-success" v-if="commercial.controles.length>0">
                                                effectué
                                            </div>
                                            <div class="text-danger" v-else>
                                                non effectué
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <button v-on:click="goToPlanning(commercial.Matricule)" class="btn btn-primary btn-sm">
                                                controller
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <div class="row" style="margin-top: 30px"><h3>Coach :</h3></div>
                        <div class="row table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr class="bg-secondary" style="color:white">
                                        <th class="respText" scope="col-md-2">Matricule</th>
                                        <th class="respText" scope="col-md-2">Heure de controle</th>
                                        <th class="respText" scope="col-md-2">Ville d'animation</th>
                                        <th class="respText" scope="col-md-2">Duree de controle</th>
                                        <th class="respText" scope="col-md-2">code de sanction</th>
                                        <th class="respText" scope="col-md-2">CA sanction</th>
                                        <th class="respText" scope="col-md-2">Etat Controle</th>
                                        <th class="respText" scope="col-md-2">action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="coach in mission.Coach" v-bind:key="coach">
                                        <td class="respText" v-on:click="goToPlanning(coach.Matricule)">
                                            {{ coach.Matricule }}
                                        </td>
                                        <td class="respText" >
                                            <div v-if="coach.controles.length>0">
                                                <div v-for="controle in coach.controles" v-bind:key="controle">
                                                    {{ getHeure(controle.debut) }}
                                                </div>
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            {{ mission.ville }}
                                        </td>
                                        <td class="respText" >
                                            <div v-if="coach.controles.length>0">
                                                {{ getDureeControle(coach.controles) }}
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <div v-if="coach.sanctions.length>0">
                                                <div v-for="sanction in coach.sanctions" v-bind:key="sanction">
                                                    {{ sanction.code_sanction }}
                                                </div>
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" > 
                                            <div v-if="coach.sanctions.length>0">
                                                {{ getTotalCASanction(coach.sanctions) }}
                                            </div>
                                            <div v-else>
                                                aucun 
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <div class="text-success" v-if="coach.controles.length>0">
                                                effectué
                                            </div>
                                            <div class="text-danger" v-else>
                                                non effectué
                                            </div>
                                        </td>
                                        <td class="respText" >
                                            <button v-on:click="goToPlanning(coach.Matricule)" class="btn btn-primary btn-sm">
                                                controller
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <button v-on:click="exporterMissionXls(mission.idMission)" v-if="mission.Commerciaux.length>1" class="btn btn-success btn-rounded btn-lg col-4">
                            export XLS <i class="fas fa-file-excel" style="margin-left:10px;font-size: 15px"></i>
                        </button>
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
            dateActuelle: "",
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
        this.dateMission = this.getActualDate();
        this.dateActuelle = this.getActualDate();
        this.loadMissionDate();
    },
    methods: {
        getActualDate(){
            var today = new Date();
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
            today = yyyy+'-'+mm+'-'+dd;
            return today;
        },
        exporterMissionXls(idMission){
            let data = {
                "excel":"controlMission",
                "idMission":idMission,
                "jour": this.dateMission
            };
            data = JSON.stringify(data);
            data ='/excel'+data
            axios.get(data,{
                responseType: 'blob',
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
        getMoneyFormat(monnaie){
            if(monnaie)
                return monnaie.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& ')+" Ar"; 
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