<template>
  <div class="container">
      <div
    class="d-flex justify-content-center flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"
  >
    <h1 class="h2">Buatlah Tournament Anda Sendiri</h1>
  </div>
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <router-link
              :to="{ name: 'TambahTournament' }"
              class="btn btn-md btn-outline-success"
              >Buat Tournament</router-link
            >
            <table class="table table-striped table-bordered mt-4">
              <thead class="thead-dark">
                <tr>
                  <th scope="row">Nama Tournament</th>
                  <th scope="row">Tanggal</th>
                  <th scope="row">Prizepool</th>
                  <th scope="row">Total Team</th>
                </tr>
              </thead>
              
              <tbody>
                <tr v-for="(tournament, id) in tournaments" :key="id">
                  <td>{{ tournament.nama_tournament }}</td>
                  <td>{{ tournament.tanggal_tournament }}</td>
                  <td>{{ tournament.prizepool }}</td>
                  <td>{{ tournament.totalTeam }}</td>

                  <td class="text-center">
                    <router-link :to="{ name:'team.edit', params: { id: teammember.id } }" class="btn btn-sm btn-primary mr-1">EDIT</router-link>
                    <button @click.prevent="teamDelete(teammember.id)" class="btn btn-sm btn-danger ml-1">DELETE</button>
                  </td>

                </tr>
                
              </tbody>

            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import { onMounted, ref } from "vue";
import { useRouter } from "vue-router";

export default {

  setup() {
    //reactive state
    let teams = ref([]);
    //mounted
    onMounted(() => {

      //get API from Laravel Backend
        axios
          .get('http://127.0.0.1:8000/api/tournament')
          .then((response) => {
            //assign state pegawai with response data
            teams.value = response.data.data;
          })
          .catch((error) => {
            console.log(error.response.data);
          });
    });

    const router = useRouter();
    function teamDelete(id) {  
        //delete data pegawais by ID
        axios.delete(`http://127.0.0.1:8000/api/tournament/${id}`)
        .then(() => {
                
          //splice pegawais
          teams.value.splice(teams.value.indexOf(id), 1);

          router.push({
            name: 'tournament'
          })

        }).catch(error => {
            console.log(error.response.data)
        })
    }

    //return
    return {
      teams,
      teamDelete,
      router
    };
  },
};
</script>

<style></style>
