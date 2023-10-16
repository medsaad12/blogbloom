<template>
    <h1 class="title">Hello</h1>

    <div class="blogs">

        <form v-if="newBlogForm" @submit.prevent="newblog" id="login newBlogForm" class="blog-form" action="">
            <img @click="toglleNewBlogForm" src="../components/assets/close.png" id="closebutton">
            <div class="form-group">
                <label for="">Title</label>
                <input v-model="title" class="blogbloom-input" type="text" placeholder="Title">
            </div>
            <div class="form-group">
                <label for="">Body</label>
                <textarea v-model="body" class="blogbloom-input-body" cols="30" rows="10">
                </textarea>
            </div>
            <img v-if="loading" src="../../js/components/assets/loading.gif" class="loading">

            <button v-if="!loading" class="blogbloom-button">Create Blog</button>
            <span v-if="isError" class="error">{{ error }}</span>
            <span v-if="isValid" class="message">{{ message }}</span>
        </form>


        <div v-else @click="toglleNewBlogForm" class="newblog">
            Tap to start new blog
        </div>


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
    import { userStore } from '../stores/user';
import { useRouter } from 'vue-router';

    const blogs = ref([]);

    function ucfirst(inputString) {
        if (inputString.length === 0) {
            return inputString;
        }
        return inputString.charAt(0).toUpperCase() + inputString.slice(1);
    }

    onMounted(() => {
        axios.get("http://127.0.0.1:8000/api/blogs", {
            headers: {
                "Authorization": `Bearer ${localStorage.getItem('authToken')}`
            }
        }).then((response) => {
            blogs.value = response.data.blogs
        })

    })

    const newBlogForm = ref(false)
    const router = useRouter()
    const toglleNewBlogForm = () => {
        user.isLoggedIn ?
        newBlogForm.value = !newBlogForm.value :
        router.push('/login')
    }
    
    const title = ref("");
    const body = ref("")
    const loading = ref(false)
    const error = ref("")
    const isError = ref("");
    const message = ref("")
    const isValid = ref("");
    const user = userStore();

    const newblog = () => {
        loading.value = true
        axios.post("http://127.0.0.1:8000/api/blogs",
            {
                title: title.value,
                body: body.value,
                user_id: user.id
            },
            {
                headers:
                    { "Authorization": `Bearer ${localStorage.getItem('authToken')}` }
            })
            .then(() => {
                // error handling
                loading.value = false
                error.value = ""
                isError.value = false
                title.value = ""
                body.value = ""
                message.value = "Blog Created Succefully"
                isValid.value = true
            })
            .catch(() => {
                loading.value = false
                isError.value = true
                message.value = ""
                isValid.value = false
                error.value = "Something is incorrect try again !!"
            })
    }

</script>

<style>
    h1 {
        text-align: center;
    }

    .blogs {
        width: 80%;
        margin-left: 10%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .blog {
        width: 50%;
        display: flex;
        flex-direction: column;
        padding: 5px;
        background-color: #27282C;
        font-family: 'poppins';
        margin-bottom: 10px;
        border-radius: 15px;
    }

    .userData {
        margin: 10px 0px 0px 10px;
        display: flex;
        color: rgb(196, 196, 196);
        align-items: center;
    }

    .user-icon {
        font-size: 20px;
    }

    .blog-title {
        color: white;
        width: 100%;
        font-size: 20px;
        margin: 10px 0px 0px 10px;
    }

    .blog-body {
        margin: 10px;
        color: black;
        padding: 5px;
        background-color: #999daf9f;
        border-radius: 5px;
    }

    .newblog {
        width: 45%;
        padding: 20px;
        margin-bottom: 15px;
        border: 2px solid #FA4853;
        border-radius: 15px;
        color: #FA4853;
        font-family: 'poppins';
        text-align: center;
        cursor: pointer;
    }

    .blogs form {
        width: 45%;
        padding: 20px;
        margin-bottom: 15px;
        padding-top: 40px;
        box-shadow: none;
        position: relative;
    }

    #closebutton {
        height: 35px;
        width: 35px;
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 30px;
    }
</style>