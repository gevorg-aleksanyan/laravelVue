<template>
    <div class="home">
        <table>
            <tr>
                <th>Room Name</th>
                <th>Open</th>
            </tr>
            <tr v-for="(room,index) in rooms" :key="index">
                <td>{{room.name}}</td>
                <td><button @click="send_room(room.id)">Open</button></td>
            </tr>

        </table>
    </div>
</template>

<script>
export default {
    name: "HomeComponent",

    data(){
        return {
            rooms: [],

        }
    },

    mounted() {
        this.delete_room();
        this.fetchroom();
    },

    methods:{
        fetchroom() {
            axios.post('/home-fetch-room').then(response => {
                this.rooms = response.data;
            })
        },

        send_room(id){
            axios.get('chat-page/' + id).then(response => {
                window.location.href = 'chats/'+id;
            })
        },
        delete_room(){
            axios.get('delete-room/').then(response => {
               response.data
            });

        },
    }
}
</script>

<style scoped>
table, th, td {
    border: 1px solid;
}

table {
    width: 100%;
}
.home{
    width: 70%;
}

</style>
