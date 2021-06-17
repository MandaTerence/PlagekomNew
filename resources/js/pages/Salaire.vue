<template>
    <div class="panel-header bg-secondary-gradient">
        <div class="page-inner py-3">
            <h2 class="text-white pb-2 fw-bold">Salaire du mois</h2>
        </div>
    </div>
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="input-group col-12">
                        <input type="text" class="form-control" v-model="matricule" >
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary" v-on:click="reloadPersonnel">
                                <span class="resptext">rechercher</span>
                                <i style="margin-left:5px;font-size:15px" class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {{ hideZero }}
                        <input type="checkbox" class="checkbox" v-model="hideZero" v-on:click="reloadPersonnel">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive-sm">
                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                            <thead >
                                <tr class="bg-secondary" style="color:white">
                                    <th class="respText" >matricule</th>
                                    <th class="respText" >nom et prenom</th>
                                    <th class="respText" >Salaire net</th>
                                    <th class="respText" >Deduction</th>
                                    <th class="respText" >Salaire totale</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="personnel in personnels" v-bind:key="personnel">
                                    <td class="respText" >{{ personnel.Matricule }}</td>
                                    <td class="respText" >{{ personnel.Nom+" "+personnel.Prenom }}</td>
                                    <td class="respText"  style="text-algin:right">{{ personnel.salaire }} Ar</td>
                                    <td class="respText"  style="text-algin:right">{{ personnel.malusVente }} Ar</td>
                                    <td class="respText"  style="text-algin:right">{{ personnel.salaire - personnel.malusVente }} Ar</td>
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
            hideZero: false
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
        this.reloadPersonnel();
    },
    methods: {
        test(){
            alert("test");
        },
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