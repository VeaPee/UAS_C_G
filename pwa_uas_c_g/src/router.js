import VueRouter from "vue-router";
import Vue from "vue";


Vue.use(VueRouter);

function importComponent(path){
    return () => import(`./components/${path}.vue`);
}

const router = new VueRouter({
    mode: "history",
    routes:[
        {
            path:"/",
            name:"admin",
            component: importComponent("DashboardLayout"),
            children:[
                //Dashboard
                {
                    path: "/",
                    name: "Root",
                    component: importComponent("DashboardIndex")
                },
                //To Do List
                {
                    path:"/gd",
                    name:"Guided",
                    component: importComponent("TodoList/ListItem"),
                },
                {
                    path: "/ugd",
                    name: "Activity Unguided",
                    component: importComponent("TodoList/ActivityUnguided"),
                },
                {
                    path: "/transaksi",
                    name: "Transaksi Tiket",
                    component: importComponent("pwa_10662/TransaksiTiket"),
                },
                {
                    path: "/register",
                    name: "Register Page",
                    component: importComponent("pwa_10662/RegisterPage"),
                },
                {
                    path: "/login",
                    name: "Login Page",
                    component: importComponent("pwa_10662/LoginPage"),
                },
                {
                    path: "/profile",
                    name: "Profile Page",
                    component: importComponent("pwa_10662/ProfilePage"),
                },
                {
                    path: "/tournament",
                    name: "Tournament Page",
                    component: importComponent("pwa_10662/TournamentPage"),
                },
                {
                    path: "/aboutus",
                    name: "About Us",
                    component: importComponent("pwa_10662/AboutUs"),
                },
                {
                    path: "/tambahteam",
                    name: "Tambah Team",
                    component: importComponent("pwa_10662/TambahTeam"),
                },
            ],
        },
    ],
});
export default router;