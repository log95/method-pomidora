
// Frontend next task id.
let nextTaskId = 1;

// Can't use getters in mutations, so make separate function.
function getIndexTaskById(tasks, idTask) {
    for (let i = 0; i < tasks.length; i++) {
        if (idTask === tasks[i]['id']) {
            return i;
        }
    }

    return null;
}



const state = {
    // All tasks: active and completed.
    tasks: [],
    activeTaskFilter: 'active', // active or completed
    isInitProcess: true,
};

const getters = {
    filteredTasks: function (state, getters) {
        return state.activeTaskFilter === 'active' ? getters.activeTasks : getters.completedTasks;
    },
    activeTasks: function (state) {
        return state.tasks.filter(function (task) {
            return !task.completed;
        });
    },
    completedTasks: function (state) {
        return state.tasks.filter(function (task) {
            return task.completed;
        });
    },
};

const actions = {
    /**
     * Active tasks stores only in local storage.
     * @param context
     */
    initActiveTasks (context) {
        let activeTasks = JSON.parse(localStorage.getItem('ACTIVE_TASKS'));
        if (activeTasks == null) {
            activeTasks = [];
        }

        activeTasks.forEach(function (task) {
            context.commit('addTask', {
                backendId: null,
                title: task['title'],
                description: task['description'],
                completed: false,
            });
        });
    },
    /**
     * Completed tasks stores only in backend.
     * @param context
     * @param data
     */
    initCompletedTasks (context, data) {
        data.tasks.forEach(function (task) {
            context.commit('addTask', {
                backendId: task['id'],
                title: task['title'],
                description: task['description'],
                completed: true,
            });
        });
    },
};

const mutations = {
    /**
     * Add active or completed task.
     * @param state
     * @param task
     */
    addTask: function (state, task) {
        state.tasks.push({
            id: nextTaskId++,
            backendId: task['backendId'] || null,
            title: task['title'],
            description: task['description'],
            completed: task['completed'],
        });
    },
    editTask: function (state, task) {
        let indexTask = getIndexTaskById(state.tasks, task['id']);
        if (indexTask != null) {
            state.tasks[indexTask]['title'] = task['title'];
            state.tasks[indexTask]['description'] = task['description'];
        }
    },
    removeTask: function (state, task) {
        let indexTask = getIndexTaskById(state.tasks, task['id']);
        if (indexTask != null) {
            state.tasks.splice(indexTask, 1);
        }
    },
    markTaskCompleted: function  (state, task) {
        let indexTask = getIndexTaskById(state.tasks, task['id']);
        if (indexTask != null) {
            state.tasks[indexTask]['completed'] = true;
        }
    },
    setTaskBackendId: function (state, data) {
        let indexTask = getIndexTaskById(state.tasks, data.idTask);
        if (indexTask != null) {
            state.tasks[indexTask]['backendId'] = data.taskBackendId;
        }
    },
    setActiveTaskFilter: function (state, filter) {
        state.activeTaskFilter = filter;
    },
    endInitProcess: function (state) {
        state.isInitProcess = false;
    },
};


export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
