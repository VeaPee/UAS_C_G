<template>
  <div id="background">
    <v-container fill-height fluid>
      <v-card elevation="2" class="centered">
        <h2 class="text-center" style="font-weight: 1000;">MASUK</h2>

        <v-text-field 
          type="email"
          label="Email" 
          v-model="email" 
          placeholder="Masukkan Email" 
          outlined 
          :rules="emailRules">
        </v-text-field>

        <v-text-field 
          type="password" 
          label="Password" 
          v-model="password" 
          placeholder="Masukkan Password" 
          outlined 
          :rules="passwordRules">
        </v-text-field>

          <v-btn block class="m-0" color="success" :loading="isLoading" @click="login()">Masuk</v-btn>
            <p class="mt-3 text-center">Belum punya akun? <router-link to="/register">Daftar</router-link></p>
      </v-card>
    </v-container>
  </div>
</template>
<script>

/* eslint-disable */
export default {
  name: 'LoginPage',

  data() {
    return {
      isLoading: false,
      snackbar: false,
      error_message: "",
      valid: false,
      color: "",
      password: "",
      email: "",
      passwordRules: [
                (v) => !!v || "Harap isi Password terlebih dahulu",
      ],

      emailRules: [
                (v) => !!v || "Harap isi E-mail terlebih dahulu",
      ],
    };
  },

  methods: {
    login() {
      this.isLoading = true;
      this.$http
          .post(this.$api + "/login", {
            email: this.email,
            password: this.password,
          })
        .then((response) => {
              this.isLoading = false;
              localStorage.setItem("id", response.data.data.id);
              localStorage.setItem("token", response.data.token);
              this.error_message = response.data.message;
              this.color = "green";
              this.snackbar = true;
              this.$router.push('/menu')
          
        })
        .catch((error) => {
            this.error_message = error.data.response.message;
            this.color = "red";
            this.snackbar = true;
            localStorage.removeItem("token");
            this.load = false;
          });
    }
  }
}
</script>
<style>
   #background {
      background: url(https://wallpapercave.com/wp/wp8371602.jpg);
      min-height: 92vh;
      display: flex;
    }
    .centered{
      margin: 0;
      width: 700px;
      padding: 20px;
      border: 8px solid rgb(	3, 4, 94);
      background-color: #FFFFFF;
      border-radius: 3px;
      justify-content: center;
      text-align: center;
      max-width: 1316px;
      position: absolute;
      top: 50%;
      left: 50%;
      margin-right: -50%;
      transform: translate(-50%, -50%)
    }

  @media screen and (max-width: 1316px){
    .login{
      border: 5px solid rgb(5,111,111);
    }
  }
</style>