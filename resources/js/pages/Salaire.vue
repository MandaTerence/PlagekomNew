<template>
    <div class="panel-header bg-secondary-gradient">
        <div class="page-inner py-3">
            <h2 class="text-white pb-2 fw-bold">Salaire du mois</h2>
        </div>
    </div>
    <div class="page-inner">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex justify-content-end">
                    <div class="col-6 input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Mois</span>
                        </div>
                        <month-picker-input :default-year="dateNow.getFullYear()" :default-month="dateNow.getMonth()+1" :input-pre-filled="true" style="z-index:10" class="col-6" @change="showDate" @input="true"></month-picker-input>
                    </div>
                    <div class="input-group col-6">
                        <input type="text" class="form-control" v-model="matricule" placeholder="matricule">
                        <div class="input-group-prepend">
                            <button type="submit" class="btn btn-secondary" v-on:click="reloadPersonnel">
                                <span class="resptext">rechercher</span>
                                <i style="margin-left:5px;font-size:15px" class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 table-responsive-sm" v-if="personnels.length>0">
                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                            <thead >
                                <tr class="bg-secondary" style="color:white">
                                    <th class="respText" >matricule</th>
                                    <th class="respText" >nom et prenom</th>
                                    <th class="respText" >Salaire net</th>
                                    <th class="respText" >Deduction</th>
                                    <th class="respText" >Salaire totale</th>
                                    <th class="respText" >action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="personnel in personnels" v-bind:key="personnel">
                                    <td class="respText" >{{ personnel.Matricule }}</td>
                                    <td class="respText" >{{ personnel.Nom+" "+personnel.Prenom }}</td>
                                    <td class="respText text-right" >{{ getMoneyFormat(personnel.salaire) }} Ar</td>
                                    <td class="respText text-right" >{{ getMoneyFormat(personnel.malusVente) }} Ar</td>
                                    <td class="respText text-right" >{{ getMoneyFormat(personnel.salaire - personnel.malusVente) }} Ar</td>
                                    <td class="respText text-right" ><a v-on:click="afficherDetail(personnel)">voir detail</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-else class="row col-12 d-flex justify-content-center">
                        <span>
                            aucun résultat trouvé
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { MonthPickerInput } from 'vue-month-picker'

export default {
    name: "Salaire",
    data() {
        return {
            dateNow: new Date(),
            mois: '',
            annee: '',
            matricule: '',
            personnels:[],
            personnelsSave:[],
            hideZero: false,
            showModalDetail: false,
            personneDetail: ''
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    created() {
        //this.loadAllSalaire();
        this.getSalaire();
        this.reloadPersonnel();
    },
    methods: {
        afficherDetail(personnel){
            this.personneDetail = personnel;
        },
        getMoneyFormat(monnaie){
            if(monnaie)
                return monnaie.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$& '); 
            else
                return 0;
        },
        showDate (date) {
            var mon = date.month;
            var year = date.year;
            var dat = this.getMonthDays(mon+" "+year);
            this.mois = dat.getMonth();
            this.annee = dat.getFullYear();
            this.getSalaire();
		},
        getSalaire(){
            axios.get('/api/personnels/getAllSalaire',{params: {mois: this.mois,annee: this.annee}}).then(response => {
                this.personnels = response.data.personnels;
                this.personnelsSave = response.data.personnels;
            });
        },
        loadAllSalaire(){
            axios.get('/api/personnels/getAllSalaire').then(response => {
                this.personnels = response.data.personnels;
                this.personnelsSave = response.data.personnels;
            });
        },
        getMonthDays(MonthYear) {
            var months = [
                'January',
                'February',
                'March',
                'April',
                'May',
                'June',
                'July',
                'August',
                'September',
                'October',
                'November',
                'December'
            ];

            var Value=MonthYear.split(" ");      
            var month = (months.indexOf(Value[0]) + 1);      
            return new Date(Value[1], month, 1);
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
    },
    components: {
		MonthPickerInput
	}
}

</script>