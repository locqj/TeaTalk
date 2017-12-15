/**
 * Created by Administrator on 2017/5/3.
 */
import * as types from './types'

export default{
  DOLOGIN: ({commit}, data) => {
    commit(types.DOLOGIN, data)
  },
  DOLOGOUT: ({commit}) => {
    commit(types.DOLOGOUT)
  }
}

