<template>
    <div>
        メッセージ
        <div v-if="successMsg" class="successMsg">{{ successMsg }}</div>
    </div>

    <div class="container">
        <!-- 追加フォーム -->
        <div class="mr5">
            <div>
                <button @click="addBtn" class="mb10 mr5">追加</button>
            </div>
            <div v-if="addShow" class="mb10">
                <div v-if="errorMsg" class="errorMsg">{{ errorMsg }}</div>

                名前：<input type="text" v-model="addTodo.name" name="name">
                <br>
                年齢：<input type="number" v-model="addTodo.age" name="age">
                <br>
                <button @click="add" class="mb5">ADD</button>
            </div>
        </div>

        <!-- 更新フォーム -->
        <div>
            <div>
                <button v-if="updateShow" @click="updateBtn" class="mb5">更新</button>
            </div>
            <div v-if="updateShow" class="mb10">
                <p class="m0">id: {{ updateTodo.id }}</p>
                
                名前：<input type="text" v-model="updateTodo.name" name="name">
                <br>
                年齢：<input type="number" v-model="updateTodo.age" name="age">
                <br>
                <button @click="updateTodoById()">UPDATE</button>
            </div>
        </div>
    </div>

    <!-- 一覧表示 -->
    <ul>
        <li v-for="todo in todos" :key="todo">
            {{ todo.id }} / {{ todo.name }} / {{ todo.age }}
            <button class="mr5" @click="editTodo(todo)">EDIT</button>
            <button @click="deleteTodo(todo.id)">DELETE</button>
        </li>
    </ul>
</template>

<script>
    export default {
        data () {
            return {
                addShow: false,
                updateShow: false,

                todos: [],

                addTodo: {
                    name: '',
                    age: null,
                },

                updateTodo: {
                    id: null,      
                    name: '',
                    age: null,
                },

                successMsg: '',
                errorMsg: '',
            }
        },
        mounted() {
            this.index();
        },
        methods: {
            addBtn () {
                this.addShow = !this.addShow;
            },
            updateBtn () {
                this.updateShow = !this.updateShow;
            },
            initTodoForm(word) {
                if (word === 'add') {
                    this.addTodo.name = '';
                    this.addTodo.age = null;
                    return;
                }
                this.updateTodo.id = null;
                this.updateTodo.name = '';
                this.updateTodo.age = null;
            },
            success(msg) {
                switch (msg) {
                    case 'add':
                        this.successMsg = "登録しました";
                        break;
                    case 'update':
                        this.successMsg = "更新しました";
                        break;
                    case 'delete':
                        this.successMsg = "削除しました";
                        break;
                }
                this.errorMsg = '';
                return;
            },
            async index() {
                await axios.get("/api/todo")
                .then(
                    res => {
                            // res.dataはオブジェクトが返却
                            // res.data.dataで配列が返却される
                            var arrayData = res.data.data;
                            this.todos = arrayData;
                        }
                    )
                .catch(err => console.error(err));
            },
            async add() {
                if (this.addTodo.name === '' || this.addTodo.age === null || this.addTodo.age < 0) {
                    this.errorMsg = '名前か、年齢を正しく入力してください';
                    return;
                }

                await axios.post("/api/todo/add", this.addTodo)
                .then(
                    res => {
                            this.initTodoForm('add');
                            this.success('add');
                            this.index();
                        }
                    )
                .catch(err => console.error(err));
            },
            editTodo(todo) {
                this.updateShow = true;

                this.updateTodo.id = todo.id;
                this.updateTodo.name = todo.name;
                this.updateTodo.age = todo.age;
            },
            async updateTodoById() {
                await axios.post("/api/todo/update/", this.updateTodo)
                .then(
                    res => {
                            this.initTodoForm('update');
                            this.success('update');
                            this.index();
                        }
                    )
                .catch(err => console.error(err));
            },

            async deleteTodo(id) {
                await axios.post("/api/todo/delete/", {
                    id: id
                })
                .then(
                    res => {
                            this.success('delete');
                            this.index();
                        }
                    )
                .catch(err => console.error(err));
            },
        }
    }
</script>

<style>
    .container {
        display: flex;
    }

    .m0 {
        margin: 0;
    }

    .mb5 {
        margin-bottom: 5px;
    }

    .mb10 {
        margin-bottom: 10px;
    }

    .mr5 {
        margin-right: 5px;
    }

    .successMsg {
        font-size: 12px;
        background: greenyellow;
        width: 50%;
        
    }

    .errorMsg {
        font-size: 12px;
        color: red;
    }
</style>