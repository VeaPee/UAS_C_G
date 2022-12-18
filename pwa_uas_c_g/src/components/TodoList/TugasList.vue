<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar color="grey"></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline">To Do List</v-list-item-title>
                    <v-list-item-subtitle>by 200710662 </v-list-item-subtitle>
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
                    style="margin-top: 30px;"
                ></v-text-field>
                <v-spacer></v-spacer>
                <v-select
                    v-model="searchFilter"
                    :items="[`All`, `Penting`, `Tidak Penting`]"
                    label="Filter"
                ></v-select>
                <v-spacer></v-spacer>
                <v-btn color="success" dark @click="dialog = true"> Tambah </v-btn>   
            </v-card-title>
        </v-card>
        <v-card>
               <v-data-table :headers="headers" :items="todos" :search="search" :expanded.sync="expanded" item-key="note" show-expand>
                <template v-slot:[`expanded-item`]="{ item }">
                        <td colspan="6">
                            <span v-if="item.priority == 'Penting'">
                                <v-card color="red" style="margin:10px -20px 10px -5px;">
                                <v-chip color="red" style="margin:10px; box-shadow: 2px 2px 2px;"><i class="fa fa-fire" style="color:white"> {{ item.priority }}</i></v-chip>
                                <br>
                                <v-chip color="orange" style="margin:2px 10px 10px 10px; box-shadow: 2px 2px 2px;"><i class="fa fa-sticky-note" style="color:white"> {{ item.note }}</i></v-chip>
                                </v-card>
                            </span>
                            <span v-else-if="item.priority == 'Biasa'">
                                <v-card color="green" style="margin:10px -20px 10px -5px;">
                                <v-chip color="green" style="margin:10px; box-shadow: 2px 2px 2px;"><i class="fa fa-fire" style="color:white"> {{ item.priority }}</i></v-chip>
                                <br>
                                <v-chip color="orange" style="margin:2px 10px 10px 10px; box-shadow: 2px 2px 2px;"><i class="fa fa-sticky-note" style="color:white"> {{ item.note }}</i></v-chip>
                                </v-card>
                            </span>
                            <span v-else>
                                <v-card color="blue" style="margin:10px -20px 10px -5px;">
                                <v-chip color="blue" style="margin:10px; box-shadow: 2px 2px 2px;"><i class="fa fa-fire" style="color:white"> {{ item.priority }}</i></v-chip>
                                <br>
                                <v-chip color="orange" style="margin:2px 10px 10px 10px; box-shadow: 2px 2px 2px;"><i class="fa fa-sticky-note" style="color:white"> {{ item.note }}</i></v-chip>
                                </v-card>
                            </span>
                        </td>
                    
                </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <v-icon size="50" color="red" @click="editItem(item)">mdi-pencil-circle</v-icon>
                        <v-icon size="50" color="green" @click="deleteItem(item)">mdi-delete-circle</v-icon>
                    </template>
                    <template v-slot:[`item.priority`]="{ item }">
                        <span v-if="item.priority == 'Penting'">
                            <iconify-icon icon="mdi-alert-octagon" style="color: red;" width="40" height="40"></iconify-icon>
                        </span>
                        <span v-else-if="item.priority == 'Biasa'">
                            <iconify-icon icon="mdi-alert-octagon" style="color: green;" width="40" height="40"></iconify-icon>
                        </span>
                        <span v-else>
                            <iconify-icon icon="mdi-alert-octagon" style="color: blue;" width="40" height="40"></iconify-icon>
                        </span>
                    </template>

                    <template v-slot:[`item.checkbox`]="{ item }">
                        <input type="checkbox" :value="item" v-model="selected"/>
                    </template>
                </v-data-table>
                
        </v-card>

        <v-card v-if="selected.length != '0'">
            <v-list-item style="margin-bottom:-20px">
                <br>
                <h4>Delete Multiple</h4>
            </v-list-item>
            <v-card-text style="margin-left:25px">
                <ul v-for="(item, index) in selected" :key="index">
                    <li> {{ item.task }} </li>
                </ul>      
            </v-card-text>
            <v-btn color="red" dark @click="hapusSom()" style="margin:-10px -20px 10px 10px;"> Hapus Semua </v-btn>
        </v-card>

        <v-dialog v-model="confirm" persistent max-width="500px">
            <v-card class="accordion arrows">
                <br>
                <v-card-text style="color: black">
                    <h1>Are you sure to delete?</h1>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green" text @click="hapus()">
                        YES
                    </v-btn>
                    <v-btn color="red" text @click="cancelConfirm()">
                        NO
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog> 
        
        <v-dialog v-model="dialog" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline"> Form Todo List </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                            v-model="formTodo.task"
                            label="Task"
                            required
                        ></v-text-field>
                        <v-select
                            v-model="formTodo.priority"
                            :items="[`Penting`, `Biasa`, `Tidak Penting`]"
                            label="Priority"
                            required
                        ></v-select>
                        <v-textarea
                            v-model="formTodo.note"
                            label="Note"
                            required
                        ></v-textarea>
                        <v-select
                            v-model="formTodo.status"
                            :items="[`Selesai`, `Belum Selesai`]"
                            label="Status"
                            required
                        ></v-select>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancel"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="save"> Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-model="updateItem" persistent max-width="600px">
            <v-card>
                <v-card-title>
                    <span class="headline"> Form Todo List </span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-text-field
                            v-model="formTodo.task"
                            label="Task"
                            required
                        ></v-text-field>
                        <v-select
                            v-model="formTodo.priority"
                            :items="[`Penting`, `Biasa`, `Tidak Penting`]"
                            label="Priority"
                            required
                        ></v-select>
                        <v-textarea
                            v-model="formTodo.note"
                            label="Note"
                            required
                        ></v-textarea>
                        <v-select
                            v-model="formTodo.status"
                            :items="[`Selesai`, `Belum Selesai`]"
                            label="Status"
                            required
                        ></v-select>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="cancelUpdate"> Cancel</v-btn>
                    <v-btn color="blue darken-1" text @click="update"> Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-main>
</template>

<script>
    export default {
        name: "ListItem",
        data() {
            return {
                search: null,
                searchFilter: 'All',
                dialog: false,
                confirm: false,
                updateItem: false,
                headers: [
                    
                    {
                        text: "Task",
                        align: "start",
                        sortable: true,
                        value: "task",
                    },
                    { text: "Priority", value: "priority" },
                    { text: "Status", value: "status" },
                    { text: "Actions", value: "actions" },
                    { text: "", value: "checkbox" },
                ],
                todos: [
                    {
                        task: "Coding",
                        priority: "Penting",
                        note: "Code for your life",
                        status:"Belum Selesai",
                    },
                    {
                        task: "Cooking",
                        priority: "Biasa",
                        note: "Indomie saat begadang ngerjain coding terbaek",
                        status:"Selesai",
                    },
                    {
                        task: "Gaming",
                        priority: "Tidak Penting",
                        note: "Wasting time",
                        status:"Belum Selesai",
                    },
                ],
                formTodo: {
                    task: null,
                    priority: null,
                    note: null,
                    status: null,
                },
                selected: [],
                filter: [],
                delete: null,
                edit: null,
                id: null,
            };
        },
        methods: {
            save() {
                this.todos.push(this.formTodo);
                this.resetForm();
                this.dialog = false;
                this.selected = [];
            },
            cancel() {
                this.resetForm();
                this.dialog = false;
            },
            cancelUpdate() {
                this.resetForm();
                this.updateItem = false;
            },
            cancelConfirm() {
                this.confirm = false;
            },
            resetForm() {
                this.formTodo = {
                    task: null,
                    priority: null,
                    note: null,
                    status: null,
                };
            },
            editItem(item){
                this.edit = item;
                this.formTodo.task = item.task;
                this.formTodo.priority = item.priority;
                this.formTodo.note = item.note;
                this.formTodo.status = item.status;
                this.updateItem = true;
            },
            update(){
                this.edit.task = this.formTodo.task;
                this.edit.priority = this.formTodo.priority;
                this.edit.note = this.formTodo.note;
                this.edit.status = this.formTodo.status;
                this.updateItem = false;
                this.selected = [];
            },
            hapus(){
                const index = this.todos.indexOf(this.delete);
                this.todos.splice(index, 1);  
                this.confirm = false;
                this.selected = [];
            },
            deleteItem(item) {
                this.delete = item;
                this.confirm = true;  
            },
            hapusSom(){
                var length = this.todos.length;
                for(let i = 0;i < length;i++){
                    for(let y = 0;y < this.selected.length ;y++){
                        if(this.todos[i] == this.selected[y]){
                            const index = this.todos.indexOf(this.selected[y]);
                            this.todos.splice(index, 1); 
                        }
                    }
                }
                this.selected = [];
            },
            cekFilter(){
                var length = this.todos.length;
                var j = 0 ;
                if(this.searchFilter=='All'){
                    this.filter = this.todos;
                    this.selected = [];
                }else{
                    for(let i = 0;i < length;i++){
                        if(this.searchFilter==this.todos[i].priority){
                            this.filter[j] = this.todos[i];
                            j++;
                        }
                    }
                    this.selected = [];
                }  
            }
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