/**
 * Created by Administrator on 2017/5/3.
 */
import * as types from './types'

export default{
  DOLOGIN: ({ commit }, data) => {
      commit(types.DOLOGIN, data)
  },
  DOLOGOUT: ({ commit }) => {
      commit(types.DOLOGOUT)
  },
  SETCONN : ({ commit }, conn) => {
      commit(types.SET_CONN, conn);
  },
  changeStatus: ({ commit }, status) => {
      commit(types.CHANGE_STATUS, status)
  },
  setUser : ({ commit }, user) => {
      if (user.id && user.avatar && user.nickname) {
          commit(types.SET_USER, user);
      }
  },
  addUser : ({ commit }, user) => {
      if (user instanceof Array || user.id && user.avatar && user.nickname) {
          commit(types.ADD_USER, user);
      }
  },
  removeUser : ({ commit }, userId) => {
      commit(types.REMOVE_USER, userId);
  },
  addMessage : ({ commit }, message) => {
      if (message.is_self != 1) {
          let userId = message.to == 0 ? 0 : message.from;

          commit(types.SET_HAS_MESSAGE,userId,true);
      }
      commit(types.ADD_MESSAGE,message);
  },

  setHasMessageStatus : ({ commit }, userId, status) => {
      commit(types.SET_HAS_MESSAGE, userId, status);
  },
  setCount : ({ commit }, count) => {
      commit(types.SET_COUNT, count);
  },
  showNotice : ({ commit }, msg, type) => {
      commit(types.SHOW_NOTICE, msg, type);
  },
  getFriendsList : ({ commit }, user_code) => {
      commit(types.GET_FRIENDLIST, user_code);
  },
  searchUser: ({ commit }, filterUser) => {
      commit(types.FILTER_USER, filterUser);
  },

  selectSession : ({ commit }, userId) => {
      commit(types.CHANGE_SESSION, userId);
  },

}
