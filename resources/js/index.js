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
            // mutationsのresetStateを実行
            commit('resetState');
            // ストレージからVuexの状態を削除
            window.sessionStorage.removeItem('vuex');
        },
    },
    plugins: [createPersistedState({ storage: window.sessionStorage })],
    // stateのリセットのみmutationsから直接実行の場合、resetState以外のmutationの結果を永続化
    // plugins: [createPersistedState({ storage: window.sessionStorage,
    //     filter(mutation) {
    //         return mutation.type !== 'resetState';
    //     },
    // })],
});
