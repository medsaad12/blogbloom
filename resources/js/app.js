import { createApp } from "vue";
import App from "./App.vue"
import { createRouter,createWebHistory } from "vue-router";


const router = createRouter({
    history : createWebHistory(),
    routes : [
        {
            path : "/",
            name : "home",
            component : ()=> import( "./components/Home.vue")
        },
        {
            path : "/signup",
            name : "signup",
            component : ()=> import("./components/auth/Signup.vue")
        },
        {
            path : "/login",
            name : "login",
            component : ()=> import("./components/auth/Login.vue")
        },
        
    ]
});


router.beforeEach((to)=>{
    if (to.name == "home") {
        const authToken = localStorage.getItem('authToken');
        if(!authToken ){
            return "/login" 
        }
    }
    if (to.name == "signup" || to.name == "login") {
        const authToken = localStorage.getItem('authToken');
        if(authToken){
            return "/" 
        }
    }
})




createApp(App).use(router).mount("#app")