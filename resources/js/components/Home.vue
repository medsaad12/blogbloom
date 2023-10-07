<template>
    <h1 class="title">Hello</h1>
</template>

<script setup>
import { userStore } from '../stores/user';

const user = userStore();
        

</script>

<style>
p{
    color: red;
}
h1{
    text-align: center;
}
</style>