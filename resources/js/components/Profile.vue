<template>
   <div class="profile">
    <div class="links">
        <a @click="changeStatus('info')">Profile Informations</a>
        <a @click="changeStatus('blogs')">Blogs</a>
        
    </div>
    <form v-if="status == 'info'" id="login" class="blog-form" action="">
        <div class="form-group">
            <label for="">Name</label>
            <input :value="user.name" class="blogbloom-input" type="text" readonly>
        </div>
        <div class="form-group">
            <label for="">Email</label>
            <input :value="user.email" class="blogbloom-input" type="text" readonly>
        </div>
    </form>
    <img v-if="loading" src="../components//assets/loading.gif" id="loading">
    <span id="deletedMessage" v-if="deletedMessage">{{ deletedMessage }}</span>
    <div v-if="status == 'blogs' && loading == false" class="blogs">
        <div  class="blog" v-for="blog in state.blogs">
            <div class="blog-title">
                {{ blog.title }} 
                <div class="icons">
                    <img src="../components/assets/edit.png" id="edit-icon">
                    <img @click="deleteBlog(blog.id)" src="../components/assets/delete.png" id="delete-icon">
                </div>
            </div>
            <p class="blog-body">{{ blog.body }}</p>
    </div>
    </div>

    </div>

</template>

<script setup>
    import axios from 'axios';
    import { userStore } from '../stores/user';
    import {ref } from 'vue';
    import { reactive } from 'vue'
    import { useRouter } from 'vue-router';


    const user = userStore();
    const status = ref("info");
    const state = reactive({blogs : []})
    const loading = ref(false)
    const deletedMessage = ref("")
    const router = useRouter()
    

    const changeStatus = (statuss)=>{
        if (statuss == 'blogs') {
            loading.value = true
            axios.get(`http://127.0.0.1:8000/api/getBlogs/${user.id}`,{
            headers : {
                "Authorization": `Bearer ${localStorage.getItem('authToken')}`
            }
            }).then((response)=>{
                loading.value = false
                state.blogs = reactive(response.data.blogs)
            })
        }
        status.value = statuss
        deletedMessage.value = ""
    }


   

    function deleteBlog(id){
        axios.post(`http://127.0.0.1:8000/api/blogs/${id}`,{_method:"DELETE"},{
            headers : {
                "Authorization": `Bearer ${localStorage.getItem('authToken')}`
            }
            }).then(()=>{
                deletedMessage.value = "Blog Deleted Successfully"
                const arr = state.blogs.filter((e) => e.id !== id)
                state.blogs = reactive(arr)
            })
    }

</script>

<style>
.profile{
    margin: 0;
    padding: 50px 0px 0px 0px;
    background-color: #16171A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#login{
    height: 300px;
    width: 400px;
}
.links{
    width: 300px;
    display: flex;
    justify-content: space-between;
    margin-bottom: 50px;
}
.links a{
    font-family: 'poppins';
    color: #FA4853;
    font-size: 20px;
    text-decoration: none;
    cursor: pointer;
}
#loading{
    height: 200px;
    width: 200px;
}
#edit-icon{
    height: 30px;
    width: 30px;
    cursor: pointer;
}
#delete-icon{
    height: 38px;
    width: 38px;
    cursor: pointer;
}
.icons{
    display: flex;
    align-items: center;
    justify-content: center;
    padding-right: 10px;
}
#deletedMessage{
    font-family: 'poppins';
    color: red;
    font-size: 15px;
    margin-bottom: 20px;
    text-align: center;
    
}
</style>