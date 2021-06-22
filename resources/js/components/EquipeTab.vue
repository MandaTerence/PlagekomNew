<template>
    <div class="row">
        <div class="col-6">
            <h4>{{ titre }}</h4>
        </div>
        <div class="col-6">
            <h4 class="text-right">Nombre: {{equipes.length }}</h4>
        </div>
    </div>
    <div class="row table-responsive">
        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
            <thead >
                <tr class="bg-secondary" style="color:white">
                    <th class="respText" scope="col-md-2">matricule</th>
                    <th class="respText" scope="col-md-2 d-none">nom et prenom</th>
                    <th class="respText" scope="col-md-2">C.A</th>
                    <th class="respText" scope="col-md-1"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="equipe in equipes" v-bind:key="equipe">
                    <td class="respText" scope="col-md-2">{{ equipe.Matricule }}</td>
                    <td class="respText" scope="col-md-2">{{ equipe.Nom+equipe.Prenom }}</td>
                    <td class="respText" scope="col-md-2">{{ equipe.CA }} Ar</td>
                    <td class="respText" scope="col-md-1">
                        <button class="btn btn-danger" v-on:click="remove(equipe.Matricule)">
                        <div class="d-none d-lg-block">
                            supprimer
                        </diV>
                        <div class="d-block d-lg-none">
                            X
                        </div>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    name: "EquipeTab",
    props: {
        equipes: {
            type: Array,
            required: true
        },
        titre: {
            type: String,
            required: true
        }
    },
    created() {
      
    },
    methods: {
        remove(matricule){
            for( var i = 0; i < this.equipes.length; i++){ 
                if ( this.equipes[i].Matricule ==  matricule) { 
                    this.equipes.splice(i, 1);
                    i--; 
                }
            }
        },
    }
}
</script>