<template>
    <v-main>
      <div class="d-flex justify-content-center mt-16 mb-8">
        <v-card persistent min-width="500px" elevation="8">
          <v-card-title class="backgroundhead">
            <span class="headline"><b>Tambah Member</b></span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field 
                v-model="form.member_name" 
                label="Nama" 
                required>
            </v-text-field>
            <v-text-field 
                v-model="form.id_game" 
                label="UID" 
                required>
            </v-text-field>
            
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <router-link
                :to="{ name: 'TeamMember' }"
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
  export default {
    name: "TransaksiTiket",
    data() {
      return {
        load: false,
        snackbar: false,
        error_message: "",
        color: "",
        order: new FormData(),
        orders: [],
        promo: [],
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
        if (localStorage.getItem("user") == null) {
          this.error_message = "Anda Harus Login Terlebih Dahulu Sebelum Bisa Menambah Member!";
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        } else {
          this.$http
            .post(
              this.$api + "/team",
              {
                nama_tim: this.form.nama_tim,
                kota: this.form.kota,
                pelatih: this.form.pelatih,
                analis: this.form.analis,
              },
              {
                headers: {
                  Authorization: "Bearer " + localStorage.getItem("token"),
                },
              }
            )
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