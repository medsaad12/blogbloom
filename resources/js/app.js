import { createApp } from "vue";
import App from "./App.vue"
import { createRouter,createWebHistory } from "vue-router";
import Dashboard from "./components/Dashboard.vue"
import Signup from "./components/auth/Signup.vue"
import Login from "./components/auth/Login.vue"

const routes = [
    {
        path : "/",
        component : Dashboard
    },
    {
        path : "/signup",
        component : Signup
    },
    {
        path : "/login",
        component : Login
    },
    
];

const router = createRouter({
    history : createWebHistory(),
    routes
})

createApp(App).use(router).mount("#app")