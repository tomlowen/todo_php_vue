<template>
  <div id="add-todo-container">
    <button id="add-todo" @click="openForm" v-show="!isCreating">
      Add todo
    </button>

    <div class="ui centered card" v-show="isCreating">
      <div class="content">
        <div class="ui form">
          <div class="field">
            <label>Title</label>
            <input
              v-model="titleText"
              type="text"
              ref="title"
              defaultValue=""
            />
          </div>
          <div class="field">
            <label>Description</label>
            <input
              v-model="descriptionText"
              type="text"
              ref="description"
              defaultValue=""
            />
          </div>
          <div class="field">
            <label>Deadline</label>
            <input
              v-model="deadlineDate"
              type="date"
              ref="deadline"
              defaultValue=""
            />
          </div>
          <div class="ui two button attached buttons">
            <button class="ui basic blue button" @click="sendForm">
              Create
            </button>
            <button class="ui basic red button" @click="closeForm">
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      titleText: "",
      descriptionText: "",
      deadlineDate: "",
      isCreating: false,
    };
  },

  methods: {
    openForm() {
      this.isCreating = true;
    },
    clearForm() {
      this.titleText = "";
      this.descriptionText = "";
      this.deadlineDate = "";
    },
    closeForm() {
      this.isCreating = false;
      this.clearForm();
    },
    sendForm() {
      if (this.titleText.length > 0) {
        const title = this.titleText;
        const description = this.descriptionText;
        const deadline_at = this.deadlineDate;
        this.$emit("create-todo", {
          title,
          description,
          deadline_at,
          completed_at: "",
        });
        this.clearForm();
      }
      this.isCreating = false;
    },
  },
};
</script>
