<!-- <template>
    <div id="background">
      <v-container fill-height fluid>
        <v-card elevation="2" class="login">
          <h2 class="text-center">MASUK</h2>
          <p class="text-center mb-5">Selamat Datang di <b>Sonic Hunter</b>,<br>Team Esport Terbaik Serta Pengadaan Tournament Terbaik</p>

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
              <p class="mt-3 text-center">Belum punya akun? <router-link to="/register">Register</router-link></p>
        </v-card>
      </v-container>
    </div>
  </template> -->
  <template>
    <v-app id="background">
       <v-content>
          <v-container fluid fill-height>
             <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                   <v-card class="elevation-12">
                      <v-toolbar dark color="primary">
                         <v-toolbar-title>Login form</v-toolbar-title>
                      </v-toolbar>
                      <v-card-text>
                         <v-form>
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
                         </v-form>
                      </v-card-text>
                      <v-card-actions>
                         <v-spacer></v-spacer>
                         <v-btn color="primary" to="/">Login</v-btn>
                      </v-card-actions>
                   </v-card>
                </v-flex>
             </v-layout>
          </v-container>
       </v-content>
    </v-app>
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
      background: url(https://wallpapercave.com/wp/wp8371602.jpg);
      min-height: 100vh;
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
  
  