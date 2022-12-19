<template>
    <v-main>
      <div class="d-flex justify-content-center mt-16 mb-8">
        <v-card persistent min-width="500px" elevation="8">
          <v-card-title class="backgroundhead">
            <span class="headline"><b>Transaksi Tiket</b></span>
          </v-card-title>
          <v-card-text>
            <v-container>
            <v-select 
                v-model="form.jenisTicket" 
                @change="harga" :items="['VVIP', 'VIP', 'Economy']" 
                label="Jenis Paket" 
                required>
            </v-select>
            <v-text-field 
                v-model="form.hargaTicket" 
                label="Harga Paket" 
                readonly>
            </v-text-field>
            <v-text-field
                v-model="form.tempatDuduk" 
                label="Tempat Duduk" 
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
        form: {
          tempatDuduk: null,
          jenisTicket: null,
          hargaTicket: null
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
          this.load = true;

          this.$http
            .post(
              this.$api + "/transaksi",
              {
                jenisTicket: this.form.jenisTicket,
                hargaTicket: this.form.hargaTicket,
                tempatDuduk: this.form.tempatDuduk,
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
          jenisTicket: null,
          hargaTicket: null,
          tempatDuduk: null,
        };
      },
      harga() {
        if (this.form.jenisTicket == "VVIP") {
          this.form.hargaTicket = 3000000;
        } else if (this.form.jenisTicket == "VIP") {
          this.form.hargaTicket = 2000000;
        } else if (this.form.jenisTicket == "Economy") {
          this.form.hargaTicket = 1000000;
        }
      }
    },
  };
  </script>