
'nama_tim',
'kota',
'pelatih',
'analis',

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
            <v-btn color="primary" @click="resetForm"> Cancel </v-btn>
            <v-btn color="error" @click="save"> Process </v-btn>
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
          this.error_message = "Anda Harus Login Terlebih Dahulu Sebelum Memesan!";
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        } else {
        //   this.load = true;
        //   var select = null;
        //   if (this.form.promo != null) {
        //     select = this.form.promo;
        //     for (let i = 0; i < this.form_promo.nama_promo.length; i++) {
        //       if (select.includes(this.form_promo.nama_promo[i])) {
        //         id_promo = this.form_promo.id[i];
        //         break;
        //       }
        //     }
          }
          this.$http
            .post(
              this.$api + "/teammember",
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