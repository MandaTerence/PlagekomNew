<template>
    <div name="modal" v-if="showModal" @close="showModal = false">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-body">
                        <table class="table table-hover">
                            <thead >
                                <tr class="bg-primary" style="color:white">
                                    <th scope="col-md-2">matricule</th>
                                    <th scope="col-md-2">nom et prenom</th>
                                    <th scope="col-md-2">C.A</th>
                                    <th scope="col-md-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="coach in coachs" v-bind:key="coach">
                                    <td scope="col-md-2">{{ coach.Matricule }}</td>
                                    <td scope="col-md-2">{{ coach.Nom+" "+coach.Prenom }}</td>
                                    <td scope="col-md-2">{{ coach.CA }}</td>
                                    <td scope="col-md-1">
                                        <button class="btn btn-danger" v-on:click="remove(coachs,coach.Matricule)">
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
                        <table class="table table-hover">
                            <thead >
                                <tr class="bg-primary" style="color:white">
                                    <th scope="col-md-2">matricule</th>
                                    <th scope="col-md-2 d-none">nom et prenom</th>
                                    <th scope="col-md-2">C.A</th>
                                    <th scope="col-md-2">place</th>
                                    <th scope="col-md-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="classement in classements" v-bind:key="classement">
                                    <td scope="col-md-2" v-if="classement.place == classement.placeOriginal">{{ classement.Matricule }}</td>
                                    <td scope="col-md-2" style="color:red" v-else-if="classement.place > classement.placeOriginal">{{ classement.Matricule }} ({{  classement.placeOriginal - classement.place }} place)</td>
                                    <td scope="col-md-2" style="color:green" v-else>{{ classement.Matricule }} (+{{  classement.placeOriginal - classement.place }} place)</td>
                                    <td scope="col-md-2">{{ classement.Nom+classement.Prenom }}</td>
                                    <td scope="col-md-2">{{ classement.CA }}</td>
                                    <th scope="col-md-2"><input type="number" v-model="classement.placeTemp" v-on:change="changeClassement(classement.place,classement.placeTemp)"/></th>
                                    <td scope="col-md-1">
                                        <button class="btn btn-danger" v-on:click="remove(classement,classement.Matricule)">
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
                    <div class="modal-footer">
                        <slot name="footer">
                            <button class="btn btn-primary" v-on:click="validateEquipe">Valider</button>
                            <button class="btn btn-primary" v-on:click="showModal = false">retour</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ClassementModal",
    props: {
        showModal: {
            type: Boolean,
            required: true
        },
    },
    created() {
      
    },
    methods: {
        
    }
}
</script>