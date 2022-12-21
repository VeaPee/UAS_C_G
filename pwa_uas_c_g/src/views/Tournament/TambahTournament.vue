<template>
  
    <v-main class="tournament" style="margin-right:5cm; margin-top: 3cm; " >
      <h3 class="text-h3 font-weight-medium mb-5" style=" color:#000000; font-family: Arial, Helvetica, sans-serif; font: bold; margin: center;">Buat Tournament</h3>
  
      <v-card >
        <v-list-item>
          <v-list-item-avatar color="darkgrey">
            <img src="https://i.pinimg.com/564x/81/46/cb/8146cb90d84bb8c39bd80e0cd85d86e8.jpg" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline">Tournament</v-list-item-title>
            <v-list-item-subtitle>HardCore</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
  
          <v-spacer></v-spacer>
  
          <v-btn color="black" dark @click="dialog = true"> Tambah </v-btn>
  
        </v-card-title>
        <v-data-table :headers="headers" :items="Tournaments" :search="search">
  
            <template v-slot:[`item.actions`]="{item}">
                  <v-btn icon small class="mr-2" @click="editHandler(item)">
                    <v-icon color="green">mdi-pencil</v-icon>
                  </v-btn>
                  <v-btn icon small @click="deleteHandler(item.id)">
                       <v-icon color="red">mdi-delete</v-icon>
                  </v-btn>
              </template>
  
        </v-data-table>
      </v-card>
  
      <v-dialog v-model="dialog" persistent max-width="750px">
        <v-card color="white">
          <v-card-title>
            <span class="headline">{{formTitle}} tournament</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field v-model="form.nama_tournament" label="Nama Tournament" required></v-text-field>
              <date-picker v-model="form.tanggal_tournament" label="Tanggal Tournament" type="date"></date-picker>
              <v-text-field prefix="Rp " v-model="form.prizepool" label="Prizepool" required></v-text-field>
              <v-select v-model="form.totalTeam" 
              :items="['16', '32', '64']" label="Total Team" required></v-select>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="cancel"> Cancel </v-btn>
            <v-btn color="green darken-1" text @click="setForm"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
  
  
      <v-dialog v-model="dialogConfirm" persistent max-width="420px">
        <v-card color="white">
          <v-card-title>
            <span class="headline">Ingin Menghapus Tournament?</span>
          </v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="green" text @click="dialogConfirm = false">
              Cancel
            </v-btn>
            <v-btn color="red darken-1" text @click="deleteData"> Delete </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
  
         <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }} </v-snackbar>
  
    </v-main>
  </template>

<style scoped>

  .tournament {
    background: rgb(0, 0, 0);
    background: linear-gradient(
      to right,
      rgba(3, 12, 41, 0.75),
      rgba(5, 11, 31, 0.65)
    );

  }
  
</style>
  
  
  <script>
  import DatePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';

  export default {
    components: { DatePicker },
    name: "TournamentPage",
    data() {
      return {
        type: 'Tambah',
        load: false,
        snackbar: false,
        error_message: '',
        color: '',
        search: null,
        dialog: false,
        dialogConfirm: false,
        headers: [
          { text: "Nama Tournament", align: "start", sortable: true, value: "nama_tournament"},
          { text: "Tanggal Tournament", value: 'tanggal_tournament'},
          { text: "Prizepool", value: 'prizepool'},
          { text: "Total Team", value:'totalTeam'},
          { text: "Actions", value: 'actions'},
        ],
        tournament: new FormData,
        Tournaments: [],
        form:{
          nama_tournament: null,
          tanggal_tournament: null,
          prizepool: null,
          totalTeam: null,
        },
        deleteId: '',
        editId: ''
      };
    },
    methods: {
      setForm(){
        if(this.type !== 'Tambah'){
          this.update();
        }
        else{
          this.save();
        }
      },
      readData(){
        var url = this.$api + '/tournament';
        this.$http.get(url, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
          }
        }).then(response => {
          this.Tournaments = response.data.data;
        })
      },
      save(){
        this.tournament.append('nama_tournament',this.form.nama_tournament);
        this.tournament.append('tanggal_tournament',this.form.tanggal_tournament);
        this.tournament.append('prizepool',this.form.prizepool);
        this.tournament.append('totalTeam',this.form.totalTeam);
        var url= this.$api + '/tournament'
        this.load = true;
        this.$http.post(url, this.tournament, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token'),
          }
        }).then(response => {
          this.error_message = response.data.message;
          this.color = "green";
          this.snackbar = true;
          this.load = true;
          this.close();
          this.readData();
          this.resetForm();
        }).catch(error => {
          this.error_message = error.response.data.message;
          this.color = "red";
          this.snackbar = true;
          this.load = false;
        });
      },
      update(){
        let update = {
          nama_tournament : this.form.nama_tournament,
          tanggal_tournament : this.form.tanggal_tournament,
          prizepool : this.form.prizepool,
          totalTeam: this.form.totalTeam,
        };
        var url = this.$api + '/tournament/' + this.editId;
        this.load = true;
        this.$http.put(url, update, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
          }
        }).then(response => {
          this.error_message = response.data.message;
          this.color = 'green';
          this.snackbar = true;
          this.load = false;
          this.close();
          this.readData();
          this.resetForm();
          this.type = 'Tambah';
        }).catch(error => {
          this.error_message = error.response.data.message;
          this.color = 'red';
          this.snackbar = true;
          this.load = false;
        });
      },
      deleteData() {
        //mengahapus data
        var url = this.$api + '/tournament/' + this.deleteId;
        //data dihapus berdasarkan id
        this.$http.delete(url, {
            headers: {
              Authorization: 'Bearer ' + localStorage.getItem('token'),
            },
          })
          .then((response) => {
            this.error_message = response.data.message;
            this.color = "green";
            this.snackbar = true;
            this.load = false;
            this.close();
            this.readData(); //mengambil data
            this.resetForm();
            this.type = "Tambah";
          })
          .catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
          });
      },
      editHandler(item){
        this.type = 'Ubah';
        this.editId = item.id;
        this.form.nama_tournament = item.nama_tournament;
        this.form.tanggal_tournament = item.tanggal_tournament;
        this.form.prizepool = item.prizepool;
        this.form.totalTeam = item.totalTeam;
        this.dialog = true;
      },
      deleteHandler(id) {
        this.deleteId = id;
        this.dialogConfirm = true;
      },
      close() {
        this.dialog = false;
        this.type = "Tambah";
        this.dialogConfirm = false;
        this.readData();
      },
      cancel() {
        this.resetForm();
        this.readData();
        this.dialog = false;
        this.dialogConfirm = false;
        this.type = "Tambah";
      },
      resetForm() {
        this.form = {
          nama_tournament: null,
          tanggal_tournament: null,
          prizepool: null,
          totalTeam: null,
        };
      },
    },
    computed: {
      formTitle() {
        return this.type;
      },
    },
    mounted() {
      this.readData();
    },
  };
  </script>