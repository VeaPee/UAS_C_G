 <!-- <template>
    <div class="dashboard">
        <v-navigation-drawer class="fullheight" width="256" v-model="drawer"
        absolute temporary color="grey lighten-5">
        <v-list-item>
            <v-list-item-content>
                <v-list-item-title class="title">Almindo Savior Tiranda Rammang</v-list-item-title>
                <v-list-item-subtitle>200710662</v-list-item-subtitle>
            </v-list-item-content>
        </v-list-item>

        <v-divider></v-divider>

        <v-list dense nav>
            <v-list-item
            v-for="item in items"
            :key="item.title"
            link
            color="light-blue darken-4"
            tag="router-link"
            :to="item.to"
            >
                <v-list-item-content>
                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item-content>
            </v-list-item>
        </v-list>
        </v-navigation-drawer>
        <v-app-bar color="red lighten-3" dark>
            <v-app-bar-nav-icon
            @click="drawer = true"
            color="white"></v-app-bar-nav-icon>
            <VSpacer />
        </v-app-bar>
        <div class="fullheight pa-5">
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
    export default{
        name: "DasboardIndex",
        data(){
            return{
                drawer: false,
            group: null,
                items:[
                    { title: "Dashboard", to:"/"},
                    { title: "Guided", to:"/gd"},
                    { title: "Activity Unguided", to:"/ugd"},
                    { title: "Activity Tugas", to: "/tugas" },
                    { title: "Makanan List", to: "/makanan"},
                    { title: "Transaksi", to: "/transaksi"},
                    { title: "Register", to: "/register"},
                    { title: "Login", to: "/login"},
                    {title: "Profile", to: "/profile"},
                    {title: "Tournament", to: "/tournament"},
                ],
            };
        },
    };
</script>
<style scoped>
    .fullheight{
        min-height: 100vh !important;
    }
</style>  -->
<template>
  <div class="navbar">
    <nav class="navbar fixed-top navbar-dark navbar-expand-md justify-content-md-center justify-content-start">
      <div class="container-fluid">
        <img src="../assets/Sonic.jpg" alt="" width="28" height="28" />
        <a class="navbar-brand judul">Sonic Hunter E-sport</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
          <ul class="navbar-nav mx-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px; padding-right: 3.5rem" link>
            <li class="nav-item d-flex align-self-center">
              <router-link class="nav-link" :to="{ path: '/' }">Beranda</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ path: '/team' }">Team</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ path: '/teammember' }">Team Member</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ path: '/tournament' }">Tournament</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ path: '/transaksi' }">Transaksi Tiket</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" :to="{ path: '/aboutus' }">About Us</router-link>
            </li>
            <!-- <li class="nav-item">
              <router-link class="nav-link" :to="{ path: '/home' }">home</router-link>
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
export default {
  name: "DashboardIndex",
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
        if (localStorage.getItem("user") == "user") {
          if (this.$route.name == "profil") return "logout";
          else return "user";
        } else return "admin";
      }
    },
    logout() {
      var url = this.$api + "/logout";
      this.load = true;
      this.$http
        .get(url, {
          headers: {
            Authorization: "Bearer " + localStorage.getItem("token"),
          },
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
            name: "Login",
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
  background-color: #03045e;
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
