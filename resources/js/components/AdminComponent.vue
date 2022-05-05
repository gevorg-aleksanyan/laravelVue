<template>
<div>
    <div class="header">
        <a href="#default" class="logo">Admin</a>
        <div class="header-right">
            <a class="active" href="/room-page" >Add Room</a>
        </div>

        <ul>
            <li v-for="(room,index) in rooms" :key="index" >{{room.name}}   <button @click="send_room(room.id)">Open</button></li>
        </ul>
    </div>
</div>
</template>

<script>
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
        fetchroom() {
            axios.post('fetch-room').then(response => {
                this.rooms = response.data;
            })
        },

        send_room(id){
            axios.get('chat-page/' + id).then(response => {
                window.location.href = 'chats/'+id;
            })
        },
    }
}
</script>

<style scoped>

</style>
