<template>
    <div class="container" >
        <div class="row">
            <div class="col-8">
                <div class="card card-default">
                    <div class="card-header">Messages</div>
                    <div class="card-body p-0">
                        <ul class="list-unstyled" style="height:300px; overflow-y:scroll" v-chat-scroll>
                            <li class="p-2" v-for = "(massage,index) in messages" :key="index">
                                <strong ><span v-if="massage.user.avatar"><img :src="'/user/avatar/'+massage.user.avatar"  class="user_img"/> </span>{{massage.user.name}}</strong>
                                {{massage.message}}
                            </li>
                        </ul>
                    </div>

                    <input
                        @keydown="sendTypingEvent"
                        @keyup.enter = "sendMessages"
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
import Services from "../services/services";
    export default {
        // props:['user'],
        data(){
            return {
                user:{},
                messages: [],
                newMessage: '',
                users:[],
                activeUser:false,
                typingTimer:false,
                id:window.location.href.split("/").slice(-1)[0]

            }
        },

       async mounted() {

          await this.fetchMessages();
           window.Echo.join('chat_'+this.$route.params.id)
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

          async  userTime(){
              await Services.getChats();
            },

           async fetchMessages(){
          const  data = await Services.getItem(this.$route.params.id)
               this.messages = data.data
            },

          async  sendMessages(){
             const data =   await Services.PostMassage(this.$route.params.id, {message: this.newMessage, room_id: this.$route.params.id});
              this.messages.push({
                  user:data.data.user,
                  message: this.newMessage
              });
              this.newMessage = '';
            },
            sendTypingEvent(){
                window.Echo.join('chat_'+this.$route.params.id)
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
