import App from './app/components/App.vue'
import store from './app/store'
import backend from './app/api/backend'


const app = new Vue({
    store,
    render: h => h(App),
});


backend.getInitData()
    .then(function (initData) {
        store.commit('setVerifiedUser', initData.isVerifiedUser);

        store.commit('settings/init', initData.settings);

        store.dispatch('tasks/initActiveTasks');

        store.dispatch('tasks/initCompletedTasks', {
            tasks: initData.completedTasks
        });

        store.commit('tasks/endInitProcess');

        app.$mount('#app');
    });
