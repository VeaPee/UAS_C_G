  <template>
    <v-main class="team" style="margin-right:5cm; margin-top: 3cm; ">
      <h3 class="text-h3 font-weight-medium strokeme" style=" color:#FFFFFF; font-family: Arial, Helvetica, sans-serif; font: bold; margin: center;">Beli Tiket</h3>
  
      <v-card>
        <v-list-item>
          <v-list-item-avatar color="darkgrey">
            <img src="https://i.pinimg.com/564x/4f/cf/fb/4fcffb860a85997f34a0ddfcfe28e6ae.jpg" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline">Transaksi</v-list-item-title>
            <v-list-item-subtitle>Pembayaran</v-list-item-subtitle>
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
        <v-data-table :headers="headers" :items="tickets" :search="search">
  
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
              <v-select v-model="form.namaTournament" 
              :items="['Piala Presiden']" label="Nama Tournament" required></v-select>
              <v-select 
                  v-model="form.jenisTicket" 
                  @change="harga" :items="['VVIP', 'VIP', 'Economy']" 
                  label="Jenis Ticket" 
                  required>
              </v-select>
              <v-text-field prefix="Rp " readonly v-model="form.hargaTicket" label="Harga Ticket" required></v-text-field>
              <v-text-field v-model="form.tempatDuduk" label="Tempat Duduk" required></v-text-field>
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
            <span class="headline">Ingin Menghapus Ticket ?</span>
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
    name: "ViewTicket",
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
          { text: "Nama Tournament", value: 'namaTournament', align: "start", sortable: true},
          { text: "Jenis Ticket", value: "jenisTicket"},
          
          { text: "Harga Ticket", value: 'hargaTicket'},
          { text: "Tempat Duduk", value: 'tempatDuduk'},
          { text: "Actions", value: 'actions'},
        ],
        ticket: new FormData,
        tickets: [],
        form:{
          namaTournament: "Piala Presiden",
          jenisTicket: null,
          hargaTicket: null,
          tempatDuduk: null,
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
        var url = this.$api + '/transaksi';
        this.$http.get(url, {
          headers: {
            'Authorization' : 'Bearer ' + localStorage.getItem('token')
          }
        }).then(response => {
          this.tickets = response.data.data;
        })
      },
      save(){
        this.ticket.append('namaTournament',this.form.namaTournament);
        this.ticket.append('jenisTicket',this.form.jenisTicket);
        this.ticket.append('hargaTicket',this.form.hargaTicket);
        this.ticket.append('tempatDuduk',this.form.tempatDuduk);
        var url= this.$api + '/transaksi'
        this.load = true;
        this.$http.post(url, this.ticket, {
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
          namaTournament : this.form.namaTournament,
          jenisTicket : this.form.jenisTicket,
          hargaTicket : this.form.hargaTicket,
          tempatDuduk : this.form.tempatDuduk,
        };
        var url = this.$api + '/transaksi/' + this.editId;
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

        var url = this.$api + '/transaksi/' + this.deleteId;
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
        this.form.namaTournament = item.namaTournament;
        this.form.jenisTicket = item.jenisTicket;
        this.form.hargaTicket = item.hargaTicket;
        this.form.tempatDuduk = item.tempatDuduk;
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