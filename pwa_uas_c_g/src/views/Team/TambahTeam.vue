  <template>
    <v-main class="team" style="margin-right:5cm; margin-top: 3cm;">
      <h3 class="text-h3 font-weight-medium strokeme" style=" color:#FFFFFF; font-family: Arial, Helvetica, sans-serif; font: bold; margin: center;">Buat Team</h3>
  
      <v-card>
        <v-list-item>
          <v-list-item-avatar color="darkgrey">
            <img src="https://i.pinimg.com/564x/4a/9f/d2/4a9fd2a17a67a4f25248839e078273a4.jpg" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline">Tambah Team</v-list-item-title>
            <v-list-item-subtitle>Membuat Team</v-list-item-subtitle>
          </v-list-item-content>
        </v-list-item>
        <v-card-title>
  
          <v-spacer></v-spacer>
  
          <v-btn v-if="Teams.length == 0" color="black" dark @click="dialog = true"> Tambah </v-btn>
  
        </v-card-title>
        <v-data-table :headers="headers" :items="Teams" :search="search">
  
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
            <span class="headline">{{formTitle}} team</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-text-field v-model="form.nama_tim" label="Nama Tim" required></v-text-field>
              <v-text-field v-model="form.kota" label="Asal Kota" required></v-text-field>
              <v-text-field v-model="form.pelatih" label="Nama Pelatih" required></v-text-field>
              <v-text-field v-model="form.analis" label="Analis" required></v-text-field>
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
            <span class="headline">Ingin Menghapus Team ?</span>
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
  
      <v-card v-if="Teams.length != 0">
        <v-card-title>
          <v-btn color="black" dark @click="rute"> Tambah Member</v-btn>
        </v-card-title>
      </v-card>

         <v-snackbar v-model="snackbar" :color="color" timeout="2000" bottom>{{ error_message }} </v-snackbar>
  
    </v-main>
  </template>
  
  <style>
  .team{
    background: rgb(0, 0, 0);
    background: linear-gradient(
      to right,
      rgba(3, 12, 41, 0.75),
      rgba(5, 11, 31, 0.65)
    );
  }

  .strokeme {
  color: white;
  text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;
  }
</style>
  
  <script>
  export default {
    name: "ViewTeam",
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
          { text: "Nama Tim", align: "start", sortable: true, value: "nama_tim"},
          { text: "Kota", value: 'kota'},
          { text: "Pelatih", value: 'pelatih'},
          { text: "Analis", value:'analis'},
          { text: "Actions", value: 'actions'},
        ],
        team: new FormData,
        Teams: [],
        TeamMember: [],
        form:{
          nama_tim: null,
          kota: null,
          pelatih: null,
          analis: null,
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
        var url = this.$api + '/team';
        this.$http.get(url, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
          }
        }).then(response => {
          this.Teams = response.data.data;
        })
      },
      save(){
        this.team.append('nama_tim',this.form.nama_tim);
        this.team.append('kota',this.form.kota);
        this.team.append('pelatih',this.form.pelatih);
        this.team.append('analis',this.form.analis);
        var url= this.$api + '/team'
        this.load = true;
        this.$http.post(url, this.team, {
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
          nama_tim : this.form.nama_tim,
          kota : this.form.kota,
          pelatih : this.form.pelatih,
          analis: this.form.analis,
        };
        var url = this.$api + '/team/' + this.editId;
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
        var url = this.$api + '/team/' + this.deleteId;

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
            this.readData();
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
        this.form.nama_tim = item.nama_tim;
        this.form.kota = item.kota;
        this.form.pelatih = item.pelatih;
        this.form.analis = item.analis;
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
          nama_tim: null,
          kota: null,
          pelatih: null,
          analis: null,
        };
      },
      rute(){
        this.$router.push('/tambahteammember')
      }
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