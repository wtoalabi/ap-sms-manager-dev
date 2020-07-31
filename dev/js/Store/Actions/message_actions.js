import Requests from "@/utils/forms/StatefulRequest";

export default {
  async sendSMS(store, payload) {
    store.commit("toggle_message_is_sending", true)
    await Requests("send-sms", {
      action: "post",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "reports",
      showInnerLoading: true,
      mutator: "reports_mutators",
      onSuccessCallback:()=>{
        store.commit("toggle_message_is_sending")
      }
    })
  },
}
