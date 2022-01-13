
<template>
  <div class="card">
    <h1>Todo App</h1>
    <div>
      <form class="form-inline">
        <div class="form-group mx-sm-3 mb-2">
          <label for="titleInput" class="sr-only">Add new todo item</label>
          <input
            id="titleInput"
            v-model="modalData.titleText"
            type="text"
            class="form-control"
            placeholder="Add new todo item"
          />
        </div>
        <button
          type="button"
          class="btn btn-primary mb-2"
          data-toggle="modal"
          data-target="#todoForm"
        >
          +
        </button>
      </form>
    </div>
    <div
      class="modal fade"
      id="todoForm"
      tabindex="-1"
      role="dialog"
      aria-labelledby="todoFormLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="todoFormLabel">New todo</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="title-name" class="col-form-label">Title:</label>
                <input
                  type="text"
                  class="form-control"
                  id="title-text"
                  v-model="modalData.titleText"
                />
              </div>
              <div class="form-group">
                <label for="description-text" class="col-form-label"
                  >Description:</label
                >
                <textarea
                  class="form-control"
                  id="description-text"
                  v-model="modalData.descriptionText"
                ></textarea>
              </div>
              <div class="form-group">
                <label for="deadline-date" class="col-form-label"
                  >Deadline:</label
                >
                <input
                  type="date"
                  class="form-control"
                  id="deadline-date"
                  v-model="modalData.deadlineDate"
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              Cancel
            </button>
            <button
              type="button"
              class="btn btn-primary"
              data-dismiss="modal"
              @click="submitFormData"
            >
              Save
            </button>
          </div>
        </div>
      </div>
    </div>
    <!-- <add-todo @create-todo="createTodo($event)"></add-todo> -->
    <todo-item
      v-bind:key="todo.id"
      v-bind:todo="todo"
      v-bind:modalData="modalData"
      v-bind:highlightedTodoId="highlightedTodoId"
      v-for="todo in todos"
      @delete-todo="deleteTodo($event)"
      @complete-todo="updateTodo($event)"
    ></todo-item>
  </div>
</template>

<script>
import TodoItem from "./TodoItem.vue";

export default {
  components: {
    TodoItem,
  },

  data() {
    return {
      highlightedTodoId: 0,
      modalData: {
        titleText: "",
        descriptionText: "",
        deadlineDate: "",
        completedDate: "",
      },
      todos: [],
    };
  },

  mounted() {
    axios.get("/api/tasks").then((response) => (this.todos = response.data));
  },

  methods: {
    clearModalData() {
      this.modalData.titleText = "";
      this.modalData.descriptionText = "";
      this.modalData.deadlineDate = "";
      this.modalData.completedDate = "";
    },

    createTodo(todo) {
      console.log(todo);
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

    updateTodo(todo) {
      axios
        .put("/api/tasks/" + todo.id, { todo })
        .then(
          (response) =>
            (this.todos = this.todos.map((obj) =>
              response.data.id === obj.id ? response.data : obj
            ))
        );
    },

    //this needs to be written
    submitFormData() {
      const apiData = {
        title: this.modalData.titleText,
        description: this.modalData.descriptionText,
        deadline_at: this.modalData.deadlineDate,
        completed_at: this.modalData.completedDate,
      };
      if (this.modalData.titleText.length > 0) {
        if (!this.highlightedTodoId) {
          this.createTodo(apiData);
        } else {
          this.updateTodo(apiData);
        }
        this.clearModalData();
      }
    },
  },
};
</script>
