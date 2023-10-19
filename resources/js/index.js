import { createStore } from 'vuex';
import createPersistedState from 'vuex-persistedstate';

// 初期状態を取得する関数
function getDefaultState() {
    return {
        selectedPeriod: null,
    }
};

export default createStore({
    // 初期化
    state: getDefaultState(),
    mutations: {
        setSelectedPeriod(state, period) {
            state.selectedPeriod = period;
        },
        // ログアウト時に呼び出すミューテーション
        resetState(state) {
            // 状態を初期化
            Object.assign(state, getDefaultState());
        },
    },
    actions: {
        updateSelectedPeriod({ commit }, period) {
            commit('setSelectedPeriod', period);
        },
        // ログアウト時に呼び出すアクション
        resetState({ commit }) {
            commit('resetState');
            // ストレージからVuexの状態を削除
            window.sessionStorage.removeItem('vuex');
        },
    },
    plugins: [createPersistedState({ storage: window.sessionStorage,
        // ログアウト時にストレージからVuexの状態を削除
        filter(mutation) {
            return mutation.type !== 'resetState';
        },
    })],
});
