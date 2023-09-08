<template>
    <ul>
        <li v-for="todo in todos" :key="todo">
            {{ todo.id }} / {{ todo.name }} / {{ todo.age }}
            <Delete :todo="todo.id"></Delete>
        </li>
    </ul>
</template>

<script>
    import Delete from './Delete.vue';

    export default {
        data() {
            return {
                todos: [],
            }
        },
        components: {
            Delete,
        },
        mounted() {
            this.index();
        },
        methods: {
            async index() {
            await axios.get("/api/todo")
            .then(
                res => {
                        var arrayData = res.data;
                        arrayData.forEach( value => {
                            this.todos.push(value);
                        });
                    }
                )
            .catch(err => console.error(err));
            },
        },
    };
</script>