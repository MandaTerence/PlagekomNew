<template>
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
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Coach Commerciale:</strong></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><strong>Contact Coach:</strong></td>
                                <td></td>
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
                    <div class="col-md-4">
                        of {{ matricule }} !
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <select class="form-control" v-model="sim">
                            <option value="Telma">Telma</option>
                            <option value="Orange">Orange</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        {{ tempsMinute }}
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-success" v-on:click="startTimer">Demarrer</button>
                    </div>
                    <div class="col-md-3">
                        <button type="button" class="btn btn-danger" v-on:click="stopTimer">Arreter</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ControleTelephonique",
    data() {
        return {
            matricule: '',
            personnelData: [],
            exist: false,
            sim: "Telma",
            timerIsCounting: false,
            temps: 0,
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
    },
    computed:{
        tempsMinute: function(){
            return new Date(this.temps*1000).toISOString().substr(11, 8);
        }
    },
    methods: {
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
            this.timerIsCounting = true;
        },
        stopTimer(){
            this.timerIsCounting = false;
            alert(this.tempsMinute);
            this.temps = 0;
        },
        loadURLdata(){
            let urlParams = new URLSearchParams(window.location.search);
            if(urlParams.get('matricule')){
                this.matricule = urlParams.get('matricule');
                this.getPersonnel();
            }
        },
        getPersonnel(){
            this.$axios.get('/api/personnels/getPersonnelData',{params: {matricule: this.matricule }}) 
            .then(response => {
                this.exist=response.data.success;
                this.personnelData = response.data.personnel;
            });
        }
    }
}
</script>