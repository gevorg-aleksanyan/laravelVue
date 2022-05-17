<template>
    <div class="home">
        <table>
            <tr>
                <th>Room Name</th>
                <th>Open</th>
            </tr>
            <tr v-for="(room,index) in rooms" :key="index">
                <td>{{room.name}}</td>
                <td>
<!--                    <button @click="sendRoom(room.id)">Open</button>-->
                    <router-link :to="{name:'chats',params: {id:room.id} }" class="btn btn-primary btn-sm">Open</router-link>

                </td>

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
        this.deleteRoom();
        this.fetchRoom();
    },

    methods:{
        fetchRoom() {
            axios.post('/home-fetch-room').then(response => {
                this.rooms = response.data;
            })
        },
        deleteRoom(){
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
