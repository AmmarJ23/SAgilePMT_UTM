
<template>

<!-- Displays the status for the project according to the order -->
<div class="relative p-2 flex overflow-x-auto h-full">
  <div v-for="(status, index) in statuses.sort((a, b) => a.order - b.order)" :key="index" class="mr-6 w-4/5 max-w-xs flex-shrink-0">
    <div class="rounded-md shadow-md overflow-hidden">

      <div class="p-3 flex justify-between items-baseline bg-blue-800 ">
          <h4 class="font-medium text-white">{{ status.title }}</h4>
          <!-- <button @click="openAddTaskForm(status.id)" class="py-1 px-2 text-sm text-orange-500 hover:underline">Add Task</button> -->
      </div>

      <div class="p-2 bg-blue-100">

        <!-- List of Tasks-->
        <draggable class="flex-1 overflow-hidden" v-model="tasks" v-bind="taskDragOptions" @end="handleTaskMoved">
        <transition-group class="flex-1 flex flex-col h-full overflow-x-hidden overflow-y-auto rounded shadow-xs" tag="div">
          <div v-for="task in filteredTasks(status)" :key="task.id" class="mb-3 p-4 flex flex-col bg-white rounded-md shadow transform hover:shadow-md cursor-pointer">
            <span class="block mb-2 text-xl text-gray-900">{{ task.status_id }}</span>
            <p class="text-gray-700 mb-3"> {{ task.title }} </p>  
            <p class="text-gray-700 mb-3"> {{ task.description }} </p>
              <!-- <p class="text-gray-700 mb-1"><span class="font-semibold text-black-900">Project : </span>{{ task.proj_id }}</p> -->
              <p class="text-gray-700 mb-1"><span class="font-semibold text-black-900">Sprint : </span>{{ task.sprint_id }}</p>
              <p class="text-gray-700 mb-1"><span class="font-semibold text-black-900">User Story : </span>{{ task.userstory_id }}</p>
              <p class="text-gray-700 mb-1"><span class="font-semibold text-black-900">Start Date: </span>{{ formatDate(task.start_date) }}</p>              
              <p class="text-gray-700 mb-1"><span class="font-semibold text-black-900">End Date : </span>{{ formatDate(task.end_date) }}</p>

            <!--Button to Edit or Delete the Task in the status-->
            <!-- <div class="p-3 flex justify-between items-end text-sm bg-gray-100">
              <button @click="openAddTaskForm(status.id)" class="px-3 py-1 leading-5 text-white bg-blue-600 hover:bg-blue-500 rounded">Edit</button>
              <button @click="openAddTaskForm(status.id)" class="px-3 py-1 leading-5 text-white bg-red-600 hover:bg-red-500 rounded">Delete</button>
           </div> -->
          </div>
        </transition-group>
      </draggable>

      <!-- If there is no tasks -->
      <div v-show="filteredTasks(status).length === 0" class="flex-1 p-4 flex flex-col items-center justify-center">
        <span class="text-gray-600">No tasks yet</span>
        <!-- <button class="mt-1 text-sm text-orange-600 hover:underline" @click="openAddTaskForm(status.id)">Add one</button> -->
        <!-- <addtask-form :sprint="sprints" :userstory="userstories"></addtask-form> -->
      </div>


      </div>

      

    </div>
  </div>
</div>



  
</template>



<script>
import draggable from "vuedraggable";
import AddTaskForm from "./AddTaskForm";

export default {
  components: { draggable, AddTaskForm },
  props: {
    tasks: Array,
    statuses: Array
  },
  data() {
    return {
      tasks: [],
      statuses: [],
      newTaskForStatus: 0
    };
  },
  computed: {
    taskDragOptions() {
      return {
        animation: 200,
        group: "task-list",
        dragClass: "status-drag"
      };
    },
  },
  mounted() 
  {
    // 'clone' the statuses so we don't alter the prop when making changes
    this.tasks = JSON.parse(JSON.stringify(this.tasks));
    this.statuses = JSON.parse(JSON.stringify(this.statuses));
  },
  methods: 
  {
    formatDate(date) {
      const options = { day: 'numeric', month: 'long', year: 'numeric' };
      const formattedDate = new Date(date).toLocaleDateString('en-US', options);
      return formattedDate;
    },
    filteredTasks(status) {
      return this.tasks.filter(task => task.status_id === status.id);
    },
    openAddTaskForm(statusId) 
    {
      this.newTaskForStatus = statusId;
    },
    closeAddTaskForm() 
    {
      this.newTaskForStatus = 0;
    },
    handleTaskAdded(newTask) 
    {
      // Find the index of the status where we should add the task
      const statusIndex = this.statuses.findIndex
      (
        status => status.id === newTask.status_id
      );

      // Add newly created task to our column
      this.statuses[statusIndex].tasks.push(newTask);

      // Reset and close the AddTaskForm
      this.closeAddTaskForm();
    },
    handleTaskMoved(evt) 
    {
      const task = evt.item; // get the task that was moved
      const newStatus = evt.to; // get the status column that the task was moved to

      // update the status_name of the task
      task.status_name = newStatus.title;

      // save the updated task to the server
      axios.put("/tasks/" + task.id, task).catch(err => {
        console.log(err.response);
      });


      // axios.put("/tasks/sync", { columns: this.statuses }).catch(err => 
      // {
      //   console.log(err.response);
      // });
    }
  }
};
</script>

<style scoped>
.status-drag {
  transition: transform 0.5s;
  transition-property: all;
}
</style>

