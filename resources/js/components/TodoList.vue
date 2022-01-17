
<template>
  <div class="card d-flex align-items-center">
    <div>
      <form class="form-inline my-3">
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
          class="btn btn-primary mb-2 ml-2"
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
      data-backdrop="static"
      data-keyboard="false"
      tabindex="-1"
      role="dialog"
      aria-labelledby="todoFormLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 v-if="highlightedTodoId" class="modal-title" id="todoFormLabel">
              Edit todo
            </h5>
            <h5 v-else class="modal-title" id="todoFormLabel">New todo</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <validation-observer v-slot="{ invalid }">
            <div class="modal-body">
              <form>
                <div class="form-group">
                  <label for="title-name" class="col-form-label">Title:</label>
                  <validation-provider rules="required" v-slot="{ errors }">
                    <input
                      name="Title"
                      type="text"
                      class="form-control"
                      id="title-text"
                      v-model="modalData.titleText"
                    />
                    <div
                      v-show="errors[0]"
                      class="alert alert-danger"
                      role="alert"
                    >
                      {{ errors[0] }}
                    </div>
                  </validation-provider>
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
                @click="clearModalData"
              >
                Cancel
              </button>
              <button
                :disabled="invalid"
                type="button"
                class="btn btn-primary"
                data-dismiss="modal"
                @click="handleSubmitForm"
              >
                Save
              </button>
            </div>
          </validation-observer>
        </div>
      </div>
    </div>
    <todo-item
      v-bind:key="todo.id"
      v-bind:todo="todo"
      v-bind:modalData="modalData"
      v-bind:highlightedTodoId="highlightedTodoId"
      v-for="todo in outstandingTodos"
      @delete-todo="deleteTodo($event)"
      @complete-todo="updateTodo($event)"
      @populate-modal-data="populateModalData($event)"
    ></todo-item>
    <hr v-if="completedTodos.length > 0" class="divider" />
    <h5 v-if="completedTodos.length > 0" class="card-title ml-3">
      Completed tasks
    </h5>
    <todo-item
      v-bind:key="todo.id"
      v-bind:todo="todo"
      v-bind:modalData="modalData"
      v-bind:highlightedTodoId="highlightedTodoId"
      v-for="todo in completedTodos"
      @delete-todo="deleteTodo($event)"
      @complete-todo="updateTodo($event)"
      @populate-modal-data="populateModalData($event)"
    ></todo-item>
    <div>{{ list }}</div>
  </div>
</template>

<script>
import TodoItem from "./TodoItem.vue";

export default {
  // props: {
  //   lists: {
  //     type: Array,
  //     required: true,
  //   },
  // },

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

  computed: {
    completedTodos() {
      return this.todos.filter((todo) => todo.completed_at);
    },
    outstandingTodos() {
      return this.todos.filter((todo) => !todo.completed_at);
    },
  },

  methods: {
    populateModalData(data) {
      this.highlightedTodoId = data.id;
      this.modalData.titleText = data.title;
      this.modalData.descriptionText = data.description;
      this.modalData.deadlineDate = data.deadline_at.slice(0, 10);
      //   this.modalData.completedDate = data.completed_at.slice(0, 10);
    },

    clearModalData() {
      this.modalData.titleText = "";
      this.modalData.descriptionText = "";
      this.modalData.deadlineDate = "";
      this.modalData.completedDate = "";
      this.highlightedTodoId = 0;
    },

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

    updateTodo(todo) {
      console.log(todo);
      axios
        .put("/api/tasks/" + this.highlightedTodoId, todo)
        .then(
          (response) =>
            (this.todos = this.todos.map((obj) =>
              response.data.id === obj.id ? response.data : obj
            ))
        );
      this.clearModalData();
    },

    handleSubmitForm() {
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
