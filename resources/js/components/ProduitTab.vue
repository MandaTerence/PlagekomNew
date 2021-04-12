<template>
    <div class="row">
        <div class="col-6">
            <h4>Produit</h4>
            <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary">
                <thead>
                    <tr>
                        <th scope="col">Designation</th>
                        <th scope="col">Prix</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="produit in produits" v-bind:key="produit">
                        <td scope="col-md-2">{{ produit.Designation }}</td>
                        <td scope="col-md-2">{{ produit.prix }}</td>
                        <td scope="col-md-1">
                            <button class="btn btn-danger" v-on:click="remove(produit.Designation)">
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
    </div>
</template>

<script>
export default {
    name: "ProduitTab",
    props: {
        produits: {
            type: Array,
            required: true
        },
        titre: {
            type: String,
            default: 'Produits'
        }
    },
    computed:{
        produitsCher: function () {
            return this.produits.filter(p => p.prix >=14000)
        },
        produitsMoinCher: function () {
            return this.produits.filter(p => p.prix <14000)
        },
    },
    created() {
      
    },
    methods: {
        remove(Designation){
            for( var i = 0; i < this.produits.length; i++){ 
                if ( Designation ==  this.produits[i].Designation) {
                    this.produits.splice(i, 1);
                    i--; 
                }
            }
        },
        
    }
}
</script>