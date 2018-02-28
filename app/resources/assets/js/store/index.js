const STORAGE_KEY = 'simple-store';

import Vue from 'vue';
import Vuex from 'vuex';
import * as types from './mutation-types';

Vue.use(Vuex);
const state = {
    // restore state from local storage
    basket: JSON.parse(window.localStorage.getItem(STORAGE_KEY) || '[]'),
};

// actions
const actions = {
    addToCart({commit}, info) {
        commit(types.ADD_TO_CART, info);
        // Saving to localStorage but we can save data to DB. It's just a simple app. That's why we using localStorage :)
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify(state.basket))
    },
    clearCart({commit}) {
        commit(types.CLEAR_CART);
        window.localStorage.setItem(STORAGE_KEY, JSON.stringify(state.basket))
    }
};

const getters = {
    count: state => {
        return Number(state.basket.reduce((previousValue, currentValue) => {
            return Number(previousValue) + Number(currentValue.quantity);
        }, 0));

    },
    basket: state => {
        return state.basket;
    }
};

// mutations
const mutations = {
    [types.ADD_TO_CART](state, {product, quantity}) {
        const record = state.basket.find(p => p.id === product.id);
        if (!record) {
            state.basket.push({
                id: product.id,
                name: product.name,
                real_price: product.real_price,
                quantity: quantity,
            })
        } else {
            record.quantity = Number(record.quantity) + Number(quantity);
        }
    },
    [types.CLEAR_CART](state) {
        state.basket = [];
    }
};

export default new Vuex.Store({
    state: state,
    actions: actions,
    mutations: mutations,
    getters: getters,
})
