<template>
<div>
    <div class="header">
        <a href="#default" class="logo">Admin</a>
        <div class="header-right">
            <a class="active" href="/room-page" >Add Room</a>
        </div>

        <ul>
            <li v-for="(room,index) in rooms" :key="index" >{{room.name}}
                <router-link :to="{name:'chats',params: {id:room.id} }" class="btn btn-primary btn-sm">Open</router-link>
            </li>
        </ul>
    </div>
</div>
</template>

<script>
import Services from "../services/services";
export default {
    name: "AdminComponent",
    data(){
        return {
            rooms: [],

        }
    },

    mounted() {
        this.fetchroom();
    },

    methods:{
      async  fetchroom() {
          const data = await Services.postRoom();
          this.rooms = data.data;

        },

    }
}
</script>

<style scoped>

</style>
