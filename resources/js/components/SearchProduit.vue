<template>
    <div class="form-row">
        <div class="form-group col-6">
            <label for="inputProduit">Produit</label>
            <input type="text" placeholder="what are you looking for?" v-model="produitDesignation" class="form-control" v-on:keyup="autoComplete" v-on:click="autoComplete">
            <div class="panel-footer" style="float:top;position: absolute;z-index: 1;">
                <ul class="list-group">
                    <li class="list-group-item" v-for="result in resultats" v-bind:key="result" v-on:click.left="changeProduit(result.Designation)" >
                        <div >{{ result.Designation }}</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="form-group col-6">
            <button class="btn btn-secondary " style="margin:30px" v-on:click="addProduit">Ajouter</button>
        </div>
    </div>
</template>
<script>
export default {
    name: "SearchProduit",
    data() {
        return {
            produitDesignation: '',
            isSearchingAutoComplete: false,
            resultats: ''
        }
    },
    props: {
        produits: {
            type: Array,
            required: true
        }
    },
    created() {
        
    },
    methods: {
        autoComplete(){
            if((this.produitDesignation.length > 2)&&(!this.isSearchingAutoComplete)){
                this.isSearchingAutoComplete = true;
                if(this.produitDesignation != null ){
                    setTimeout(this.searchAutoComplete, 1000);
                }
            } 
        },
        searchAutoComplete(){
            this.resultats = [];
            if(this.customId == null){
                axios.get('/api/produits/getProduitByDesignation',{params: {Designation: this.produitDesignation}}).then(response => {
                    this.isSearchingAutoComplete = false;
                    if(response.data.success){
                        this.resultats = response.data.produits;
                    }
                    else{
                        alert(response.data.message);
                    }
                });
            }
        },
        changeProduit(designation){
            this.resultats = [];
            this.produitDesignation = designation;
        },
        addProduit(){
            let produitExist = false;
            for(let i=0;i<this.produits.length;i++){
                if(this.produits[i].Designation == this.produitDesignation){
                    produitExist = true;
                    break;
                }
            }
            if(!produitExist){
                axios.get('/api/produits/getFirst',{params: {criteres: {Designation: this.produitDesignation}}}).then(response => {
                    if(response.data.success){
                        this.produits.push(response.data.produit);
                    }
                    else{
                        alert('aucun resultat trouvé');
                    }
                });
            }
            else{
                alert('ce produit a deja etait ajouter');
            }
        }
    }
}
</script>