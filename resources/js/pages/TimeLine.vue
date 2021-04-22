<template>
    <div class="row">
        <div class="form-group col-md-4">
            <label for="dateMission">date</label>
            <input type="date" class="form-control" id="dateMission" v-model="dateMission">
            <button class="btn btn-secondary" v-on:click="loadMissionDate()">
                test
            </button>
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
        loadMissionDate(){
            alert(this.dateMission);
        }
    },
    components: {
        
    },
}
</script>