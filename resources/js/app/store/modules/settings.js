const state = {
    pomidorDuration: null,
    shortRestDuration: null,
    longRestDuration: null,
    longRestViaCountPomidors: null,
    needSoundTimerFinished: null,
};

const mutations = {
    init: function (state, data) {
        state.pomidorDuration = data['pomidor_duration'];
        state.shortRestDuration = data['short_rest_duration'];
        state.longRestDuration = data['long_rest_duration'];
        state.longRestViaCountPomidors = data['long_rest_via_count_pomidors'];
        state.needSoundTimerFinished = data['need_sound_timer_finished'];
    },
};

const getters = {};

const actions = {};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
