<template>
    <div class="row">
        <div class="card col-md-4">
            <div class="card-body">
                <div class="form-group">
                    <label for="dateMission">date</label>
                    <div class="form-control" id="dateMission">
                        <input type="date" class="form-control"  v-model="dateMission">
                    </div>
                </div>
                <div class="form-group">
                </div>
                <div v-if="dateMission!=null" class="row">
                    <div class="form-group col-md-4">
                        <button class="btn btn-secondary form-control" id="btnCheck" v-on:click="loadMissionDate()">
                            check
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div>
        <div class="row"><h3>Controle mission diego</h3></div>
        <div class="row">
            <div class="col-md-3">
                <strong>Nombre equipe :</strong>
            </div>
            <div class="col-md-3">
                <strong>Ville d animation :</strong>
            </div>
            <div class="col-md-3">
                <strong>Durée totale controle :</strong>
            </div>
            <div class="col-md-3">
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
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>

export default {
    name: "TimeLine",
    data() {
        return {
            dateMission: null
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    created() {
        
    },
    methods: {
        test(){

        },
        loadMissionDate(){
            if(this.dateMission!=null){
                axios.get('/api/personnels/getAllFromMission',{params: {jour: this.dateMission}}).then(response => {
                   
                });
            }
            //alert(this.dateMission);
        }
    },
    components: {
        
    },
}
</script>