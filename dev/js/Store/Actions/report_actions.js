import Requests from "@/utils/forms/StatefulRequest";

export default {
  async loadReports(store, payload) {
    await Requests("reports", {
      action: "post",
      mergeQueries: true,
      store: store,
      showNotification: false,
      data: payload,
      state: "reports",
      showInnerLoading: true,
      mutator: "reports_mutators",
    })
  },
}
