
<template>
  <div>
    <add-todo @create-todo="createTodo($event)"></add-todo>
    <todo-item
      v-bind:key="todo.id"
      v-bind:todo="todo"
      v-for="todo in todos"
      @delete-todo="deleteTodo($event)"
      @update-todo="updateTodo($event)"
    ></todo-item>
  </div>
</template>

<script>
import TodoItem from "./TodoItem.vue";
import AddTodo from "./AddTodo.vue";

export default {
  components: {
    AddTodo,
    TodoItem,
  },

  data() {
    return { todos: [] };
  },

  mounted() {
    axios.get("/api/tasks").then((response) => (this.todos = response.data));
  },

  methods: {
    createTodo(todo) {
      axios
        .post("/api/tasks", todo)
        .then((response) => (this.todos = [response.data, ...this.todos]))
        .then(() => console.log(this.todos));
    },

    deleteTodo(todoId) {
      axios
        .delete("/api/tasks/" + todoId)
        .then(
          () => (this.todos = this.todos.filter((todo) => todoId !== todo.id))
        );
    },

    // update to todo  - NEEDS SORTING
    updateTodo(todo) {
      axios
        .put("/api/tasks/" + todo.id, todo)
        .then(
          (response) =>
            (this.todos = this.todos.map((obj) =>
              response.data.id === obj.id ? response.data : obj
            ))
        );
    },
  },
};
</script>
