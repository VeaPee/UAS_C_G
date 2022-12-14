hargaTicket',
        'tempatDuduk',
        'jenisTicket',
        'statusPembayaran'

<template>
    <v-main>
      <div class="d-flex justify-content-center mt-16 mb-8">
        <v-card persistent min-width="500px" elevation="8">
          <v-card-title class="backgroundhead">
            <span class="headline"><b>Transaksi Tiket</b></span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field 
                v-model="form.nama" 
                label="Tempat Duduk" 
                required>
            </v-text-field>
            <v-text-field 
                v-model="form.email" 
                label="Email" 
                required>
            </v-text-field>
            <v-text-field 
                v-model="form.telepon" 
                label="Telepon" 
                required>
            </v-text-field>
            <v-select 
                v-model="form.jenis_paket" 
                @change="harga" :items="['VVIP', 'VIP', 'Economy']" 
                label="Jenis Paket" 
                required>
            </v-select>
            <v-text-field 
                v-model="form.harga_paket" 
                label="Harga Paket" 
                readonly>
            </v-text-field>
            <v-select 
                v-model="form.promo" :items="promo" 
                label="Promo" 
                required>
            </v-select>
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
    name: "List",
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
          nama: null,
          email: null,
          telepon: null,
          jenis_paket: null,
          harga_paket: null,
          promo: null,
        },
        form_promo: {
          id: null,
          nama_promo: null,
          diskon: null,
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
          var id_promo = null;
          var select = null;
          if (this.form.promo != null) {
            select = this.form.promo;
            for (let i = 0; i < this.form_promo.nama_promo.length; i++) {
              if (select.includes(this.form_promo.nama_promo[i])) {
                id_promo = this.form_promo.id[i];
                break;
              }
            }
          }
          this.$http
            .post(
              this.$api + "/order",
              {
                nama: this.form.nama,
                email: this.form.email,
                telepon: this.form.telepon,
                jenis_paket: this.form.jenis_paket,
                harga_paket: this.form.harga_paket,
                promo_id: id_promo,
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
          nama: null,
          email: null,
          password: null,
          telepon: null,
          jenis_paket: null,
          harga_paket: null,
          promo: null,
        };
      },
      harga() {
        if (this.form.jenis_paket == "VVIP") {
          this.form.harga_paket = 3000000;
        } else if (this.form.jenis_paket == "VIP") {
          this.form.harga_paket = 2000000;
        } else if (this.form.jenis_paket == "Economy") {
          this.form.harga_paket = 1000000;
        }
      },
      read_promo_id() {
        var url = this.$api + "/promo";
        this.$http
          .get(url, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          })
          .then((response) => {
            let temp = response.data.data;
            this.form_promo.id = temp.map((v) => v.id);
            this.form_promo.nama_promo = temp.map((v) => v.nama_promo);
            this.form_promo.diskon = temp.map((v) => v.diskon);
            for (let i = 0; i < this.form_promo.nama_promo.length; i++) {
              this.promo.push(this.form_promo.nama_promo[i] + ": diskon " + this.form_promo.diskon[i]);
            }
          });
      },
    },
    mounted() {
      this.read_promo_id();
    },
  };
  </script>