import State from './State'

export default {
  collectTop () {
    return State.store.getters['teams/top']
  },

  collectTeams () {
    return State.store.getters['teams/teams']
  },

  collectTeam () {
    return State.store.getters['teams/team']
  },

  replaceTop (teams) {
    State.store.commit('teams/replaceTop', teams)
  },

  replaceTeams (teams) {
    State.store.commit('teams/replaceTeams', teams)
  },

  replaceTeam (team) {
    State.store.commit('teams/replaceTeam', team)
  }
}
