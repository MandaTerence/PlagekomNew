<template>
    <div>
        <div class="card" >
            <div class="card-body ">
                <div class="form-group">
                    <label for="matricule">Matricule</label>
                    <input type="text" class="form-control" id="matricule"  placeholder="Matricule" v-model="nouveauMatricule">
                </div>
                <div class="form-group text-center">
                    <button type="button" class="btn btn-secondary" v-on:click="changeCommerciaux">controler</button>
                </div>
            </div>
        </div>
    </div>
    <div v-if="exist">
        <div class="card" >
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td><strong>Nom Commercial:</strong></td>
                                <td>{{ personnelData.Nom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Prenom Commercial:</strong></td>
                                <td>{{ personnelData.Prenom }}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact:</strong></td>
                                <td>{{ personnelData.Contact_du_personnel }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mission Actuel:</strong></td>
                                <td>{{ personnelData.Id_de_la_mission }}</td>
                            </tr>
                            <tr>
                                <td><strong>Coach Commerciale:</strong></td>
                                <td>{{ personnelData.Coach }}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact Coach:</strong></td>
                                <td>{{ personnelData.ContactCoach }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td><strong>Nom Tuteur:</strong></td>
                                <td>{{ personnelData.Nom_et_prenom_du_tuteur }}</td>
                            </tr>
                            <tr>
                                <td><strong>Contact du Tuteur:</strong></td>
                                <td>{{ personnelData.Contact_du_tuteur }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">

                    <div class="form-group">
                        <select class="form-control" v-model="sim">
                            <option value="Telma">Telma</option>
                            <option value="Orange">Orange</option>
                        </select>
                    </div>

                    <div class="form-group">
                        {{ tempsMinute }}
                    </div>

                    <div v-if="!timerIsCounting" class="form-group">
                        <button type="button" class="btn btn-success" v-on:click="startTimer">Demarrer</button>
                    </div>
                    <div v-if="timerIsCounting" class="form-group">
                        <button type="button" data-toggle="modal" data-target="#confirmModal" class="btn btn-danger" v-on:click="stopTimer">Arreter</button>
                    </div>

                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="form-group">
                        <select class="form-control" v-model="typePersonnel">
                            <option value="Commerciaux" selected>Commerciaux</option>
                            <option value="Coach">Coach</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="codeSanction" v-on:keyup="autoComplete" v-on:click="autoComplete" placeholder="code sanction">
                        <div v-if="showAutoComplete" class="panel-footer" style="float:top;position: absolute;z-index: 1;">
                            <ul class="list-group">
                                <li class="list-group-item" v-on:click.left="changeSanction(sanction.id,sanction.code_sanction,sanction.titre)" v-for="sanction in sanctions" v-bind:key="sanction" >
                                    <div >{{ sanction.code_sanction }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary form-control" v-on:click="AddSanction">Ajouter</button>
                    </div>
                </div>
                <div class="row">
                    <textarea rows="3" class="form-control" readonly v-model="titreSanction"></textarea>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <table class="table table-hover table-bordered" style="font-size:10px">
                        <thead >
                            <tr class="bg-secondary" style="color:white">
                                <th scope="col-md-2">Code Sanction</th>
                                <th scope="col-md-2">Designation</th>
                                <th scope="col-md-2">Autres</th>
                                <th scope="col-md-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sanctionP in sanctionsPersonnel" v-bind:key="sanctionP">
                                <td scope="col-md-2"> {{ sanctionP.code_sanction }} </td>
                                <td scope="col-md-2"> {{ sanctionP.titre }} </td>
                                <td scope="col-md-2"> </td>
                                <td scope="col-md-2"> <button type="button" class="btn btn-danger" v-on:click="removeSanctionPersonnel(sanctionP.id)" >supprimer</button> </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-primary" data-dismiss="modal" v-on:click="validateControle">valider</button>   
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal  end -->
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
            isSearchingAutoComplete:false
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
        changeSanction(id,code,titre){
            //alert(window.Laravel.user.Matricule);
            this.showAutoComplete = false;
            this.codeSanction = code;
            this.titreSanction = titre;
            this.idSanction = id;
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
                this.matricule = urlParams.get('matricule');
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
                    this.personnelData = response.data.personnel;
                    if(this.personnelData.Id_de_la_mission == "aucune"){
                        alert("attention ce commercial n est actuellement sur aucune mission");
                    }
                    this.loadSanctionsPersonnel();
                }
                else{
                    alert(this.matricule+" n'existe pas ");
                }
            });
        }
    }
}
</script>