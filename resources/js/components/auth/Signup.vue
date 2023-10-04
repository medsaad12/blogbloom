
<template>
    <div class="auth-signup">
        <h1 class="title">Signup</h1>
        <form @submit.prevent="register" class="blog-form" id="signup" action="">
            <div class="form-group">
                <label for="">Name</label>
                <input v-model="name" class="blogbloom-input" type="Name" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input v-model="email" class="blogbloom-input" type="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input v-model="password" class="blogbloom-input" type="password" placeholder="Password">
            </div>
            <img v-if="loading" src="../assets/loading.gif" class="loading">
            <button class="blogbloom-button">Submit</button>
            <span v-if="isError" class="error">{{ error }}</span>
            <p class="form-p">If you already have an account, <router-link to="/login"><span class="router-link">login </span></router-link>here.</p>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from "axios"
import { useRouter } from 'vue-router';

export default {
    name : "Signup",
    setup(){
        const name = ref("");
        const email = ref("");
        const password = ref("")
        const loading = ref(false)
        const error = ref("")
        const isError = ref(false)
        const router = useRouter() 
        
        const register = ()=>{
            loading.value = true
            axios.get('/sanctum/csrf-cookie')
            .then(() => {
                axios.post('http://127.0.0.1:8000/api/register', {name: name.value, email: email.value, password: password.value })
                .then(response => {
                        loading.value = false
                        error.value = ""
                        isError.value = false
                        name.value = ""
                        email.value = ""
                        password.value = ""
                        router.push("/login")
                    
                })
                .catch(errr => {
                    loading.value = false
                    isError.value = true
                    error.value = "The informations is inccorect try again"
                });
            })
             .catch(errr => {
                    loading.value = false
                    isError.value = true
                    error.value = 'Error in the server side !!'
            });
        }

        return {name,email,password,register,loading,error,isError}
    }
}
</script>

<style>
.auth-signup{
    margin: 0;
    padding: 15px 0px 0px 0px;
    background-color: #16171A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#signup{
    height: 500px;
    width: 500px;
}

</style>