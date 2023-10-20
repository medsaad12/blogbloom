<template>
    <div class="auth-login">
      <h1 class="title">Edit</h1>
      <form @submit.prevent="editBlog" id="editBlogForm" class="blog-form" action="">
        <div class="form-group">
          <label for="title">Title</label>
          <input v-model="title" class="blogbloom-input" type="text" placeholder="Title" id="title">
        </div>
        <div class="form-group">
          <label for="body">Body</label>
          <textarea v-model="body" class="blogbloom-input-body" cols="30" rows="10" id="body"></textarea>
        </div>
        <img v-if="isLoading" src="../assets/loading.gif" class="loading">
        <button v-if="!isLoading" class="blogbloom-button">Edit Blog</button>
        <span v-if="isError" class="error">{{ error }}</span>
        <span v-if="isValid" class="message">{{ message }}</span>
      </form>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';

  
  const title = ref('');
  const body = ref('');
  const isLoading = ref(false);
  const error = ref('');
  const isError = ref(false);
  const message = ref('');
  const isValid = ref(false);
  const router = useRouter();

  onMounted(() => {
    axios.get(`http://127.0.0.1:8000/api/getBlog/${router.currentRoute.value.params.id}`)
    .then((response) => {
      title.value = response.data.blog.title
      body.value = response.data.blog.body
    })
  });
  
  const editBlog = () => {
    isLoading.value = true;
  
    axios
      .put(`http://127.0.0.1:8000/api/blogs/${router.currentRoute.value.params.id}`, {
        title: title.value,
        body: body.value,
      }, {
        headers: { "Authorization": `Bearer ${localStorage.getItem('authToken')}` },
      })
      .then(() => {
        isLoading.value = false;
        error.value = '';
        isError.value = false;
        title.value = '';
        body.value = '';
        message.value = 'Blog Updated Successfully';
        isValid.value = true;
      })
      .catch((error) => {
        isLoading.value = false;
        isError.value = true;
        isValid.value = false;
        message.value = '';
        error.value = `Error: ${error.response.data.message || 'Something went wrong. Please try again.'}`;
      });
  };
  </script>
  
  <style>
  .auth-login {
    margin: 0;
    padding: 50px 0 0;
    background-color: #16171A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }
  
  #editBlogForm {
    height: 400px;
    width: 400px;
  }
  </style>
  