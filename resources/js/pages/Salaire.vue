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
                    <div class="col-6">
                        <label>Mois</label>
                        <month-picker-input v-bind:default-month="dateNow.getMonth()" v-bind:default-year="dateNow.getFullYear()" style="z-index:10" class="col-6" @change="showDate" @input="true"></month-picker-input>
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
import { MonthPickerInput } from 'vue-month-picker'

export default {
    name: "Salaire",
    data() {
        return {
            dateNow: new Date(),
            mois: '',
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
        alert(this.dateNow.getMonth()+" "+this.dateNow.getFullYear());
        this.loadAllSalaire();
        this.reloadPersonnel();
    },
    methods: {
        showDate (date) {
            var mon = date.month;
            var year = date.year;
            var dat = this.getMonthDays(mon+" "+year);
            this.mois = dat;
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
            return new Date(Value[1], month, 1).toISOString().slice(0, 10);
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