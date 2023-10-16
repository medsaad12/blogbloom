<template>
   <div class="profile">
    <div class="links">
        <a @click="changeStatus">Profile Informations</a>
        <a @click="changeStatus">Posts</a>
        
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
    
    </div>

</template>

<script setup>
    import { userStore } from '../stores/user';
    import { ref } from 'vue';

    const user = userStore();
    const status = ref("info");

    const changeStatus = ()=>{
        status.value
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
</style>