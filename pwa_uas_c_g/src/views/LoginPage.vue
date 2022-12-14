<!-- <template>
    <div class="row justify-content-md-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <form>
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" placeholder="Email..">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" placeholder="Password..">
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </template> -->
  <template>
    <div id="background">
      <v-container fill-height fluid>
        <v-card elevation="2" class="login">
          <h2 class="text-center " style="font-weight: 900;">MASUK</h2>
          <p class="text-center mb-5">Selamat Datang di <b>Armedia</b>,<br>Toko buku termurah dan terlengkap di Yogyakarta<br>Silakan Masuk untuk melanjutkan...</p>

          <v-text-field 
            label="Email" 
            v-model="user.email" 
            placeholder="Masukkan Email" 
            outlined 
            :error-messages="errors.username">
          </v-text-field>

          <v-text-field 
            type="password" 
            label="Password" 
            v-model="user.password" 
            placeholder="Masukkan Password" 
            outlined 
            :error-messages="errors.password">
          </v-text-field>

            <v-btn block class="m-0" outlined color="success" :loading="isLoading" @click="login()">Masuk</v-btn>
              <p class="mt-3 text-center">Belum punya akun? <router-link to="/register">Daftar</router-link></p>
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
        axios.post('http://127.0.0.1:8000/api/' + "login", JSON.stringify(this.user), {
          headers: {
            'Content-Type': 'application/json'
          }
        })
          .then(res => {
            this.isLoading = false
            localStorage.setItem('token', res.data.token);
            this.$router.push('/')
          })
          .catch(err => {
            this.isLoading = false;
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

    .login{
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
      .login{
        border: 5px solid rgb(5,111,111);
      }
    }
  </style>
  
  