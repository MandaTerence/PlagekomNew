<template>
    <div class="form-row">
        <h1>Classement Reel</h1>
        <table class="table table-hover">
            <thead >
                <tr class="bg-secondary" style="color:white">
                    <th scope="col-md-2">matricule</th>
                    <th scope="col-md-2">nom et prenom</th>
                    <th scope="col-md-2">C.A</th>
                    <th scope="col-md-1"></th>
                </tr>
            </thead>
            <tbody>  
                <tr v-for="personnel in classementReel" v-bind:key="personnel">
                    <td scope="col-md-2">{{ personnel.Matricule }}</td>
                    <td scope="col-md-2">{{ personnel.Nom }}</td>
                    <td scope="col-md-2">{{ personnel.CA }}</td>
                    <td scope="col-md-1"></td>
                </tr>
            </tbody>
        </table>
        <div v-for="classement in classements" v-bind:key="classement">
            <h1>{{ classement.titre }}</h1>
            <table class="table table-hover"> 
                <thead >
                    <tr class="bg-secondary" style="color:white">
                        <th scope="col-md-2">matricule</th>
                        <th scope="col-md-2">nom et prenom</th>
                        <th scope="col-md-2">C.A</th>
                        <th scope="col-md-1"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="personnel in classement.classement" v-bind:key="personnel">
                        <td scope="col-md-2">{{ personnel.Matricule }}</td>
                        <td scope="col-md-2">{{ personnel.Nom }}</td>
                        <td scope="col-md-2">{{ personnel.CA }}</td>
                        <td scope="col-md-1"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: "ClassementTab",
    data() {
        return {
        }
    },
    props: {
        classements: {
            type: Array,
            required: true
        },
        classementReel: {
            type: Array,
            default: []
        },
    },
    created() {
        
    },
    methods: {
    
    }
}
</script>