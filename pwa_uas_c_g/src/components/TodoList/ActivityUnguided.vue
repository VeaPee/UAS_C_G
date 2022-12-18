<template>
    <v-main class="list">
        <v-card>
            <v-list-item>
                <v-list-item-avatar color="grey"></v-list-item-avatar>
                <v-list-item-content>
                    <v-list-item-title class="headline"> To Do List </v-list-item-title>
                        <v-list-item-subtitle> by 200710662 </v-list-item-subtitle>
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
                    style="margin-top: 30px"
                ></v-text-field>
                <v-spacer></v-spacer>
                    <v-btn color="success" dark @click="dialog = true"> Tambah </v-btn>
            </v-card-title>
        </v-card>
        <v-card>
               <v-data-table :headers="headers" :items="todos" :search="search" :expanded.sync="expanded" item-key="note" show-expand>
                    <template v-slot:[`expanded-item`]="{ item }">
                        <td colspan="5">

                            <span v-if="item.priority == 'Penting'">
                                <v-card style="margin:10px -20px 10px -5px;" color="red">
                                <v-chip style="margin:10px; box-shadow: 2px 2px 2px;" color="red"><i class="fa fa-fire" style="color:white"> {{ item.priority }} </i></v-chip>
                                <br>
                                <v-chip style="margin:2px 10px 10px 10px; box-shadow: 2px 2px 2px;" color="orange"><i class="fa fa-sticky-note" style="color:white"> {{ item.note }} </i></v-chip>
                                </v-card>
                            </span>

                            <span v-else-if="item.priority == 'Biasa'">
                                <v-card style="margin:10px -20px 10px -5px;" color="green">
                                <v-chip style="margin:10px; box-shadow: 2px 2px 2px;" color="green"><i class="fa fa-fire" style="color:white"> {{ item.priority }} </i></v-chip>
                                <br>
                                <v-chip style="margin:2px 10px 10px 10px; box-shadow: 2px 2px 2px;" color="orange"><i class="fa fa-sticky-note" style="color:white"> {{ item.note }} </i></v-chip>
                                </v-card>
                            </span>

                            <span v-else>
                                <v-card style="margin:10px -20px 10px -5px;" color="blue">
                                <v-chip style="margin:10px; box-shadow: 2px 2px 2px;" color="blue"><i class="fa fa-fire" style="color:white"> {{ item.priority }} </i></v-chip>
                                <br>
                                <v-chip style="margin:2px 10px 10px 10px; box-shadow: 2px 2px 2px;" color="orange"><i class="fa fa-sticky-note" style="color:white"> {{ item.note }} </i></v-chip>
                                </v-card>
                            </span>
                        </td>
                    
                </template>
                    <template v-slot:[`item.actions`]="{ item }">
                        <v-icon size="35" color="red" @click="editItem(item)"> mdi-pencil-circle </v-icon>
                            <v-icon size="35" color="green" @click="deleteItem(item)"> mdi-delete-circle </v-icon>
                    </template>

                    <template v-slot:[`item.priority`]="{ item }">
                        <span v-if="item.priority == 'Penting'">
                            <iconify-icon icon="mdi-alert-octagon" style="color: red;" width="39" height="39"></iconify-icon>
                        </span>

                        <span v-else-if="item.priority == 'Biasa'">
                            <iconify-icon icon="mdi-alert-octagon" style="color: green;" width="39" height="39"></iconify-icon>
                        </span>

                        <span v-else>
                            <iconify-icon icon="mdi-alert-octagon" style="color: blue;" width="39" height="39"></iconify-icon>
                        </span>
                    </template>
                </v-data-table>
        </v-card>

        <v-dialog v-model="confirmDelete" persistent max-width="490px">
            <v-card class="accordion arrows">
                <br>
                <v-card-text style="color: black">
                    <h3>Are You Sure To Delete ?</h3>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    
                    <v-btn color="green" text @click="deleteForm()">YES</v-btn>
                        <v-btn color="red" text @click="cancelConfirm()">NO</v-btn>
                        
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

        <v-dialog v-model="updateData" persistent max-width="600px">
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
                    <v-btn color="blue darken-1" text @click="cancelUpdate"> Cancel </v-btn>
                    <v-btn color="blue darken-1" text @click="update"> Save </v-btn>
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
                dialog: false,
                confirm: false,
                updateData: false,

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
            },
            cancel() {
                this.resetForm();
                this.dialog = false;
            },
            cancelUpdate() {
                this.resetForm();
                this.updateData = false;
            },
            cancelConfirm() {
                this.confirmDelete = false;
            },
            resetForm() {
                this.formTodo = {
                    status: null,
                    task: null,
                    priority: null,
                    note: null,
                };
            },
            editItem(item){
                this.edit = item;
                this.formTodo.status = item.status;
                this.updateData = true;
                this.formTodo.task = item.task;
                this.formTodo.priority = item.priority;
                this.formTodo.note = item.note;
            },
            deleteForm(){
                const index = this.todos.indexOf(this.delete);
                this.todos.splice(index, 1);  
                this.confirmDelete = false;
            },
            deleteItem(item) {
                this.delete = item;
                this.confirmDelete = true;
            },
            update(){
                this.edit.task = this.formTodo.task;
                this.edit.status = this.formTodo.status;
                this.edit.note = this.formTodo.note;
                this.updateData = false;
                this.edit.priority = this.formTodo.priority;
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