<template>
  <v-main class="teammember" style="margin-right:5cm; margin-top: 3cm;" >
    <h3 class="text-h3 font-weight-medium strokeme" style=" color:#FFFFFF; font-family: Arial, Helvetica, sans-serif; font: bold; margin: center;">Team Member</h3>

    <v-card style="color: #202020;">
      <v-list-item>
          <v-list-item-avatar color="darkgrey">
            <img src="https://i.pinimg.com/564x/4a/9f/d2/4a9fd2a17a67a4f25248839e078273a4.jpg" />
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="headline">My Team</v-list-item-title>
            <v-list-item-subtitle>Esport</v-list-item-subtitle>
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

        <v-btn v-if="TeamMember.length != 4" color="black" dark @click="dialog = true"> Tambah </v-btn>

      </v-card-title>
      <v-data-table :headers="headers" :items="TeamMember" :search="search">

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
          <span class="headline">{{formTitle}} Team Member</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-text-field v-model="form.member_name" label="Member Name" required></v-text-field>
            <v-text-field type="number" v-model="form.id_game" label="ID Game" required></v-text-field>
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
          <span class="headline">Ingin Menghapus Member?</span>
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
  .teammember{
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
  name: "TambahMember",
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
        { text: "Member Name", value:'member_name'},
        { text: "ID Game", value: 'id_game'},
        { text: "Actions", value: 'actions'},
      ],
      team_member: new FormData,
      TeamMember: [],
      form:{
        member_name: null,
        id_game: null,
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
      var url = this.$api + '/teammember';
      this.$http.get(url, {
        headers: {
          'Authorization' : 'Bearer ' + localStorage.getItem('token')
        }
      }).then(response => {
        this.TeamMember = response.data.data;
      })
    },
    save(){
      this.team_member.append('member_name',this.form.member_name);
      this.team_member.append('id_game',this.form.id_game);
      var url= this.$api + '/teammember'
      this.load = true;
      this.$http.post(url, this.team_member, {
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
        member_name : this.form.member_name,
        id_game: this.form.id_game,
      };
      var url = this.$api + '/teammember/' + this.editId;
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
      var url = this.$api + '/teammember/' + this.deleteId;

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
      this.form.member_name = item.member_name;
      this.form.id_game = item.id_game;
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
        member_name: null,
        id_game: null,
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