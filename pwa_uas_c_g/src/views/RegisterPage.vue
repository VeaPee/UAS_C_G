<template>
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
  