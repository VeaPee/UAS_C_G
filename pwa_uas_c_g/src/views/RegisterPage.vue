<!-- <template>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Register
          </div>
          <div class="card-body">
            <form @submit.prevent="store">
              <div class="form-group">
                <label for="name">Name</label>
                <input v-model="user.name" type="text" class="form-control" placeholder="Name..">
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input v-model="user.email" type="email" class="form-control" placeholder="Email..">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input v-model="user.password" type="password" class="form-control" placeholder="Password..">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template>
  <script>
  import { reactive, ref } from "vue";
  import { useRouter } from "vue-router";
  import axios from "axios";
  export default {
      setup() {
          //state pegawai
          const user = reactive({
              name : "",
              email : "",
              password : "",
  
          });
          //state validation
          const validation = ref([]);
          //vue router
          const router = useRouter();
  
  
          //method store
          function store() {
              let name = user.name;
              let email = user.email;
              let password = user.password;
  
              axios
                  .post("http://localhost:8000/api/register", {
                      name : name,
                      email : email,
                      password : password,
  
                  })
                  .then(() => {
                      router.push({ name: "login" });
                  })
                  .catch((error) => {
                      //assign state validation with error
                      validation.value = error.response.data;
                  });
          }
          //return
          return {user, validation, router, store };
      },
  };
  </script>
  <style></style>
   -->

   <template>
    <div id="background">
      <v-container fill-height fluid>
        <v-card elevation="2" class="mx-auto pa-4 register">
          <h2 class="text-center " style="font-weight: 900;">DAFTAR</h2>
          <p class="text-center mb-5">Selamat Datang di <b>Sonic Hunter</b>,<br>Team Esport Terbaik Serta Pengadaan Tournament Terbaik</p>

          <v-text-field 
            label="Name" 
            v-model="user.name" 
            placeholder="Masukkan Nama" 
            :error-messages="errors.name" 
            outlined>
          </v-text-field>

          <v-text-field 
            label="Email" 
            v-model="user.email" 
            placeholder="Masukkan Email" 
            :error-messages="errors.email" 
            outlined>
          </v-text-field>

          <v-text-field 
            label="Password" 
            type="password" 
            v-model="user.password" 
            placeholder="Masukkan Password" 
            :error-messages="errors.password" 
            outlined>
          </v-text-field>
          
          <v-file-input 
            v-model="user.picture" 
            :error-messages="errors.picture" 
            placeholder="Upload Foto" 
            label="Upload Foto" 
            outlined show-size dense>
          </v-file-input>
            <v-btn block :loading="isLoading" @click="login()" outlined color="success">Daftar</v-btn>
              <p class="mt-3 text-center">Sudah Punya Akun? <router-link to="/login">Masuk</router-link></p>
        </v-card>
      </v-container>
    </div>
  </template>
  <script>
  import axios from 'axios'
  /* eslint-disable */
  export default {
    name: 'LoginPage',
  
    data: () => ({
      user: {
        email: '',
        password: ''
      },
      errors: {},
      isLoading: false
    }),
  
    methods: {
      login() {
        this.isLoading = true
        axios.post('http://127.0.0.1:8000/api/' + "register", this.user, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
          .then(res => {
            this.isLoading = false
            this.$router.push('/login')
          })
          .catch(err => {
            this.isLoading = false;
            console.log(err);
            this.errors = err.response.data.errors || {}
          })
      }
    }
  }
  </script>
  <style>
   #background {
      background: url(https://i.pinimg.com/564x/ce/e2/7f/cee27f072a432b548f1e10a3eeb3a340.jpg);
      min-height: 92vh;
      display: flex;
    }
    .register{
      /* margin-top: 100px; */
      margin: auto;
      width: 550px;
      /* max-width: 550px; */
      /* text-align: center !important; */
      padding: 20px;
      border: 8px solid rgb(5,111,111);
      border-radius: 3px;
    }
  
   
  
    @media screen and (max-width: 1316px){
      .register{
        border: 5px solid rgb(5,111,111);
      }
    }
  </style>
  
  