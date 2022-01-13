<template>
  <div>

  </div>
</template>

<script>
export default {
  props: {
    inputData: {
      type: Object,
      required: true,
    },
  },

  methods: {

    sendForm() {
      console.log(this.titleText);
      if (this.titleText.length > 0) {
        console.log(this.titleText);
        // const title = this.titleText;
        // const description = this.descriptionText;
        // const deadline_at = this.deadlineDate;
        // this.$emit("create-todo", {
        //   title,
        //   description,
        //   deadline_at,
        //   completed_at: "",
        // });
        // this.clearForm();
      }
    },
  },
};
</script>
