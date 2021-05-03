<template>
    <div class="form-row">
        <h1>Classement Reel</h1>
        <table class="table table-hover">
            <thead >
                <tr class="bg-secondary" style="color:white">
                    <th scope="col-md-2">matricule</th>
                    <th scope="col-md-2">nom et prenom</th>
                    <th scope="col-md-2">C.A</th>
                    <th scope="col-md-1">place</th>
                </tr>
            </thead>
            <tbody>  
                <tr v-for="personnel in classementReel" v-bind:key="personnel">
                    <td scope="col-md-2">{{ personnel.Matricule }}</td>
                    <td scope="col-md-2">{{ personnel.Nom }}</td>
                    <td scope="col-md-2">{{ personnel.CA }}</td>
                    <th scope="col-md-2"><input type="number" v-model="personnel.placeTemp" v-on:change="changeClassement(personnel.place,personnel.placeTemp)"/></th>
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
        recalculPlace(){
            let newClassement = [];
            for(let i=0;i<this.classementReel.length;i++){
                newClassement.push(this.classementReel[i]);
                newClassement[i].placeTemp = i+1;
                newClassement[i].place = i+1;
            }
            for(let i=0;i<this.classementReel.length;i++){
                this.classementReel.splice(i,1,newClassement[i]);
            }
        },
        changeClassement(place,placeTemp){
            if((placeTemp<1)||(placeTemp>this.classementReel.length)){
                alert("changement de place impossible");
                this.classementReel[place-1].placeTemp = place;
            }                        
            else{
                let elementTemp = this.classementReel[place-1];
                this.classementReel.splice(place-1,1);
                this.classementReel.splice(placeTemp-1, 0, elementTemp);
                this.recalculPlace();
            }
        },
        test(){
            alert("test ok")
        }
    }
}
</script>