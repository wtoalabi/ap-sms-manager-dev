import Requests from "@/utils/forms/StatefulRequest";

export default {
  async loadGateways(store) {
    await Requests("list-gateways", {
      action: "post",
      store: store,
      state: "gateways",
      showInnerLoading: true,
      mutator: "gateway_mutators"
    })
  },
  async addGateway(store, payload) {
    await Requests("save-gateways", {
      action: "post",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "gateways",
      showInnerLoading: true,
      mutator: "gateway_mutators",
    })
  },
  async updateGateway(store, payload) {
    await Requests("gateways", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "gateways",
      showInnerLoading: true,
      mutator: "gateway_mutators",
    })
  },
  async deleteGateway(store, payload) {
    let ids = payload.map(gateway=>gateway.id)
    await Requests("delete-gateways", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: {gateway_ids: ids},
      state: "gateways",
      showInnerLoading: true,
      mutator: "gateway_mutators"
    })
  },
}
