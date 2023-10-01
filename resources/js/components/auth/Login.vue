<template>
    <div class="auth-login">
        <h1 class="title">Login</h1>
        <form id="login" class="blog-form" action="">
            <div class="form-group">
                <label for="">Email</label>
                <input class="blogbloom-input" type="email" placeholder="Email">
            </div>
            <div class="form-group">
                <label for="">Password</label>
                <input class="blogbloom-input" type="password" placeholder="Password">
            </div>
            <button class="blogbloom-button">Submit</button>
            <p class="form-p">If you don't have an account, <router-link to="/signup"><span class="router-link">signup</span></router-link> here.</p>

        </form>
    </div>
</template>

<script>
export default {
    name : "Login"
}
</script>

<style>
.auth-login{
    margin: 0;
    padding: 50px 0px 0px 0px;
    background-color: #16171A;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}
#login{
    height: 400px;
    width: 400px;
}
.title{
    font-family: 'poppins';
    color: #FA4853;
    height: auto;
    width: auto;

}
.blog-form{
    
    border: 1px solid #FA4853;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: 'poppins';
    color: #FA4853;
    border-radius: 20px;
    box-shadow: #FA4853 2px 8px 100px 0px;


}
.blog-form label{
    margin-bottom: 10px;
    margin-left: 10px;
}
.form-group{
    display: flex;
    flex-direction: column;
    margin-bottom: 30px;
}
.blogbloom-input{
    width: 250px;
    height: 50px;
    outline: none;
    border: 1px solid #FA4853;
    color: #FA4853;
    padding-left: 20px;
    border-radius: 15px;
    font-family: 'poppins';
    font-size: 15px;
    background-color: #16171A;
}
.blogbloom-button{
    width: 100px;
    height: 50px;
    border-radius: 15px;
    border: none;
    cursor: pointer;
    font-size: 15px;
    font-family: 'poppins';
    color: white;
    background-color:#FA4853;
    margin-bottom: 10px;
}
.blogbloom-button:hover{
    background-color:#fa4854d2;
}
.form-p{
    color: white;
    font-size: 12px;
    margin-bottom: 0px;
}
</style>