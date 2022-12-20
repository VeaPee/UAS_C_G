<template>
    <v-main>
      <div class="d-flex justify-content-center mt-16 mb-8">
        <v-card persistent min-width="500px" elevation="8">
          <v-card-title class="backgroundhead">
            <span class="headline"><b>Tambah Team</b></span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field 
                v-model="form.nama_tim" 
                label="Nama Tim" 
                required>
            </v-text-field>
            <v-text-field 
                v-model="form.Kota" 
                label="Asal Kota" 
                required>
            </v-text-field>
            <v-text-field 
                v-model="form.pelatih" 
                label="Nama Pelatih" 
                required>
            </v-text-field>

            <v-text-field 
                v-model="form.analis" 
                label="Analis" 
                required>
            </v-text-field>
            
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <router-link
                :to="{ name: 'viewteam' }"
                class="btn btn-md btn-outline-success"
                >Cancel</router-link
              >
            <v-btn outlined color="error" @click="save"> Process </v-btn>
          </v-card-actions>
        </v-card>
      </div>
      <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom> {{ error_message }} </v-snackbar>
    </v-main>
  </template>
  
  <style scoped>
  .backgroundhead {
    background-color: #d0d0d0;
  }
  </style>
  
  <script>

import axios from 'axios'
  export default {
    name: "TransaksiTeam",
    data() {
      return {
        load: false,
        snackbar: false,
        error_message: "",
        color: "",
        team: new FormData(),
        teams: [],
        form: {
          nama_tim: null,
          kota: null,
          pelatih: null,
          analis: null,
          
        },
      };
    },
    methods: {
      save() {
        if (localStorage.getItem("token") == null) {
          this.error_message = "Anda Harus Login Terlebih Dahulu Sebelum Bisa Membuat Team!";
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        } else {
          
          axios.post('http://127.0.0.1:8000/api/team/', this.user,{  
                nama_tim: this.form.nama_tim,
                kota: this.form.kota,
                pelatih: this.form.pelatih,
                analis: this.form.analis,
              },
              {
                headers: {
                  Authorization: "Bearer " + localStorage.getItem("token"),
                },
              })
            .then((response) => {
              this.error_message = response.data.message;
              this.color = "green";
              this.snackbar = true;
              this.load = true;
              this.resetForm();
            })
            .catch((error) => {
              this.error_message = error.response.data.message;
              this.color = "red";
              this.snackbar = true;
              this.load = false;
            });
          }
          
        }
      },
      resetForm() {
        this.form = {
          nama_tim: null,
          kota: null,
          pelatih: null,
          analis: null,
        };
      },
    // mounted() {
    //   this.read_promo_id();
    // },
    };
  </script>