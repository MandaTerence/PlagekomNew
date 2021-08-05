<template>
<div class="page-inner">
    <div class="row justify-content-center" >
        <div class="card col-md-6">
            <div class="card-body">
                bienvenu
            </div>
        </div>
    </div>
    <div class="col-12 d-flex pt-md-3 justify-content-center">
  <div class="badge_content controlleur">
  <div welcome="" style="display: none;">Bienvenue</div>    <div class="row entete mb-5 justify-content-center">

      <div class="col-12 d-flex justify-content-center" style="padding-top:25px">
        <img style="width:150px" src="http://komone.combo.fun/images/logomobile.png" alt="">
      </div>

      <h5 class="col-12 text-center fonction" style="color:rgb(255, 200, 0)">
          Controleur      </h5>

    </div>

        <div class="d-flex justify-content-center col-12" id="ch_img_utilisateur" style="background: rgb(255, 200, 0)">
        <img style="border:5px solid rgb(255, 200, 0);" v-bind:src="imageURL" alt="">
        </div>

        <div class="w-100" style="border-top:4px solid rgb(57,57,57,57); height:5px;"></div>
        <div class="w-100" style="background: rgb(255, 200, 0);height:10px;margin-top:3px"></div>

        <div id="info_utilisateur" style="background-color: rgb(56,56,56)">
        <div class="w-100 text-center text-white font-weight-bold" style="border-left: 10px solid rgb(255, 200, 0);border-right: 10px solid rgb(255, 200, 0);">
            <h4>RAKOTOARIMALALA          <br>Maminirina          <br>106-301-033-436          <br>OTO108        </h4>
        </div>
        <div class="w-100 d-flex ch_qr justify-content-center" style="border-bottom:solid 10px rgb(255, 200, 0);">
            <div id="qr" style="background: url(http://gestion-commerciale.in-expedition.com/image/QRCode/VP00080.png)">
            </div>
        </div>
        </div>
    </div>
    </div>
</div>
</template>

<script>
export default {
    name: "Home",
    data() {
        return {
            imageURL:""
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/login";
        }
        next();
    },
    created() {
        this.loadProfilePicture();
    },
    methods: {
        loadProfilePicture(){
            this.imageURL= "http://komone.combo.fun/images/personnel/"+window.Laravel.user.Matricule+".jpg";
        }
    }
}
</script>