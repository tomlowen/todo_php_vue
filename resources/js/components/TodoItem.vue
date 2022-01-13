<template>
  <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
    <div class="grid grid-cols-1">
      <h2>{{ todo.title }}</h2>
      <p>{{ todo.description }}</p>
      <p>Deadline: {{ todo.deadline_at }}</p>
      <div>
        <input
          @change="updateTodo"
          type="checkbox"
          id="completed-checkbox"
          name="completed"
        />
        <label for="completed">Completed</label>
      </div>
      <button @click="deleteTodo">Delete todo</button>
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
  },

  methods: {
    deleteTodo() {
      this.$emit("delete-todo", this.todo.id);
    },
    //should this be split out into one for edit and one for complete?
    updateTodo() {
        // set the completed_at property to now  - NEEDS SORTING
      this.todo.completed_at = new Date(now());
      this.$emit("update-todo", this.todo);
    },
  },
};
</script>
