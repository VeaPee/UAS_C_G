<template>
    <v-main class="profil" style="height: 100%">
      <div class="d-flex justify-content-center mt-16">
        <v-card persistent min-width="400px" elevation="8">
          <v-card-title id="backgroundhead">
            <span class="headline" style="color: white ;"><b>Profile</b></span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field v-model="form.name" readonly label="Name"></v-text-field>
              <v-text-field v-model="form.email" readonly label="Email"></v-text-field>
              <v-text-field v-model="form.nomor_hp" readonly label="Nomor HP"></v-text-field>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="open">Update Profile</v-btn>
          </v-card-actions>
        </v-card>
      </div>
      <v-dialog v-model="dialog" persistent width="400px">
        <v-card>
          <v-card-title>
            <span class="headLine">Update Profile</span>
          </v-card-title>
          <v-card-text>
            <v-container>
                <v-text-field v-model="form_new.name" label="Name"></v-text-field>
                <v-text-field v-model="form_new.email" label="Email"></v-text-field>
                <v-text-field v-model="form_new.nomor_hp" label="Nomor HP"></v-text-field>
                <v-text-field v-model="form_new.password" label="Password"></v-text-field>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
            <v-btn color="blue darken-1" text @click="update"> Ganti </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom> {{ error_message }} </v-snackbar>
    </v-main>
  </template>
  
  <style scoped>
  #backgroundhead {
    background-color: #d0d0d0;
    background-image: url('https://asset-a.grid.id/crop/0x0:0x0/700x0/photo/2022/10/26/dota2_ti11_singapore_suntec_main-20221026050323.jpg');
  }
  </style>
  
  <script>
  export default {
    name: "ProfilProcess",
    data() {
      return {
        load: false,
        snackbar: false,
        error_message: "",
        color: "",
        dialog: false,
        form: {
            name: '',
            email: '',
            nomor_hp: '',
            password: '',
        },
        form_new: {
            name: '',
            email: '',
            nomor_hp: '',
            password: '',
        },
      };
    },
    methods: {
      readData() {
        var url = this.$api + "/profile/" + localStorage.getItem("id");
        this.$http
          .get(url, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          })
          .then((response) => {
            this.form.name = response.data.data.name;
            this.form.email = response.data.data.email;
            this.form.nomor_hp = response.data.data.nomor_hp;
            this.form.password = response.data.data.password;
          });
      },
      cancel() {
        this.readData();
        this.dialog = false;
      },
      resetForm() {
        this.form = {
          name: '',
          email: '',
          nomor_hp: ''
        },
        this.form_new = {
          name: '',
          email: '',
          nomor_hp: '',
          password: '',
        };
      },
      open() {
        this.dialog = true;
      },
      update() {
        let newData = {
            name: this.form_new.name,
            email:this.form_new.email,
            nomor_hp:this.form_new.nomor_hp,
            password:this.form_new.password,
        };
        var url = this.$api + "/profile/" + localStorage.getItem("id");
        this.load = true;
        this.$http
          .put(url, newData, {
            headers: {
              Authorization: "Bearer " + localStorage.getItem("token"),
            },
          })
          .then((response) => {
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            this.dialog = false;
            this.resetForm();
          })
          .catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
          });
      },
    },
    mounted() {
      this.readData();
    },
  };
  </script>