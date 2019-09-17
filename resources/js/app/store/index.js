import Vue from 'vue'
import Vuex from 'vuex'
import tasks from './modules/tasks'
import settings from './modules/settings'
import plugins from './plugins'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        tasks,
        settings,
    },
    state: {
        isVerifiedUser: false,
    },
    mutations: {
        setVerifiedUser: function (state, isVerifiedUser) {
            state.isVerifiedUser = isVerifiedUser;
        }
    },
    // Can't use plugins in modules, so use global plugin: https://github.com/vuejs/vuex/issues/467
    plugins: [
        plugins,
    ],
    strict: true,
})
