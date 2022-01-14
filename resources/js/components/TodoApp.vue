<template>
  <div class="container">
    <div class="card d-flex align-items-center mt-5">
      <div>
        <h1 class="m-3">Todo App</h1>
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
                <h5
                  v-if="highlightedTodoId"
                  class="modal-title"
                  id="todoFormLabel"
                >
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
                      <label for="title-name" class="col-form-label"
                        >Title:</label
                      >
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
                    @click="submitFormData"
                  >
                    Save
                  </button>
                </div>
              </validation-observer>
            </div>
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
};
</script>
