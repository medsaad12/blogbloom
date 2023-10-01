<template>
    <!-- <Sidebar></Sidebar> -->
    <main class="blogbloom-main">
        <router-view></router-view> 
    </main>
</template>

<script>
import Sidebar from './components/Sidebar.vue'
export default {
    name : "App",
    components : {
        Sidebar
    }
}
</script>

<style>
.blogbloom-main{
    margin: 0;
    padding: 0;
    background-color: #16171A;
    height: 100vh;
}
.router-link{
    font-style: none;
    color: #FA4853;
    text-decoration: none;
}
</style>