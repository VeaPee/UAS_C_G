<template>
    <v-main class="tournament" >
      <h3 class="text-h3 font-weight-medium mb-5" style=" color:#3C2317">Buat Tournament</h3>
  
      <v-card>
        <v-card-title>
          <v-text-field
            v-model="search"
            append-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
          ></v-text-field>
  
          <v-spacer></v-spacer>
  
          <v-btn color="brown lighten-1" dark @click="dialog = true"> Tambah </v-btn>
  
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
  
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card color="brown lighten-5">
          <v-card-title>
            <span class="headline">{{formTitle}} tournament</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field v-model="form.nama_tournament" label="Nama Tournament" required></v-text-field>
              <v-text-field v-model="form.tanggal_tournament" label="Tanggal Tournament" required></v-text-field>
              <v-text-field v-model="form.prizepool" label="Prizepool" required></v-text-field>
              <v-text-field v-model="form.totalTeam" label="Total Team" required></v-text-field>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red darken-1" text @click="cancel"> Cancel </v-btn>
            <v-btn color="green darken-1" text @click="setForm"> Save </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
  
  
      <v-dialog v-model="dialogConfirm" persistent max-width="400px">
        <v-card color="brown lighten-5">
          <v-card-title>
            <span class="headline">WARNING !</span>
          </v-card-title>
          <v-card-text> Ingin Menghapus Tournament? </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="brown darken-1" text @click="dialogConfirm = false">
              Cancel
            </v-btn>
            <v-btn color="red darken-1" text @click="deleteData"> Delete </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
  
         <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }} </v-snackbar>
  
    </v-main>
  </template>
  
  
  <script>
  export default {
    name: "TournamentPage",
    data() {
      return {
        inputType: 'Tambah',
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
        if(this.inputType !== 'Tambah'){
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
        let newData = {
          nama_tournament : this.form.nama_tournament,
          tanggal_tournament : this.form.tanggal_tournament,
          prizepool : this.form.prizepool,
          totalTeam: this.form.totalTeam,
        };
        var url = this.$api + '/tournament/' + this.editId;
        this.load = true;
        this.$http.put(url, newData, {
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
          this.inputType = 'Tambah';
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
            this.inputType = "Tambah";
          })
          .catch((error) => {
            this.error_message = error.response.data.message;
            this.color = "red";
            this.snackbar = true;
            this.load = false;
          });
      },
      editHandler(item){
        this.inputType = 'Ubah';
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
        this.inputType = "Tambah";
        this.dialogConfirm = false;
        this.readData();
      },
      cancel() {
        this.resetForm();
        this.readData();
        this.dialog = false;
        this.dialogConfirm = false;
        this.inputType = "Tambah";
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
        return this.inputType;
      },
    },
    mounted() {
      this.readData();
    },
  };
  </script>