<template>
    <div class="auth-signup">
        <h1 class="title">Signup</h1>
        <form class="blog-form" id="signup" action="">
            <div class="form-group">
                <label for="">Name</label>
                <input class="blogbloom-input" type="Name" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="">Email</label>
                <input class="blogbloom-input" type="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input class="blogbloom-input" type="password" placeholder="Password">
            </div>
            <button class="blogbloom-button">Submit</button>
            <p class="form-p">If you already have an account, <router-link to="/login"><span class="router-link">login </span></router-link>here.</p>
        </form>
    </div>
</template>

<script>
export default {
    name : "Signup"
}
</script>

<style>
.auth-signup{
    margin: 0;
    padding: 15px 0px 0px 0px;
    background-color: #16171A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#signup{
    height: 500px;
    width: 500px;
}
</style>