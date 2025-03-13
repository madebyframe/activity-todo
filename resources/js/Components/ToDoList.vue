<template>

    <div id="todo-container" class="p-8">
          <section id="todo-header" class="m-8">
            <h1 class="text-center">Activity Messenger Tasks</h1>
          </section>
          <section id="todo-errors">
            <v-alert v-if="createTodoForm.errors.length > 0"
                     closable type="error" variant="tonal">
              <span v-for="(error, index) in createTodoForm.errors" :key="index">{{ error }}</span>
            </v-alert>

            <v-alert v-if="createTodoForm.isCreated"
                     closable type="info" variant="tonal">Task has been saved to your list.</v-alert>

          </section>

      <v-row>
        <v-col>
          <section id="add-todo-form" class="p-8">

            <v-card loading="createTodoFrom.isSubmitting"
                title="Add a Task" text="" class="p-8">
              <v-text-field clearable label="Add To Do Task"
                            placeholder="Enter Task and Press Enter"
                            minlength="5" maxlength="250"
                            v-model="createTodoForm.task"
                            v-on:change="addTodo"
              ></v-text-field>
              <v-card-actions>
                <v-btn
                  v-on:click="addTodo">
                  Add To List</v-btn>
              </v-card-actions>
            </v-card>

            <div class="py-8">
              <v-switch
                  v-model="showCompleted"
                  v-on:change="loadTodos"
                  label="Show Completed Tasks"
                  hide-details
                  inset
              ></v-switch>
            </div>

          </section>
        </v-col>
        <v-col>
          <section id="todo-list">
            <v-skeleton-loader type="list-item-avatar" v-if="createTodoForm.isSubmitting || todos.isLoading"
            ></v-skeleton-loader>

              <v-card
                  v-for="todo in todos.data" :key="todo.uuid"
                  class="mx-auto p-4 m-8"
                  hover
              >
                <v-card-title>
                  <v-checkbox v-model="todo.completed" v-on:change="updateTodo(todo)"></v-checkbox>
                  {{ todo.task }}
                </v-card-title>
                <v-card-subtitle>
                  <small class="text-muted">Created {{ todo.created_at }}</small>
                </v-card-subtitle>
                <v-card-text class="text-right">
                  <v-btn v-on:click="destroy(todo)">Delete</v-btn>
                </v-card-text>

              </v-card>

              <v-alert v-if="!todos.isLoading && (todos.data.length === 0)"
                       variant="tonal" type="warning">No todo items found.</v-alert>
          </section>
        </v-col>
      </v-row>
    </div>
</template>

<script>
export default {
  name: 'TodoList',
  data() {
    return {
      todos: {
        isLoading: false,
        data: []
      },
      createTodoForm: {
        isSubmitting: false,
        isCreated: false,
        task: undefined,
        errors: []
      },
      error: undefined,
      showCompleted: false
    }
  },
  mounted() {
    this.loadTodos();
  },
  methods: {

    loadTodos() {
      this.todos.isLoading = true;

      axios.get('/todotasks/' + (this.showCompleted ? '1' : '0') )
          .then((response) => {
            this.todos.data = response.data;
          })
          .catch((error) => {
            console.log(error.message);
            this.error = 'Unable to load tasks.';
          })
          .finally(() => {
            this.todos.isLoading = false;
          });
    },

    addTodo() {
      if( this.createTodoForm.task ) {
        this.createTodoForm.isSubmitting = true;

        axios.post('/todotasks', this.createTodoForm)
            .then((response) => {
              this.createTodoForm.errors = [];
              this.createTodoForm.task = undefined;
              this.createTodoForm.isCreated = true;
              this.loadTodos();
            })
            .catch((error) => {
                console.log(error.message);
                this.error = 'Unable to add todo. View log for more information';
            })
            .finally(() => {
              // disable loader
              this.createTodoForm.isSubmitting = false;
            });
      }
    },

    updateTodo(todoTask) {

      axios.put(`/todotask/${todoTask.uuid}`, { completed: todoTask.completed } )
          .then((response) => {
            this.loadTodos();
          })
          .catch((error) => {
              console.log(error.message);
              this.error = 'Unable to update todo. View log for more information';

          });
    },

    destroy(todoTask) {
      axios.delete(`/todotask/${todoTask.uuid}`)
          .then((response) => {
            this.loadTodos();
          })
          .catch((error) => {
            console.log(error.message);
            this.error = 'Unable to delete todo. View log for more information';
          });
    }
  }
}
</script>