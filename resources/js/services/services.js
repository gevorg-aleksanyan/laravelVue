export default {
  async  getItem(id){
       return await axios.get(`/messages-page/${id}`)
    },
    async getChats(){
       return await axios.get('/chats')
    },
    async PostMassage(id,data){
      return await  axios.post(`/messages/${id}`, data)
    },

    async postRoom(){
      return await  axios.post('fetch-room');
    },


}
