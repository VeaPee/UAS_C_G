<template>
    <div class="navbar">
      <nav class="navbar fixed-top navbar-dark navbar-expand-md justify-content-md-center justify-content-start">
        <div class="container-fluid">
          <img src="https://i.etsystatic.com/25165650/r/il/e02d40/2860302450/il_794xN.2860302450_feev.jpg" alt="" width="28" height="28" />
          <a class="navbar-brand judul">E-Sportstation</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav mx-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px; padding-right: 3.5rem" link>
              <li class="nav-item d-flex align-self-center">
                <router-link class="nav-link" :to="{ path: '/menu' }">Beranda</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ path: '/tambahteam' }">Team</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ path: '/tambahtournament' }">Tournament</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ path: '/transaksitiket' }">Transaksi Tiket</router-link>
              </li>
              <li class="nav-item">
                <router-link class="nav-link" :to="{ path: '/aboutus' }">About Us</router-link>
              </li>
              <!-- <li class="nav-item">
                <router-link class="nav-link" :to="{ path: '/home' }">Home</router-link>
              </li> -->
            </ul>
            
            <ul class="nav navbar-nav flex-row justify-content-md-center justify-content-start flex-nowrap">
              <div class="d-flex" v-if="cekLogin() === 'guest'" style="margin-left: 0.4rem">
                <router-link class="router" :to="{ path: '/login' }">
                  <button type="button" class="btn btn-outline-primary" style="color: #f0f0f0; margin-left: 0.5rem">LOGIN</button>
                </router-link>
              </div>
              <div class="d-flex" v-else-if="cekLogin() === 'user'" style="padding-left: 2.9rem">
                <router-link class="router" :to="{ path: '/profile' }">
                  <i class="fa fa-user-circle" aria-hidden="true" style="color: white; font-size: 35px"></i>
                </router-link>
              </div>
              <div class="d-flex" v-else-if="cekLogin() === 'logout'">
                <button type="button" @click="logout" class="btn btn-outline-primary" style="color: #f0f0f0">LOGOUT</button>
              </div>
            </ul>
          </div>
        </div>
      </nav>
      <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom> {{ error_message }} </v-snackbar>
      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <!-- View Route -->
        <router-view></router-view>
      </main>
      <Footer />
    </div>
  </template>
  
  <script setup>

  import Footer from '@/components/FooterLayout.vue'
  
  </script>

  <script>

import axios from 'axios'
  export default {
    name: "NavbarProcess",
    data() {
      return {
        load: false,
        snackbar: false,
        error_message: "",
        color: "",
      };
    },
    watch: {
      $route() {
        this.$forceUpdate();
      },
    },
    methods: {
      cekLogin() {
        if (localStorage.getItem("token") == null) {
          return "guest";
        } else {
          if (localStorage.getItem("token") != null) {
            if (this.$route.name == "Profile") return "logout"
            else return "user";
          }
        }
      },
      logout() {
        this.load = true;
          axios.get(this.$api + '/logout', {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            }
          })
          .then((response) => {
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            localStorage.removeItem("id");
            localStorage.removeItem("token");
            localStorage.removeItem("user");
            this.$router.push({
              name: "Home",
            });
          })
          .catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
          });
      },
    },
  };
</script>
  
  <style scoped>
  nav {
    background-color: #000000;
  }
  a.router-link-exact-active {
    color: white !important;
  }
  .judul {
    font-size: 17.5px !important;
  }
  button {
    font-size: 13px;
  }
  </style>