<template>
    <div>
        <p>Home Page</p>
    </div>
</template>

<script>
import { onMounted } from 'vue';

    
export default {
    name : "Home",
    setup(){
        onMounted(()=>{
            console.log("mounted")
        })
    }
}
</script>

<style>
p{
    color: red;
}
</style>