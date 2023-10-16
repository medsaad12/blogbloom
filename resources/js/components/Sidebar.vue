<template>
    <aside  class="sidebar">
        <h2 class="title">BlogBloom</h2>
        <nav>
        <router-link to="/">Home</router-link>
        <router-link v-if="user.isLoggedIn" to="/profile">Profile</router-link>
        <router-link v-if="!user.isLoggedIn" to="/login">Login</router-link>
        <router-link v-if="!user.isLoggedIn" to="/signup">Signup</router-link>
        </nav>
        <form @click.prevent="logout" v-if="user.isLoggedIn" action="">
            <button class="blogbloom-button" type="submit">Logout</button>
        </form>
    </aside>
</template>

<script setup>
import axios from 'axios';
import { userStore } from '../stores/user';
import { useRouter } from 'vue-router';
import {onMounted} from "vue"

const user = userStore();

onMounted(()=>{
    user.initUser();
})

const router = useRouter();

const logout = ()=>{
    axios.post("http://127.0.0.1:8000/api/logout",{id : user.id},{
        headers : {
            "Authorization" : `Bearer ${localStorage.getItem('authToken')}`
        }})
    .then(()=>{
        localStorage.removeItem('authToken')
        user.removeUser();
        router.push("/login")
    })
}
</script>

<style>
.sidebar{
    height: 100vh;
    width: 18%;
    background-color: #16171af6;
    border-right: 3px solid #FA4853;
    display: flex;
    flex-direction: column;
    align-items: center;
    position: fixed;
    
}
.sidebar nav {
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

nav a{
    height: 60px;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    color: gray;
    font-family: "Poppins";
}
nav a:hover{
    background-color:#FA4853 ;
}
form{
    margin-top: auto;
}
</style>