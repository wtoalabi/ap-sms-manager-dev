export default {
  gateway_mutators(state, payload) {
    state.gateways.list = payload
    state.gateways.metaList = payload;
  }
}
