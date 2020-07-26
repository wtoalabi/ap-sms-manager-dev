export default {
  group_mutators(state, payload) {
    state.groups.list = payload;
    state.groups.metaList = payload
  },
}
