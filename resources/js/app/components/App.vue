<template>
    <div id="app" class="container" v-cloak>

        <Tracking></Tracking>

        <div class="form-row new-task">

            <div class="col-lg-2 col-md-3 col-sm-4">
                <input
                    id="task-title"
                    class="form-control"
                    v-model="newTaskTitle"
                    v-on:keyup.enter="addTask"
                    autocomplete="off"
                    :placeholder="taskTitlePlaceholder"
                >
            </div>

            <div class="col-lg-4 col-md-5 col-sm-7">
                <input
                    id="task-description"
                    class="form-control"
                    v-model="newTaskDescription"
                    v-on:keyup.enter="addTask"
                    autocomplete="off"
                    :placeholder="taskDescriptionPlaceholder"
                >
            </div>

            <div class="col-lg-1 col-md-2 col-sm-1">
                <button v-on:click="addTask" class="btn" :title="addTaskPlaceholder">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

        <div class="float-right">
            <button
                type="button"
                class="btn btn-link btn-sm"
                :class="{'active-task-filter': activeTaskFilter === 'active'}"
                @click="setActiveTaskFilter('active')"
            >
                {{ activeTasksMess }}
            </button>
            <button
                type="button"
                class="btn btn-link btn-sm"
                :class="{'active-task-filter': activeTaskFilter === 'completed'}"
                @click="setActiveTaskFilter('completed')"
            >
                {{ completedTodayMess }}
            </button>
        </div>
        <table class="table table-hover table-sm">
            <tbody>
            <Task
                v-for="(task, index) in filteredTasks"
                :key="index"
                :task="task"
                @showNotification="showNotification"
            >
            </Task>
            </tbody>
        </table>

        <blockquote class="blockquote blockquote-pomidoro">
            <p class="mb-0">{{ pomidorQuoteMess }}</p>
            <footer class="blockquote-footer"><a href="https://ru.wikipedia.org/wiki/Метод_помидора"><cite title="wikipedia.org">wikipedia.org</cite></a></footer>
        </blockquote>

        <!-- Modal -->
        <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" id="appModal" aria-labelledby="appModal" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body"></div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
    import Task from './Task.vue'
    import Tracking from './Tracking.vue'
    import { mapGetters } from 'vuex';

    export default {
        data: function () {
            return {
                newTaskTitle: '',
                newTaskDescription: '',

                taskTitlePlaceholder: transMessages['TASK_TITLE_PLACEHOLDER'],
                taskDescriptionPlaceholder: transMessages['TASK_DESCRIPTION_PLACEHOLDER'],
                addTaskPlaceholder: transMessages['ADD_TASK_PLACEHOLDER'],
                activeTasksMess: transMessages['ACTIVE_TASKS'],
                completedTodayMess: transMessages['COMPLETED_TASKS_TODAY'],
                pomidorQuoteMess: transMessages['POMIDOR_QUOTE'],
            };
        },
        computed: {
            activeTaskFilter: function () {
                return this.$store.state.tasks['activeTaskFilter'];
            },
            ...mapGetters({
                filteredTasks: 'tasks/filteredTasks',
            }),
        },
        methods: {
            addTask: function () {
                this.newTaskTitle = this.newTaskTitle.trim();
                this.newTaskDescription = this.newTaskDescription.trim();

                if (this.newTaskTitle === '' && this.newTaskDescription === '') {
                    this.showNotification(
                        transMessages['TASK_INVALID_DATA_TITLE'],
                        transMessages['TASK_INVALID_DATA_DESC']
                    );
                } else {
                    this.$store.commit('tasks/addTask', {
                        'title': this.newTaskTitle,
                        'description': this.newTaskDescription,
                        'completed': false,
                    });

                    this.newTaskTitle = '';
                    this.newTaskDescription = '';
                }
            },
            setActiveTaskFilter: function(filter) {
                this.$store.commit('tasks/setActiveTaskFilter', filter);
            },
            showNotification: function (title, description) {
                $('#appModal .modal-title').text(title);
                $('#appModal .modal-body').text(description);
                $('#appModal').modal();
            }
        },
        components: {
            Task,
            Tracking,
        },
    }
</script>
