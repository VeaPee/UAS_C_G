<template>
    <div id="background">
      <v-content>
        <v-container fill-height fluid>
        <v-layout align-center justify-center>
          <v-card elevation="12" class="centered">
            <h2 class="text-center">MASUK</h2>
            <p class="text-center mb-5">Selamat Datang di <b>Sonic Hunter</b>,<br>Team Esport Terbaik Serta Pengadaan Tournament Terbaik</p>
            <form @submit.prevent="login">
              <label for="email">Email</label><br>
              <input
              class="text-center"
              label="Email" 
              v-model="user.email"
              placeholder="Masukkan Email" 
              outlined 
              :error-messages="errors.email"><br><br>
              <label for="password">Password</label>
              <br>
            <input
            class="text-center"
              type="password" 
              label="Password" 
              v-model="user.password" 
              placeholder="Masukkan Password" 
              outlined 
              :error-messages="errors.password">
            <br><br>
              <btn type="submit" class="m-0" outlined color="success" @click="login()">Masuk</btn>
            </form>
            
                <p class="mt-3 text-center">Belum punya akun? <router-link to="/register">Register</router-link></p>
          </v-card>
        </v-layout>
      </v-container>
      </v-content>

    </div>
  </template>

  <script>
  import axios from 'axios'
  
  export default {
    name: 'LoginPage',
  
    data: () => ({
      user: {
        email: '',
        password: ''
      },
      errors: {},
      isLoading: false
    }),
  
    methods: {
      login() {
        this.isLoading = true
        axios.post('http://127.0.0.1:8000/api/' + "login", JSON.stringify(this.user), {
          headers: {
            'Content-Type': 'application/json'
          }
        })
          .then(res => {
            this.isLoading = false
            localStorage.setItem('token', res.data.token);
            this.$router.push('/')
          })
          .catch(err => {
            this.isLoading = false;
            this.errors = err.response.data.errors || {}
          })
      }
    }
  }
  </script>
  <style>
    #background {
      background: url(https://wallpapercave.com/wp/wp8371602.jpg);
      min-height: 100vh;
      justify-content: center;
      
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
  
  </style>
  
  