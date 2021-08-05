export default {
  namespaced: true,
  state: {
    top: [],
    teams: [],
    team: {}
  },

  mutations: {
    replaceTop (state, teams) {
      state.top = teams
    },
    replaceTeams (state, teams) {
      state.teams = teams
    },
    replaceTeam (state, team) {
      state.team = team
    }
  },

  getters: {
    top: state => state.top,
    teams: state => state.teams,
    team: state => state.team
  }
}
