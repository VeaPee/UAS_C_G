<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar color="grey"></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">Makanan List</v-list-item-title>
                    <v-list-item-subtitle>by 200710662</v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>
            <v-card-title>
                <v-text-field
                  v-model="search"
                  append-icon="mdi-magnify"
                  label="Search"
                  outlined
                  hide 
                  details 
                  style="margin-top: 30px">
                </v-text-field>
                <v-spacer></v-spacer>
                <v-btn color="orange" dark @click="dialog = true"> Tambah </v-btn>
            </v-card-title>
        </v-card>
        <v-card>
            <v-data-table :headers="headers" :items="todos" :search="search">
                <template v-slot:[`item.calories`]="{ item }">
                    <span v-if="(item.calories >= 400)">
                        <v-btn rounded color="red"> {{item.calories}} </v-btn>
                    </span>
                    <span v-else-if="(item.calories >= 300) && (item.calories < 400)">
                        <v-btn rounded color="yellow"> {{item.calories}}</v-btn>
                    </span>
                    <span v-else>
                        <v-btn rounded color="green"> {{item.calories}} </v-btn>
                    </span>
                </template>
                
                <template v-slot:[`item.actions`]="{ item }">
                    <span v-if="item.status == 'Ready'">
                        <v-btn style="color: red;" rectangle disabled @click="editItem(item)"> <v-icon>mdi-pencil</v-icon> </v-btn>
                        <v-btn style="color: green;" rectangle  @click="deleteItem(item)"> <v-icon>mdi-delete</v-icon> </v-btn>
                    </span>
                    <span v-else>
                        <v-btn style="color: red;"  rectangle @click="editItem(item)"> <v-icon>mdi-pencil</v-icon> </v-btn>
                        <v-btn style="color: green;" rectangle  disabled @click="deleteItem(item)"> <v-icon>mdi-delete</v-icon> </v-btn>
                    </span>  
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card v-model="valid">
            <v-card-title>
                <span class="headline"> Makanan List </span>
            </v-card-title>
            <v-card-text>
                <v-container>
                    <v-text-field
                      v-model="listMakanan.name"
                      label="Name"
                      required >
                    </v-text-field>
                   
                    <v-text-field
                      v-model="listMakanan.calories"
                      label="Calories"
                      required >
                    </v-text-field>

                    <v-textarea
                      v-model="listMakanan.note"
                      label="Note"
                      required> 
                    </v-textarea>
                    <v-select
                      v-model="listMakanan.status"
                      :items="[`On Process`, `Ready`, `Delivery`]"
                      label="Status"
                      required> 
                    </v-select>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="cancel"> Cancel </v-btn>
                <v-btn color="blue darken-1" text @click="save"> Save </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
        <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="cancelDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="hapusItemKonfir">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
    </v-main>
</template>

<script>
export default {
    name: "ListItem",
    data() {
        return{
            search: null,
            dialog: false,
            headers: [
                {
                    text: "Name",
                    align: "start",
                    sortable: true,
                    value: "name",
                },
                { text: "Calories", value: "calories" },
                { text: "Note", value: "note" },
                { text: "Status", value: "status" },
                { text: "Actions", value: "actions" },
            ],
            editedIndex: -1,
            todos: [
                {
                    name: "Fried Rice",
                    calories: "120",
                    note: "Tidak Pake Cabe",
                    status: "On Process",
                },
                {
                    name: "Dessert",
                    calories: "300",
                    note: "Tambah Alat Makan",
                    status: "Ready",
                },
                {
                    name: "Ice Cream",
                    calories: "450",
                    note: "Rasa coklat dan stroberi",
                    status: "Delivery",
                },
            ],
            listMakanan: {
                name: null,
                calories: null,
                note: null,
                status: null,
            },
            defaultItem: {
                name: null,
                calories: null,
                note: null,
                status: null,
            },
        };
    },
    
    methods: {
        save() {
            if (this.editedIndex > -1) {
                Object.assign(this.todos[this.editedIndex], this.listMakanan)
            } else {
                this.todos.push(this.listMakanan)
            }
            this.resetForm();
            this.dialog = false;
        },
        cancel() {
            this.dialog = false
            this.$nextTick(() => {
                this.listMakanan = Object.assign({}, this.defaultItem)
                this.editedIndex = -1
            })
            this.resetForm();
        },
        cancelDelete () {
            this.dialogDelete = false
            this.$nextTick(() => {
            this.listMakanan = Object.assign({}, this.defaultItem)
            this.editedIndex = -1
            })
        },
        editItem (item) {
            this.editedIndex = this.todos.indexOf(item)
            this.listMakanan = Object.assign({}, item)
            this.dialog = true
        },
        deleteItem (item) {
            this.editedIndex = this.todos.indexOf(item)
            this.listMakanan = Object.assign({}, item)
            this.dialogDelete = true
        },
        hapusItemKonfir () {
            this.todos.splice(this.editedIndex, 1)
            this.cancelDelete()
        },
        resetForm() {
            this.listMakanan = {
                task: null,
                priority: null,
                note: null,
                status: null,
            };
        },
    },
};
</script>
<style>
  .text {
    font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
    font-size: 40px;
    font-style: italic;
  }
</style>