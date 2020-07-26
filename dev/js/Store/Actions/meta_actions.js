import Requests from "@/utils/forms/StatefulRequest";

export default {
  async loadMeta(store){
    await Requests("meta", {
      action: "get",
      store: store,
      mutator: "commitMetaData",
      onSuccessCallback:(response)=>{
        store.commit("setSettings", response.body.settings)
      }
    })
  }
}
