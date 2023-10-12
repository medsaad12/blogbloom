<template>
    <Sidebar></Sidebar>
    <main class="blogbloom-main">
        <router-view></router-view> 
    </main>
</template>

<script setup>
import Sidebar from './components/Sidebar.vue';
import {onBeforeMount} from "vue"
import { userStore } from '@/stores/user';

const userr = userStore();

onBeforeMount(()=>{
    userr.initUser();
})

</script>

<style>
.blogbloom-main{
    width: 100%;
    order: 1;
    margin-left: 18%;
}
.router-link{
    font-style: none;
    color: #FA4853;
    text-decoration: none;
}
</style>