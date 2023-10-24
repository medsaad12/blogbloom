<template>
    <h1 class="title">Hello</h1>

    <div class="blogs">

        
        <!-- add blog form -->
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

        
        <!-- toggle form add blog -->
        <div v-else @click="toglleNewBlogForm" class="newblog">
            Tap to start new blog
        </div>

        <!-- loading -->
        <img id="loadBlogs" v-if="loadBlogs" src="../components/assets/loading.gif">

        <!-- blogs -->
        <div class="blog" v-for="blog in state.blogs">
            <div class="userData">
                <div class="user-icon">&#128100;</div>
                <span>{{ ucfirst(blog.user.name) }}</span>
            </div>
            <span class="blog-title">{{ ucfirst(blog.data.title) }}</span>
            <p class="blog-body">{{ ucfirst(blog.data.body) }}</p>
            <div class="reactions" v-if="user.isLoggedIn">
                
                <div>
                    <!-- like -->
                    <img @click="unlike(blog.data.id)"  v-if="blog.isLiked" class="reactions-icon"  src="../components/assets/like.png" />
                    <!-- unlike -->
                    <img @click="like(blog.data.id)" v-else class="reactions-icon" src="../components/assets/unlike.png" />
                </div>
                   <!-- likes count -->
                   <span class="likescount">{{blog.count}}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios';
    import { onMounted, reactive, ref } from 'vue';
    import { userStore } from '../stores/user';
    import { useRouter } from 'vue-router';

    const user = userStore();

    const state = reactive({blogs:[]});

    const loadBlogs = ref(true)

    function ucfirst(inputString) {
        if (inputString.length === 0) {
            return inputString;
        }
        return inputString.charAt(0).toUpperCase() + inputString.slice(1);
    }

    onMounted(() => {
        setTimeout(()=>{
            loadBlogs.value = true
            if (user.id != null) {
            axios.get(`http://127.0.0.1:8000/api/blogs?id=${user.id}`, {
            headers: {
                "Authorization": `Bearer ${localStorage.getItem('authToken')}`
            }
            }).then((response) => {
                loadBlogs.value = false
                state.blogs = reactive(response.data.blogs) 
            }) } else{
                axios.get(`http://127.0.0.1:8000/api/blogs`)
                .then((response) => {
                loadBlogs.value = false
                state.blogs = reactive(response.data.blogs) 
            })
            }
         }, 700)
        
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

 
    const like = (id) => {
        axios.post(`http://127.0.0.1:8000/api/like/${id}/${user.id}`, {withCredentials: true},{
            headers: {
                "Authorization": `Bearer ${localStorage.getItem('authToken')}`
            }
        }).then((response) => {
            const arr = state.blogs.map((blog) => blog.data.id == id ? {...blog,isLiked : true,count : blog.count + 1}: {...blog})
            state.blogs = reactive(arr)
        })
    }

    const unlike = (id)=>{
        axios.post(`http://127.0.0.1:8000/api/unlike/${id}/${user.id}`, {withCredentials: true},{
        headers: {
            "Authorization": `Bearer ${localStorage.getItem('authToken')}`
        }
        }).then((response) => {
            const arr = state.blogs.map((blog) => blog.data.id == id ? {...blog,isLiked : false,count : blog.count - 1}: {...blog})
            state.blogs = reactive(arr)
        })
    }
</script>

<style>
    h1 {
        text-align: center;
    }
    #loadBlogs{
        margin-top: 100px;
        height: 200px;
        width: 200px;
    }
</style>