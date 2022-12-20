<template>
    <div id="background">
      <v-container fill-height fluid>
        <v-card elevation="12" class="centered">
          <h2 class="text-center " style="font-weight: 1000;">DAFTAR</h2>
          <v-text-field 
            label="Name" 
            v-model="name" 
            placeholder="Masukkan Nama"
            outlined>
          </v-text-field>

          <v-text-field 
            type="email"
            label="Email" 
            v-model="email" 
            placeholder="Masukkan Email" 
            outlined>
          </v-text-field>

          <v-text-field 
            type = "number"
            label="Nomor HP" 
            v-model="nomor_hp" 
            placeholder="Masukkan Nomor HP" 
            outlined>
          </v-text-field>

          <v-text-field 
            label="Password" 
            v-model="password" 
            placeholder="Masukkan Password" 
            outlined>
          </v-text-field>
          
            <v-btn block :loading="load" @click="register()" color="success">Daftar</v-btn>
              <p class="mt-3 text-center">Sudah Punya Akun? <router-link to="/login">Masuk</router-link></p>
        </v-card>
      </v-container>
    </div>
  </template>
  <script>
  /* eslint-disable */
  export default {
    name: 'RegisterPage',
  
    data() {
    return {
      load: false,
      snackbar: false,
      error_message: '',
      color: '',
      name: '',
      nomor_hp: '',
      password: '',
      email: "",
    };
  },
  
    methods: {
      register() {
        this.load = true
        this.$http.post(this.$api + "/register", {
            name: this.name,
            nomor_hp: this.nomor_hp,
            email: this.email,
            password: this.password,
          })
          .then(response => {
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            this.$router.push('/login')
          })
          .catch(error => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
          })
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
      .register{
        border: 5px solid rgb(5,111,111);
      }
    }
  </style>
  
   
    