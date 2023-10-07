import axios from "axios";
import {defineStore} from "pinia"

export const userStore = defineStore({
    id : "userStore",
    state : () => ({
        isLoggedIn : false,
        id: null,
        name : "",
        email : "",
    }),
    actions : {
        async initUser(){
            const authToken = localStorage.getItem('authToken')
            if (authToken) {
               await axios.get('http://127.0.0.1:8000/api/user',{
                    headers : {
                        "Authorization" : `Bearer ${authToken}`
                    }
                })
                .then((response)=>{
                    this.isLoggedIn = true
                    this.id = response.data.id
                    this.name = response.data.name
                    this.email = response.data.email 
                })
            }
        },
        setUser(id,name,email){
            this.isLoggedIn = true
            this.id = id
            this.name = name
            this.email = email
        },
        removeUser(){
            this.isLoggedIn = false
            this.id = null
            this.name = ""
            this.email = ""
        }
    }
})