<template>
  <div
    class="input-group mb-3 container-fluid"
    :class="{ 'text-black-50': todo.completed_at }"
  >
    <div class="input-group-prepend">
      <div class="input-group-text">
        <input
          @change="completeTodo"
          v-model="todo.completed_at"
          type="checkbox"
          id="completed-checkbox"
          name="completed"
        />
      </div>
    </div>
    <div
      class="card-header w-75"
      data-toggle="collapse"
      :href="'#collapse-' + todo.id"
    >
      <h5 class="card-title">{{ todo.title }}</h5>
    </div>
    <div class="input-group-append">
      <button type="button" class="btn btn-outline-danger" @click="deleteTodo">
        Delete
      </button>
    </div>
    <div class="w-75 ml-4">
      <div class="collapse card-body" :id="'collapse-' + todo.id">
        <p>{{ todo.description }}</p>
        <p>Deadline: {{ displayDeadline }}</p>
        <div>
          <input
            @change="completeTodo"
            v-model="todo.completed_at"
            type="checkbox"
            id="completed-checkbox"
            name="completed"
          />
          <label for="completed">{{
            todo.completed_at
              ? "Completed on " + displayCompleted
              : "Mark as completed"
          }}</label>
        </div>

        <button
          type="button"
          class="btn btn-outline-secondary mb-2"
          data-toggle="modal"
          data-target="#todoForm"
          @click="populateModalData"
        >
          Edit
        </button>
      </div>
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

  computed: {
    displayDeadline() {
      return new Date(this.todo.deadline_at).toDateString();
    },

    displayCompleted() {
      return new Date(this.todo.completed_at).toDateString();
    },
  },

  methods: {
    deleteTodo() {
      this.$emit("delete-todo", this.todo.id);
    },
    //should this be split out into one for edit and one for complete?
    completeTodo() {
      this.populateModalData();
      const isoDate = new Date().toISOString();
      this.todo.completed_at = isoDate.slice(0, 19).replace("T", " ");
      this.$emit("complete-todo", this.todo);
    },

    populateModalData() {
      this.$emit("populate-modal-data", this.todo);
    },
  },
};
</script>
