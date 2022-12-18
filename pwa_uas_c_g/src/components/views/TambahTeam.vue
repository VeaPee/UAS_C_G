<template>
    <div id="background">
        <div class="card border-0 rounded shadow">
            <div class="card-body">
                <h4>Tambah Member</h4>
                <hr />
                <form @submit.prevent="store">
                    <div class="form-group mb-3">
                        <label class="form-label">Member Name</label>
                        <input
                            type="text"
                            class="form-control"
                            v-model="member.nama_member"
                            placeholder="Masukkan Nama Member"
                        />
                        <!-- validation -->
                        <div
                            v-if="validation.nama_member"
                            class="mt-2 alert alert-danger"
                        >
                            {{ validation.nama_member[0] }}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="content" class="form-label">ID Game</label>
                        <input
                            class="form-control"
                            v-model="member.id_game"
                            placeholder="Masukkan ID Game"
                        />
                        <!-- validation -->
                        <div
                            v-if="validation.id_game"
                            class="mt-2 alert alert-danger"
                        >
                            {{ validation.id_game[0] }}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="content" class="form-label">ID Team</label>
                        <input
                            class="form-control"
                            type="number"
                            v-model="member.id_team"
                            placeholder="Masukkan ID Team"
                        />
                        <!-- validation -->
                        <div
                            v-if="validation.id_team"
                            class="mt-2 alert alert-danger"
                        >
                            {{ validation.id_team[0] }}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        SIMPAN
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
export default {
    name: "TambahTeam",
    setup() {
        //state member
        const member = reactive({
            nama_member: "",
            id_game: "",
            id_team: "",
        });
        //state validation
        const validation = ref([]);
        //vue router
        const router = useRouter();
        //method store
        function store() {
            let nama_member = member.nama_member;
            let id_game = member.id_game;
            let id_team = member.id_team;
            axios
                .post("http://127.0.0.1:8000/api/", {
                    nama_member: nama_member,
                    id_game: id_game,
                    id_team: id_team,
                })
                .then(() => {
                    //redirect ke post index
                    router.push({
                        name: "/login",
                    });
                })
                .catch((error) => {
                    //assign state validation with error
                    validation.value = error.response.data;
                });
        }
        //return
        return {
            member,
            validation,
            router,
            store,
        };
    },
};
</script>
