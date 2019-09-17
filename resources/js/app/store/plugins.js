import backend from '../api/backend'

function updateActiveTasksLocalStorage(tasks) {
    localStorage.setItem('ACTIVE_TASKS', JSON.stringify(tasks));
}

export default function (store) {
    store.subscribe(function (mutation, state) {
        switch (mutation.type) {

            // Handle add task, only if it's not init process to avoid duplicates in backend and rewriting local storage.
            // After init process "addTask" is called only for active tasks.
            case 'tasks/addTask':
                if (!state.tasks.isInitProcess) {
                    updateActiveTasksLocalStorage(store.getters['tasks/activeTasks']);
                }
                break;

            case 'tasks/editTask':
                if (mutation.payload.completed === false) {
                    updateActiveTasksLocalStorage(store.getters['tasks/activeTasks']);
                } else if (mutation.payload.backendId) {
                    backend.updateCompletedTask(mutation.payload)
                        .catch((e) => {
                            console.log(e);
                        });
                }
                break;

            // Store completed tasks in backend, if user is authorized and verified.
            case 'tasks/markTaskCompleted':
                updateActiveTasksLocalStorage(store.getters['tasks/activeTasks']);

                if (state.isVerifiedUser) {
                    backend.addCompletedTask(mutation.payload)
                        .then((idBackendTask) => {
                            store.commit('tasks/setTaskBackendId', {
                                idTask: mutation.payload.id,
                                taskBackendId: idBackendTask,
                            });
                        })
                        .catch((e) => {
                            console.log(e);
                        });
                }
                break;

            case 'tasks/removeTask':
                if (mutation.payload.completed === false) {
                    updateActiveTasksLocalStorage(store.getters['tasks/activeTasks']);
                } else if (mutation.payload.backendId) {
                    backend.removeCompletedTask(mutation.payload.backendId)
                        .catch((e) => {
                            console.log(e);
                        });
                }
                break;
        }
    });
}
