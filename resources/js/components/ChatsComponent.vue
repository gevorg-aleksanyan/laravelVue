<template>
    <div class="container" >
        <div class="row">
            <div class="col-8">
                <div class="card card-default">
                    <div class="card-header">Messages</div>
                    <div class="card-body p-0">
                        <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                            <li class="p-2" v-for = "(massage,index) in messages" :key="index">
                                <strong><img :src="'/user/avatar/'+massage.user.avatar"  class="user_img"/> {{massage.user.name}}</strong>
                                {{massage.message}}
                            </li>
                        </ul>
                    </div>

                    <input
                        @keydown="sendTypingEvent"
                        @keyup.enter = "send_messages"
                        v-model="newMessage"
                        type="text"
                        name="message"
                        placeholder="Enter your message..."
                        class="form-control">
                </div>
                <span class="text-muted" v-if="activeUser">{{activeUser.name}} is typing...</span>
            </div>

            <div class="col-4">
                <div class="card card-default">
                    <div class="card-header">Active Users</div>
                    <div class="card-body">
                        <ul>
                            <li class="py-2" v-for="(user,index) in users" :key="index">
                               <img :src="'/user/avatar/'+user.avatar"  class="user_img"/> {{user.name}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props:['user'],
        data(){
            return {
                messages: [],
                newMessage: '',
                users:[],
                activeUser:false,
                typingTimer:false,
            }
        },

        mounted() {

           this.fetchmessages();
            var url = window.location.href;
            var url_id = url.split("/").slice(-1)[0]

           window.Echo.join('chat_'+url_id)
               .here(user => {
                   this.users = user;
               })
               .joining(user => {
                   this.users.push(user);
               })
               .leaving(user => {
                   this.users = this.users.filter(u => u.id != user.id);
               })
               .listen('MessageSent',(event)=>{
                   this.messages.push(event.message)

               })
               .listenForWhisper('typing', user => {
                   this.activeUser = user;
                     if(this.typingTimer){
                         clearTimeout(this.typingTimer);
                     }
                  this.typingTimer =  setTimeout(()=>{
                       this.activeUser = false;
                   },3000);
               })
        },
        methods: {
            fetchmessages(){
                var url = window.location.href;
                var url_id = url.split("/").slice(-1)[0];

                axios.get('/messages_page/'+ url_id).then(response =>{
                    this.messages = response.data;
                }).catch(err =>{
                    console.log(err.message)
                })
            },

            send_messages(){
                var url = window.location.href;
                var url_id = url.split("/").slice(-1)[0]
                this.messages.push({
                    user:this.user,
                    message: this.newMessage
                });
              axios.post('/send_messages', {message: this.newMessage, room_id:url_id});

              this.newMessage = '';

            },
            sendTypingEvent(){

                var url = window.location.href;
                var url_id = url.split("/").slice(-1)[0]
                window.Echo.join('chat_'+url_id)
                    .whisper('typing' , this.user);
            },


        }
    }
</script>


<style>
.user_img{
    width: 30px;
    height: 30px;
    border-radius: 50%;
}
</style>
