<template>
<div class="panel-header bg-secondary-gradient" >
    <div class="page-inner py-4">
        <div class="row text-white pb-2 fw-bold">
            <h1>Classification Commerciaux</h1>
        </div>
    </div>
</div>
<div class="page-inner">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills nav-secondary" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active show" data-toggle="pill" role="tab" aria-selected="true" >Tous les commerciaux</a>
                </li>
                <li class="nav-item submenu">
                    <a class="nav-link show" data-toggle="pill" role="tab" aria-selected="false" >commerciaux en mission</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" data-toggle="pill" role="tab" aria-selected="false" >commerciaux en local</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link show" data-toggle="pill" role="tab" aria-selected="false" >commerciaux au repos</a>
                </li>
            </ul>
            <div id="tableau-commerciaux">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="bg-secondary" style="color:white">
                                <th class="respText">Classement</th>
                                <th class="respText">Matricule</th>
                                <th class="respText">Nom et Prenom</th>
                                <th class="respText">C.A</th>
                                <th class="respText">Nombre de Produit</th>
                                <th class="respText">Assuidite</th>
                                <th class="respText">Nombre de mission</th>
                            </tr>
                        </thead>
                            <tr>
                                <td class="respText">Classement</td>
                                <td class="respText">Matricule</td>
                                <td class="respText">Nom et Prenom</td>
                                <td class="respText">C.A</td>
                                <td class="respText">Nombre de Produit</td>
                                <td class="respText">Assuidite</td>
                                <td class="respText">Nombre de mission</td>
                            </tr>
                        <tbody>
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
    name: "ClassificationCommerciaux",
    data() {
        return {
            classificationSave: [],
            classification: [],
            equipes: []
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
        getClassificationtout(){

        }
    }
}
</script>
 