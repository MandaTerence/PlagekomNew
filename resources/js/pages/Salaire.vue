<template>
    <div class="panel-header bg-secondary-gradient">
        <div class="page-inner py-3">
            <h2 class="text-white pb-2 fw-bold">Salaire du mois</h2>
        </div>
    </div>
    <div class="page-inner">
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <input type="text" class="form-control" v-model="matricule" >
                    <button type="submit" class="btn btn-secondary" v-on:click="reloadPersonnel">rechercher</button>
                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                            <thead >
                                <tr class="bg-secondary" style="color:white">
                                    <th class="respText" scope="col-2">matricule</th>
                                    <th class="respText" scope="col-2">nom et prenom</th>
                                    <th class="respText" scope="col-2">Salaire net</th>
                                    <th class="respText" scope="col-2">Deduction</th>
                                    <th class="respText" scope="col-2">Salaire totale</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="personnel in personnels" v-bind:key="personnel">
                                    <td class="respText" scope="col-2">{{ personnel.Matricule }} Ar</td>
                                    <td class="respText" scope="col-2">{{ personnel.Nom+" "+personnel.Prenom }} Ar</td>
                                    <td class="respText" scope="col-2">{{ personnel.salaire }} Ar</td>
                                    <td class="respText" scope="col-2">{{ personnel.malusVente }} Ar</td>
                                    <td class="respText" scope="col-2">{{ personnel.salaire - personnel.malusVente }} Ar</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Salaire",
    data() {
        return {
            matricule: '',
            personnels:[],
            personnelsSave:[],
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    created() {
        this.loadAllSalaire();
    },
    methods: {
        loadAllSalaire(){
            axios.get('/api/personnels/getAllSalaire').then(response => {
                this.personnels = response.data.personnels;
                this.personnelsSave = response.data.personnels;
            });
        },
        reloadPersonnel(){
            if(this.matricule.length>1){
                this.personnels = [];
                for(let i=0;i<this.personnelsSave.length;i++){
                    if(
                        (this.personnelsSave[i].Matricule.includes(this.matricule))
                        ||(this.personnelsSave[i].Nom.includes(this.matricule))
                        ||(this.personnelsSave[i].Prenom.includes(this.matricule))
                    ){
                        this.personnels.push(this.personnelsSave[i]);
                    }
                }
            }
            else{
                this.personnels = this.personnelsSave;
            }
        }
    }
}
</script>