<template>
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
                    <span class="text-white" >Planning d accompagnement</span>
                </li>
            </ul>
            <h2 class="text-white pb-2 fw-bold"  style="margin-top:40px">Planning d accompagnement</h2>
        </div>
    </div>
    <div class="page-inner">
        <div class="row">
            <div class="card col-12" >
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputMission">Mission</label>
                        <select class="form-control" id="inputMission" v-model="idMission" v-on:change="loadPlanning()">
                            <option v-bind:key="mission.Id_de_la_mission" v-bind:value="mission.Id_de_la_mission" v-for="mission in missions">{{ mission.Id_de_la_mission }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" v-for="planningCoach in plannings" v-bind:key="planningCoach">
                <h2 class="text-center"><span style="background-color:#f9fbfd">Planning du coach  {{ planningCoach.coach.Coach  }}</span></h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="row">
                    <div class="card col-12">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-header">
                                    <a v-on:click="toogleDisplayEquipe(planningCoach.coach.Coach)">
                                        <div style="color:#4192b5" class="d-flex justify-content-center" v-if="planningCoach.accompagnement.length>0">
                                            <i style="margin-right: 20px;font-size: 20px;" class="fas fa-user-friends"></i>
                                            <span>Equipe</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body" id="equipeList" v-if="planningCoach.equipeVisibility">
                                    <table class="table table-hover">
                                        <tbody>
                                            <tr v-for="commercial in planningCoach.Commerciaux" v-bind:key="commercial">
                                                <td class="text-center">{{ commercial.Commercial }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <a v-on:click="toogleDisplayPlanning(planningCoach.coach.Coach)">
                                        <div style="color:#4192b5" class="d-flex justify-content-center" v-if="planningCoach.accompagnement.length>0">
                                            <i style="margin-right: 20px;font-size: 20px;" class="far fa-calendar-alt"></i>
                                            <span>Planning</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="card-body" v-if="planningCoach.planningVisibility">
                                    <div class="row" style="margin-top:20px">
                                        <table class="table table-hover d-flex justify-content-center" id="listePlanning"> 
                                            <tbody>
                                                <div v-for="planning in planningCoach.accompagnement" v-bind:key="planning">
                                                    <tr class="d-flex"  style="text-align:center">
                                                        <td class="col-12">
                                                            <div v-on:click="toogleVisibility(planningCoach.coach.Coach,planning['jour'])" >
                                                                <a >
                                                                    {{ getJourSemaine(planning['jour']) }}
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="planning.visibility==true">
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span>Matin</span>
                                                                </div>
                                                                <table class="col-12">
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
                                                                <div class="col-12">
                                                                    <span>Matin</span>
                                                                </div>
                                                                <table class="col-12">
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
        </div>
        <div class="row d-flex justify-content-center">
            <button class="col-4 btn btn-success btn-rounded" v-on:click="getExcelData">exporter XLS</button>
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
        this.loadPlanning();
    },
    methods: {
        getExcelData(){
            let data = {
                "excel":"Planning",
                "idMission":this.idMission
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
        validateEquipe(){
            let matricules = this.getMatriculeFromArray(this.commerciaux);
            let produits =  this.getCodeProduitFromArray(this.produits);
            let data = {
                "excel":"evaluation",
                "Matricules":matricules,
                "Produits": produits,
                
                "dateDebut": this.dateDebut,
                "dateFin": this.dateFin,

                "listeDateExclu": this.listeDateExclu,

                "pourcentage": this.pourcentage,
                "minimumVente": this.minimumVente
            };
            data = JSON.stringify(data);
            data ='/excel'+data
            axios.get(data,{
                responseType: 'blob',
            }).then(response => {
                
                this.download(response);
            });
        },
        getJourSemaine(d){
            let day =new Date(d);
            return this.jourSemainde[day.getDay()]+" "+d;
        },
        goToPlanning(matricule){
            this.$router.push({ path: 'controleTelephonique', query: { matricule: matricule } });
        },
        toogleVisibility(coach,jour){
            if(this.plannings.length>0){
                for(let i=0;i<this.plannings.length;i++){
                    if(this.plannings[i].coach.Coach==coach){
                        for(let j = 0;j<this.plannings[i].accompagnement.length;j++){
                            if(this.plannings[i].accompagnement[j]['jour'] == jour){
                                if(this.plannings[i].accompagnement[j].visibility == true){
                                    this.plannings[i].accompagnement[j].visibility = false;
                                }
                                else{
                                    this.plannings[i].accompagnement[j].visibility = true;
                                }
                            }
                        }
                        break;
                    }
                }
            }
        },
        toogleDisplayEquipe(coach){
            for(let i=0;i<this.plannings.length;i++){
                if(this.plannings[i].coach.Coach==coach){
                    (this.plannings[i].equipeVisibility==true)?this.plannings[i].equipeVisibility = false:this.plannings[i].equipeVisibility = true;
                    break;
                }
            }
        },
        toogleDisplayPlanning(coach){
            for(let i=0;i<this.plannings.length;i++){
                if(this.plannings[i].coach.Coach==coach){
                    this.plannings[i].planningVisibility;
                    (this.plannings[i].planningVisibility==true)?this.plannings[i].planningVisibility = false:this.plannings[i].planningVisibility = true;
                    break;
                }
            }
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
        loadPlanning(){
            if((this.idMission!=null)&&(this.idMission!='')&&(this.coach!=null)&&(this.coach!='')){
                localStorage.coach = this.coach;
                localStorage.idMission = this.idMission;
                axios.get('/api/classements/planning',{params: {idMission : this.idMission,coach : this.coach}}).then(response => {
                    this.plannings = response.data.plannings;
                    if(this.plannings.length>0){
                        for(let i=0;i<this.plannings.length;i++){
                            this.plannings[i].equipeVisibility = false;
                            this.plannings[i].planningVisibility = false;//equipeVisibility
                            for(let j=0;j<this.plannings[i].accompagnement.length;j++){
                                this.plannings[i].accompagnement[j].visibility = false;
                            }
                        }
                    }
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
    }
}
</script>