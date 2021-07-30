<template>
    <div style="margin-top: 30px" class="row justify-content-center" v-if="isLoadingData">
        <div class="loader loader-lg"></div>
    </div>
    <div v-else>
        <div class="page-inner" v-if="!exist">
            <div class="card">
                <div class="card-body ">
                    <div class="form-group">
                        <label for="matricule">Matricule</label>
                        <input type="text" class="form-control" id="matricule"  placeholder="Matricule" v-model="nouveauMatricule">
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-secondary btn-round col-6" v-on:click="changeCommerciaux">controler</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-header bg-secondary-gradient" v-if="exist">
            <div class="page-inner py-4">
                <div class="text-white pb-2 fw-bold row text-right d-flex justify-content-end" >
                    <a class="text-right" v-on:click="resetCommerciaux" style="margin-right:10px"><div class="icon-preview"><i class="far fa-times-circle" style="font-size:30px;cursor: pointer;"></i></div></a>
                </div>
                <h1 class="text-white pb-2 fw-bold" >Controle Telephonique de {{ personnelData.Prenom }}</h1>
            </div>
        </div>
        <div class="page-inner" >
            <div v-if="exist">
                <h2 class="text-center">
                    <span style="background-color:#f9fbfd">Info Commerciale</span>
                </h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="card" >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 d-block d-sm-none" style="margin-bottom: 30px;">
                                <img src="assets/img/unknow.jpg" class="rounded-circle mx-auto d-block img-fluid d-flex justify-content-center" style="width:200px;height:200px;border: 5px solid #6861ce;">
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td><strong>Nom Commercial:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Nom }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Prenom Commercial:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Prenom }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Contact_du_personnel }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Mission Actuel:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Id_de_la_mission }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Coach Commerciale:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Coach }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Coach:</strong></td>
                                        <td style="text-align:right">{{ personnelData.ContactCoach }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <table>
                                    <tr>
                                        <td><strong>Nom Tuteur:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Nom_et_prenom_du_tuteur }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact du Tuteur:</strong></td>
                                        <td style="text-align:right">{{ personnelData.Contact_du_tuteur }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-4 d-none d-sm-block">
                                <img src="assets/img/unknow.jpg" class="rounded mx-auto d-block img-fluid d-flex justify-content-center" style="width:160px;height:160px">
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="text-center"><span style="background-color:#f9fbfd">Info appels telephonique</span></h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="card">
                    <div class="card-header">
                        <h2><span>Chronometre d'appel</span></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-4 text-center">
                                <select class="form-control input-sm" v-model="sim">
                                    <option value="Telma">Telma</option>
                                    <option value="Orange">Orange</option>
                                </select>
                            </div>

                            <div class="form-group col-4 text-center" style="font-size:20px">
                                {{ tempsMinute }}
                            </div>

                            <div v-if="!timerIsCounting" class="form-group col-4 text-center">
                                <button type="button" class="btn btn-success btn-round" v-on:click="startTimer">Demarrer</button>
                            </div>
                            <div v-if="timerIsCounting" class="form-group col-4 text-center" >
                                <button type="button" data-toggle="modal" data-target="#confirmModal" class="btn btn-danger btn-round" v-on:click="stopTimer">Arreter</button>
                            </div>

                        </div>
                    </div>
                </div>
                <h2 class="text-center"><span style="background-color:#f9fbfd">Info Sanction</span></h2>
                <hr style="background-color: #47e5ff;height:2px;margin-top: -22px;">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-4  text-center">
                                <select class="form-control" v-model="typePersonnel">
                                    <option value="Commerciaux" selected>Commerciaux</option>
                                    <option value="Coach">Coach</option>
                                </select>
                            </div>
                            <div class="form-group col-4 ">
                                <input type="text" class="form-control input-sm" v-model="codeSanction" v-on:keyup="autoComplete" v-on:click="autoComplete" placeholder="code sanction">
                                <div v-if="showAutoComplete" class="panel-footer" style="float:top;position: absolute;z-index: 1;">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-on:click.left="changeSanction(sanction.Id,sanction.code_sanction,sanction.titre)" v-for="sanction in sanctions" v-bind:key="sanction" >
                                            <div >{{ sanction.titre }}</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group col-4 text-center">
                                <button type="button" class="btn btn-secondary btn-round" v-on:click="AddSanction"> Ajouter </button>
                            </div>
                        </div>
                        <div class="row text-center">
                            <textarea rows="3" class="form-control" readonly v-model="titreSanction"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h2><span>Tableau Sanction Telephonique Commercial</span></h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead >
                                        <tr class="bg-secondary" style="color:white">
                                            <th class="respText" scope="col-2">Date</th>
                                            <th class="respText" scope="col-2">Code Sanction</th>
                                            <th class="respText" scope="col-2">Designation</th>
                                            <th class="respText" scope="col-2">Action</th>
                                        </tr>
                                    </thead> 
                                    <tbody> 
                                        <tr v-for="sanctionP in sanctionsPersonnel" v-bind:key="sanctionP">
                                            <td class="respText" scope="col-2"> {{ sanctionP.datetime }} </td>
                                            <td class="respText" scope="col-2"> {{ sanctionP.code_sanction }} </td>
                                            <td class="respText" scope="col-2"> {{ sanctionP.titre }} </td>
                                            <td class="respText" scope="col-2"> <button type="button" class="btn btn-danger" v-on:click="removeSanctionPersonnel(sanctionP.id)" >supprimer</button> </td>
                                        </tr>
                                    </tbody> 
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" >Valider Controle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body justify-content-center">
                                <table>
                                    <tr>
                                        <td><strong>Commerciaux: </strong></td>
                                        <td>{{ matricule }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>sim: </strong></td>
                                        <td>
                                            <select class="form-control" v-model="sim">
                                                <option value="Telma">Telma</option>
                                                <option value="Orange">Orange</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>debut: </strong></td>
                                        <td>{{ tempsDebut }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>fin: </strong></td>
                                        <td>{{ tempsFin }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>durée: </strong></td>
                                        <td>{{ dureeMinute }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" data-toggle="modal" data-target="#exitModal" v-on:click="validateControle">valider</button>   
                            </div>
                        </div>
                    </div>
                </div>
                <!--
                <div class="modal fade" id="exitModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" >Valider Controle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                insertion reussit
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">ok</button>   
                            </div>
                        </div>
                    </div>
                </div>
                -->
                <!-- Modal  end -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ControleTelephonique",
    data() {
        return {
            titreSanction: '',
            showAutoComplete:false,
            codeSanction: '',
            idSanction: '',
            typePersonnel: 'Commerciaux',
            matricule: '',
            nouveauMatricule: '',
            personnelData: [],
            exist: false,
            sim: "Telma",
            timerIsCounting: false,
            temps: 0,
            duree: 0,
            tempsDebut: null,
            tempsFin: null,
            sanctions: [],
            sanctionsPersonnel: [],
            isSearchingAutoComplete:false,
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
        this.loadURLdata();
        this.countDownTimer();
        this.tempsDebut = this.getCurrentDateTime();
        this.tempsFin = this.getCurrentDateTime();
        this.loadSanctionsPersonnel();
    },
    computed:{
        tempsMinute: function(){
            return new Date(this.temps*1000).toISOString().substr(11, 8);
        },
        dureeMinute: function(){
            return new Date(this.duree*1000).toISOString().substr(11, 8);
        }
    },
    methods: {
        resetCommerciaux(){
            this.exist = false;
            this.matricule = '';
            this.nouveauMatricule = '';
            this.matricule = '';
            this.sanctionsPersonnel = [];
            localStorage.removeItem('matricule');
        },
        removeSanctionPersonnel(id){
            for(let i=0;i<this.sanctionsPersonnel.length;i++){
                if(this.sanctionsPersonnel[i].id == id){
                    this.sanctionsPersonnel.splice(i,1);
                    break; 
                }
            }
            axios.delete('/api/sanctionPersonnel/delete',{params:{id: id}}).then(response => {
                if(response.data.success){
                    this.loadSanctionsPersonnel();
                }
            });
        },
        loadSanctionsPersonnel(){
            axios.get('/api/sanctionPersonnel/getFromMatricule',{params: {matricule: this.matricule}}).then(response => {
                if(response.data.success){
                    this.sanctionsPersonnel = response.data.sanctionPersonnels;
                }
            });
        },
        changeCommerciauxNouveau(){
            this.$router.push('controleTelephonique');
        },
        changeSanction(Id,code,titre){
            this.showAutoComplete = false;
            this.codeSanction = code;
            this.titreSanction = titre;
            this.idSanction = Id;
        },
        autoComplete(){
            if((this.codeSanction.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingAutoComplete = true;
                this.titreSanction = "";
                this.idSanction = "";
                if(this.codeSanction != null ){
                    setTimeout(this.searchAutoComplete, 1000);
                }
            }    
        },
        searchAutoComplete(){
            this.resultats = [];
            axios.get('/api/sanction/',{params: {codeSanction: this.codeSanction}}).then(response => {
                this.isSearchingAutoComplete = false;
                if(response.data.success){
                    this.showAutoComplete = true;
                    this.sanctions = response.data.sanctions;
                }
            });
        },
        AddSanction(){
            if(this.idSanction != ""){
                if(this.typePersonnel == "Commerciaux"){
                    axios.post('/api/sanctionPersonnel/',{
                        code_sanction: this.codeSanction,
                        matricule_personnel: this.matricule,
                        matricule_coach: this.personnelData.Coach,
                        matricule_controlleur: window.Laravel.user.Matricule,
                        id_sanction: this.idSanction,
                        type_personnel: this.typePersonnel,
                        }).then(response => {
                        this.loadSanctionsPersonnel();
                    });
                }
                else if(this.typePersonnel == "Coach"){
                    axios.post('/api/sanctionPersonnel/',{
                        code_sanction: this.codeSanction,
                        matricule_personnel: this.matricule,
                        matricule_coach: "aucun",
                        matricule_controlleur: window.Laravel.user.Matricule,
                        id_sanction: this.idSanction,
                        type_personnel: this.typePersonnel,
                        }).then(response => {
                        this.loadSanctionsPersonnel();
                    });
                }
            }
            //alert(this.codeSanction);
            /*axios.post('/api/sanctionPersonnel/',{
                codeSanction: this.codeSanction
                //matricule_personnel
                //matricule_coach
                //matricule_controlleur
                //id_sanction
                }).then(response => {
            });*/
        },
        changeCommerciaux(){
            this.matricule = this.nouveauMatricule;
            this.nouveauMatricule = "";
            this.getPersonnel();
        },
        getCurrentDateTime(){
            let today = new Date();
            let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            let dateTime = date+' '+time;
            return dateTime;
        },
        countDownTimer(){
            if(this.temps >= 0) {
                setTimeout(() => {
                    if(this.timerIsCounting){
                        this.temps += 1
                    }
                    this.countDownTimer()
                }, 1000)
            }
        },
        startTimer(){
            this.tempsDebut = this.getCurrentDateTime();
            this.tempsFin = this.getCurrentDateTime();
            this.timerIsCounting = true;
        },
        getTemps(){
            var today = new Date();
            var date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
            var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
            var dateTime = date+' '+time;
        },
        stopTimer(){
            if(this.timerIsCounting){
                this.tempsFin = this.getCurrentDateTime();
                this.timerIsCounting = false;
                this.duree = this.temps;
                this.temps = 0;
            }
            else{
                alert("demarrer dabord le timer");
            }
        },
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('matricule')){
                this.isLoadingData = true;
                this.matricule = urlParams.get('matricule');
                this.getPersonnel();
            }
            else if(localStorage.matricule){
                this.isLoadingData = true;
                this.matricule = localStorage.matricule;
                this.getPersonnel();
            }
        },
        validateControle(){
            axios.post('/api/controle/',{sim: this.sim,debut: this.tempsDebut,fin: this.tempsFin,commercial: this.matricule,controlleur:window.Laravel.user.Matricule.trim()}).then(response => {
                this.nouveauMatricule = '';
                //this.exist = false;
                alert("controle reusssit");
            });
        },
        getPersonnel(){
            this.$axios.get('/api/personnels/getPersonnelData',{params: {matricule: this.matricule }}) 
            .then(response => {
                this.exist=response.data.success;
                if(this.exist){
                    localStorage.matricule = this.matricule;
                    this.personnelData = response.data.personnel;
                    if(this.personnelData.Id_de_la_mission == "aucune"){
                        alert("attention ce commercial n est actuellement sur aucune mission");
                    }
                    this.loadSanctionsPersonnel();
                }
                else{
                    alert(this.matricule+" n'existe pas ");
                }
                this.isLoadingData = false;
            });
        }
    }
}
</script>