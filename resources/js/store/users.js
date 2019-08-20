
export const STORAGE_KEY = 'USUARIOS'
import UserService from '../services/users.js';
import moment from 'moment';
import p from '../utils.js';

const state = {
    users: [{}],
    loading: false,
    usersFormat:[],
}

const getters = {
    users (state) {
        return state.users
    },
    usersFormat(){
      return state.usersFormat
    },
    loading (state) {
        return state.loading
    },
}

const mutations = {
    SET_USER (state, value){
        state.users = value
    },
    SET_USER_FORMAT(state, value){
        state.usersFormat = value
    },
    SET_LOADING_STATUS (state, value) {
        state.loading = value
    },
}

const actions = {

  async initUsers({commit,dispatch}){
      const rs= await UserService.getAll();
      dispatch('getUsersFormat');
      commit('SET_USER',rs.data.data);
  },
  async getUsersAll({commit}, query){
      const rs= await UserService.getAll(query);
      commit('SET_USER',rs.data.data);
  },
  async getUsersFormat({commit,dispatch},query){
    const rs= await UserService.getAll(query);
    commit('SET_USER_FORMAT', p.select2Fortmat(rs.data.data));
  },

}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}
