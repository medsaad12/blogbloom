<template>
    <h1 class="title">Hello</h1>
    <div class="blogs">
        <div class="blog" v-for="blog in blogs">
            <div class="userData">
                <div class="user-icon">&#128100;</div>
                <span>{{ ucfirst(blog.user.name) }}</span>
            </div>
            <span class="blog-title">{{ ucfirst(blog.data.title) }}</span>
            <p class="blog-body">{{ ucfirst(blog.data.body) }}</p>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { onMounted, ref } from 'vue';

    const blogs = ref([]);

    function ucfirst(inputString) {
    if (inputString.length === 0) {
      return inputString;
    }
    return inputString.charAt(0).toUpperCase() + inputString.slice(1);
    }

    onMounted(()=>{
        axios.get("http://127.0.0.1:8000/api/blogs", {
        headers: {
            "Authorization": `Bearer ${localStorage.getItem('authToken')}`
        }
        }).then((response) => {
            blogs.value = response.data.blogs
        })
        
    }) 
</script>

<style>
    h1 {
        text-align: center;
    }

    .blogs{
        width: 80%;
        margin-left: 10%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .blog{
        width: 50%;
        display: flex;
        flex-direction: column;
        padding: 5px;
        background-color: #27282C;
        font-family: 'poppins';
        margin-bottom: 10px;
        border-radius: 15px;
    }
    .userData{
        margin: 10px 0px 0px 10px;
        display: flex;
        color: rgb(196, 196, 196);
        align-items: center;
    }
    .user-icon{
        font-size: 20px;
    }
    .blog-title{
        color: white;
        width: 100%;
        font-size: 20px;
        margin: 10px 0px 0px 10px;
    }
    .blog-body{
        margin: 10px;
        color: black;
        padding: 5px;
        background-color: #999daf9f;
        border-radius: 5px;
    }
</style>