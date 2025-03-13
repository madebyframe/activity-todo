<template>
  <v-app>
      <ToDoList></ToDoList>

  </v-app>
</template>

<script>
import { defineComponent } from "vue";
import ToDoList from '../Components/ToDoList.vue';
export default defineComponent({

  components: { ToDoList },
  data() {
    return {
    };
  },
});
</script>
