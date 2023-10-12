import axios from "axios";
import {defineStore} from "pinia"

export const blogStore = defineStore({
    id : "blogStore",
    state : () => ({
        title : "",
    }),
    actions : {
        addPost(){
        },
        editPost(){
        },
        removePost(){
        }
    }
})