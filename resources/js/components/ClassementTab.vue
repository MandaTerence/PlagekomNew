<template>
    <div class="row">
        <h2 class="text-center">classement proposé</h2>
        <div class="table-responsive">
            <table class="table table-hover respText">
                <thead>
                    <tr class="bg-secondary respText" style="color:white">
                        <th class="respText">matricule</th>
                        <th class="respText">nom et prenom</th>
                        <th class="respText">place</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="respText" v-for="personnel in classementReel" v-bind:key="personnel">
                        <td class="respText">{{ personnel.Matricule }}</td>
                        <td class="respText">{{ personnel.Nom }}</td>
                        <td class="respText"><input type="number" v-model="personnel.placeTemp" v-on:change="changeClassement(personnel.place,personnel.placeTemp)"/></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive" v-for="classement in classements" v-bind:key="classement">
            <h1>{{ classement.titre }}</h1>
            <div >
                <table class="table table-hover respText"> 
                    <thead>
                        <tr class="bg-secondary respText" style="color:white">
                            <th class="respText">matricule</th>
                            <th class="respText">nom et prenom</th>
                            <th class="respText">C.A</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="respText" v-for="personnel in classement.classement" v-bind:key="personnel">
                            <td class="respText">{{ personnel.Matricule }}</td>
                            <td class="respText">{{ personnel.Nom }}</td>
                            <td class="respText">{{ personnel.CA }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
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