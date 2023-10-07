<template>
    <div class="auth-login">
        <h1 class="title">Login</h1>
        <form @submit.prevent="login" id="login" class="blog-form" action="">
            <div class="form-group">
                <label for="">Email</label>
                <input v-model="email" class="blogbloom-input" type="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input v-model="password" class="blogbloom-input" type="password" placeholder="Password">
            </div>
            <img v-if="loading" src="../assets/loading.gif" class="loading">
            
            <button v-if="!loading" class="blogbloom-button">Submit</button>
            <span v-if="isError" class="error">{{ error }}</span>
            <p class="form-p">If you don't have an account, <router-link to="/signup"><span class="router-link">signup</span></router-link> here.</p>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from "axios"
import { useRouter } from 'vue-router';
import { userStore } from '../../stores/user';
export default {
    name : "Login",
    setup(){
        const email = ref("");
        const password = ref("")
        const loading = ref(false)
        const error = ref("")
        const isError = ref(false)
        const router = useRouter();
        const user = userStore();

        const login = ()=>{
            loading.value = true
            axios.get('/sanctum/csrf-cookie')
            .then(() => {
                axios.post('http://127.0.0.1:8000/api/login', { email: email.value, password: password.value })
                .then(response => {
                        // error handling
                        loading.value = false
                        error.value = ""
                        isError.value = false
                        email.value = ""
                        password.value = ""
                        // set localstorage
                        localStorage.setItem('authToken',response.data.token)
                        //set user
                        let data = response.data.user
                        user.setUser(data.id, data.name, data.email)
                        //redirect
                        router.push("/")
                })
                .catch(err => {
                    loading.value = false
                    isError.value = true 
                    error.value = "The email or the password is incorrect try again"
                });
            })
             .catch(errr => {
                    loading.value = false
                    isError.value = true
                    error.value = 'Error in the server side '
            });
        }

        return {email,password,login,loading,error,isError}
    }
}
</script>

<style>
.auth-login{
    margin: 0;
    padding: 50px 0px 0px 0px;
    background-color: #16171A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#login{
    height: 400px;
    width: 400px;
}
</style>