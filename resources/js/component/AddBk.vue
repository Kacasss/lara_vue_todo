<template>
    名前：<input type="text" v-model="name" name="name">
    <br>
    年齢：<input type="text" v-model="age" name="age">
    <br>
    <button @click="add">ADD</button>
</template>

<script>
    export default {
        data () {
            return {
                name: '',
                age: 0,
            }
        },
        methods: {
            async add() {
                await axios.post("/api/todo/add", {
                    name: this.name,
                    age: this.age
                }, )
                .then(
                    res => {
                            console.log("きました");
                        }
                    )
                .catch(err => console.error(err));
            },

        }
    }
</script>