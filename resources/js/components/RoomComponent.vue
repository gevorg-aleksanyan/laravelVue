<template>
    <div>
            <input type="text" v-model="name">
            <button @click="acceptBudget">Accept budget</button>
    </div>
</template>

<script>
export default {
    name: "Roomcomponent",

    data(){
        return {
           name:""

        }
    },

    methods: {

       acceptBudget() {
             axios.post('room',{
                name:this.name
            }).then(response =>{
                 window.location.href = 'admin-dashboard';
           })
        }
    }
}
</script>

<style scoped>

input[type=text], select {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

input[type=submit]:hover {
    background-color: #45a049;
}

div {
    border-radius: 5px;
    background-color: #f2f2f2;
    padding: 20px;
}

</style>
