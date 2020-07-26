import Requests from '@/utils/forms/StatefulRequest'

export default {
  async loadSettings(store) {
    if (_.isEmpty(store.state.settings)) {
      await Requests("settings", {
        action: "get",
        showInnerLoading: true,
        store: store,
        mutator: "settingsMutators"
      })
    }
  },
  async saveSettings(store,payload) {
    await Requests("save-settings", {
      action: "post",
      data:payload,
      showNotification: true,
      showInnerLoading: true,
      store: store,
      //mutator: "settingsMutators"
    })
  },
  async resetSettings(store) {
    let defaultSettings = store.state.settings
    console.log(defaultSettings)
    await Requests("save-settings", {
      action: "post",
      data:{'settings':defaultSettings},
      showNotification: true,
      showInnerLoading: true,
      store: store,
      //mutator: "settingsMutators"
    })
  }
}
