<template>
  <div class="container m-5">
    <div class="card d-flex align-items-center">
      <div class="container">
        <h1 class="m-3">Todo App</h1>
        <div>
          <validation-observer v-slot="{ invalid }">
            <form class="form-inline my-3">
              <div class="form-group mx-sm-3 mb-2">
                <label for="categoryInput" class="sr-only"
                  >Add new category</label
                >
                <validation-provider rules="required" v-slot="{ errors }">
                  <input
                    name="Category"
                    type="text"
                    class="form-control"
                    id="categoryInput"
                    placeholder="Add new category"
                    v-model="nameText"
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
              <button
                :disabled="invalid"
                type="button"
                class="btn btn-primary mb-2 ml-2"
              >
                +
              </button>
            </form>
          </validation-observer>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button
              class="nav-link active"
              id="home-tab"
              data-bs-toggle="tab"
              data-bs-target="#home"
              type="button"
              role="tab"
              aria-controls="home"
              aria-selected="true"
            >
              Home
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="profile-tab"
              data-bs-toggle="tab"
              data-bs-target="#profile"
              type="button"
              role="tab"
              aria-controls="profile"
              aria-selected="false"
            >
              Profile
            </button>
          </li>
          <li class="nav-item" role="presentation">
            <button
              class="nav-link"
              id="contact-tab"
              data-bs-toggle="tab"
              data-bs-target="#contact"
              type="button"
              role="tab"
              aria-controls="contact"
              aria-selected="false"
            >
              Contact
            </button>
          </li>
        </ul>
        <div class="tab-content" id="myTabContent">
          <div
            class="tab-pane fade show active"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
          >
            <!-- <todo-list v-bind="lists"></todo-list> -->
          </div>
          <div
            class="tab-pane fade"
            id="profile"
            role="tabpanel"
            aria-labelledby="profile-tab"
          >
            <!-- <todo-list></todo-list> -->
          </div>
          <div
            class="tab-pane fade"
            id="contact"
            role="tabpanel"
            aria-labelledby="contact-tab"
          >
            <!-- <todo-list></todo-list> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import TodoList from "./TodoList.vue";

export default {
  components: {
    TodoList,
  },

  data() {
    return {
      lists: [],
      categories: [],
      highlightedCategoryId: 0,
      nameText: "",
      colorText: "",
    };
  },

  mounted() {
    // axios
    //   .get("/api/categories")
    //   .then((response) => (this.categories = response.data));
    axios.get("/api/tasks").then((response) => (this.lists = response.data));
    // .then((response) => (this.lists = response.data))
    // .then(console.log(this.lists));
  },

  // handleSubmitCategory() {
  //   const apiData = {
  //     name: this.nameText,
  //     color: colorText,
  //   };
  //   if (this.nameText.length > 0) {
  //     if (!this.highlightedCategoryId) {
  //       this.createCategory(apiData);
  //     } else {
  //       this.updateCategory(apiData);
  //       this.highlightedCategoryId = 0;
  //     }
  //   }
  // },
};
</script>
