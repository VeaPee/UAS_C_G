  <template>
    <v-main class="team" >
      <h3 class="text-h3 font-weight-medium mb-5" style=" color:#3C2317">Buat Tim</h3>
  
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
  
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card color="brown lighten-5">
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
  
  
      <v-dialog v-model="dialogConfirm" persistent max-width="400px">
        <v-card color="brown lighten-5">
          <v-card-title>
            <span class="headline">WARNING !</span>
          </v-card-title>
          <v-card-text> Ingin Menghapus Team ? </v-card-text>
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
    name: "ViewTeam",
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
          { text: "Nama Tim", align: "start", sortable: true, value: "nama_tim"},
          { text: "Kota", value: 'kota'},
          { text: "Pelatih", value: 'pelatih'},
          { text: "Analis", value:'analis'},
          { text: "Actions", value: 'actions'},
        ],
        team: new FormData,
        Teams: [],
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
        if(this.inputType !== 'Tambah'){
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
        let newData = {
          nama_tim : this.form.nama_tim,
          kota : this.form.kota,
          pelatih : this.form.pelatih,
          analis: this.form.analis,
        };
        var url = this.$api + '/team/' + this.editId;
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
        var url = this.$api + '/team/' + this.deleteId;
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
          nama_tim: null,
          kota: null,
          pelatih: null,
          analis: null,
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