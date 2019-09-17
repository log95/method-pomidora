<template>
    <tr :class="{'task-in-edit': isEditing}">
        <td class="task-title-column-wrapper">
            <span
                @dblclick="startEditTask('task-edit-title')"
                class="task-title"
            >
                {{ task.title }}
            </span>
            <input
                class="task-edit-title form-control"
                :placeholder="taskTitlePlaceholder"
                :value="task.title"
                v-on:keyup.enter="finishEditTask"
                v-on:keyup.esc="cancelEditTask"
            >
        </td>
        <td class="task-description-column-wrapper">
            <span
                @dblclick="startEditTask('task-edit-description')"
                class="task-description"
            >
                {{ task.description  }}
            </span>
            <input
                class="task-edit-description form-control"
                :placeholder="taskDescriptionPlaceholder"
                :value="task.description"
                v-on:keyup.enter="finishEditTask"
                v-on:keyup.esc="cancelEditTask"
            >
        </td>
        <td class="task-actions-column-wrapper">
            <div class="dropdown">
                <button class="btn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu">

                    <template v-if="!isEditing">

                        <template v-if="!task.completed">
                            <button
                                @click="markTaskCompleted"
                                class="dropdown-item"
                                type="button"
                            >
                                <i class="fa fa-check"></i>
                                {{ completeTaskMess }}
                            </button>
                        </template>

                        <button
                            @click="startEditTask('task-edit-title')"
                            class="dropdown-item"
                            type="button"
                        >
                            <i class="fa fa-edit"></i>
                            {{ editTaskMess }}
                        </button>

                        <button
                            @click="removeTask"
                            class="dropdown-item"
                            type="button"
                        >
                            <i class="fa fa-trash"></i>
                            {{ removeTaskMess }}
                        </button>

                    </template>
                    <template v-else>

                        <button
                            @click="finishEditTask"
                            class="dropdown-item"
                            type="button"
                        >
                            <i class="fa fa-check"></i>
                            {{ applyMess }}
                        </button>
                        <button
                            @click="cancelEditTask"
                            class="dropdown-item"
                            type="button"
                        >
                            <i class="fa fa-window-close"></i>
                            {{ cancelMess }}
                        </button>

                    </template>
                </div>
            </div>
        </td>
    </tr>
</template>

<script>
    export default {
        data: function() {
            return {
                isEditing: false,

                // Localized messages
                taskTitlePlaceholder: transMessages['TASK_TITLE_PLACEHOLDER'],
                taskDescriptionPlaceholder: transMessages['TASK_DESCRIPTION_PLACEHOLDER'],
                completeTaskMess: transMessages['COMPLETE_TASK'],
                editTaskMess: transMessages['EDIT_TASK'],
                removeTaskMess: transMessages['REMOVE_TASK'],
                applyMess: transMessages['APPLY'],
                cancelMess: transMessages['CANCEL'],
            };
        },
        props: [
            'task',
        ],
        methods: {
            startEditTask: function (elementClassNameForFocus) {
                this.isEditing = true;

                let self = this;
                setTimeout(function () {
                    self.$el.getElementsByClassName(elementClassNameForFocus)[0].focus();
                }, 100);
            },
            finishEditTask: function () {
                let newTitle = this.$el.getElementsByClassName('task-edit-title')[0].value.trim();
                let newDescription = this.$el.getElementsByClassName('task-edit-description')[0].value.trim();

                if (newTitle === '' && newDescription === '') {
                    this.$emit(
                        'showNotification',
                        transMessages['TASK_INVALID_DATA_TITLE'],
                        transMessages['TASK_INVALID_DATA_DESC']
                    );
                } else {
                    this.$store.commit('tasks/editTask', {
                        'id': this.task['id'],
                        'backendId': this.task['backendId'],
                        'title': newTitle,
                        'description': newDescription,
                    });

                    this.isEditing = false;
                }
            },
            cancelEditTask: function () {
                this.isEditing = false;

                this.$el.getElementsByClassName('task-edit-description')[0].value = this.task.description;
                this.$el.getElementsByClassName('task-edit-title')[0].value = this.task.title;
            },
            markTaskCompleted: function () {
                this.$store.commit('tasks/markTaskCompleted', this.task);
            },
            removeTask: function () {
                this.$store.commit('tasks/removeTask', this.task);
            },
        },
    };
</script>
