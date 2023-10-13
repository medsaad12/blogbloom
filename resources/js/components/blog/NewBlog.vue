<template>
    <div class="auth-login">
        <h1 class="title">New Blog</h1>
        <form @submit.prevent="newblog" id="login" class="blog-form" action="">
            <div class="form-group">
                <label for="">Title</label>
                <input v-model="title" class="blogbloom-input" type="text" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="">Body</label>
                <textarea v-model="body" class="blogbloom-input-body" cols="30" rows="10">
                </textarea>
            </div>
            <img v-if="loading" src="../assets/loading.gif" class="loading">
            
            <button v-if="!loading" class="blogbloom-button">Create Blog</button>
            <span v-if="isError" class="error">{{ error }}</span>
            <span v-if="isValid" class="message">{{ message }}</span>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import axios from "axios"
import { userStore } from '../../stores/user';

export default {
    name : "newblog",
    setup(){
        const title = ref("");
        const body = ref("")
        const loading = ref(false)
        const error = ref("")
        const isError = ref("");
        const message = ref("")
        const isValid = ref("");
        const user = userStore();

        const newblog = () =>{
            loading.value = true
            axios.post("http://127.0.0.1:8000/api/blogs",
            {
                title : title.value,
                body : body.value,
                user_id : user.id
            },
            {
                headers : 
                { "Authorization" : `Bearer ${localStorage.getItem('authToken')}`}
            })
            .then(()=>{
                // error handling
                loading.value = false
                error.value = ""
                isError.value = false
                title.value = ""
                body.value = ""
                message.value = "Blog Created Succefully"
                isValid.value = true
            })
            .catch(()=>{
                loading.value = false
                isError.value = true 
                message.value = ""
                isValid.value = false
                error.value = "Something is incorrect try again !!"
            })
        }
        

        return {title,body,newblog,loading,error,isError,isValid,message}
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