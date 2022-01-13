<template>
  <div class="card my-2">
    <div class="">
      <h2>{{ todo.title }}</h2>
      <p>{{ todo.description }}</p>
      <p>Deadline: {{ todo.deadline_at }}</p>
      <div>
        <input
          @change="completeTodo"
          v-model="todo.completed_at"
          type="checkbox"
          id="completed-checkbox"
          name="completed"
        />
        <label for="completed">Completed</label>
      </div>
      <button
        type="button"
        class="btn btn-outline-danger mb-2"
        @click="deleteTodo"
      >
        Delete todo
      </button>
      <button
        type="button"
        class="btn btn-outline-secondary mb-2"
        data-toggle="modal"
        data-target="#todoForm"
      >
        Edit
      </button>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    todo: {
      type: Object,
      required: true,
    },
    modalData: {
      type: Object,
      required: true,
    },
    highlightedTodoId: {
      type: Number,
      required: false,
    },
  },

  data() {
    return {
      isEditing: false,
    };
  },

  methods: {
    deleteTodo() {
      this.$emit("delete-todo", this.todo.id);
    },
    //should this be split out into one for edit and one for complete?
    completeTodo() {
      const isoDate = new Date().toISOString();
      this.todo.completed_at = isoDate.slice(0, 19).replace("T", " ");
      this.$emit("complete-todo", this.todo);
    },
  },
};
</script>
