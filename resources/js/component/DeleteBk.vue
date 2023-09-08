<template>
    <button @click="deleteTodo(todo)">DELETE</button>
</template>

<script>
    export default {
        props: ['todo'],
        methods: {
            async deleteTodo(todo) {
                console.log(todo);
                await axios.post(`/api/todo/delete/${id}`)
                .then(
                    res => {
                            console.log("きました");
                            // console.log(res.data);
                        }
                    )
                .catch(err => console.error(err));
            },
        },
    }
</script>