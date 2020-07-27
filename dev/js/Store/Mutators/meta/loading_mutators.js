export default {
  commitMiniDrawer(state, payload) {
    state.miniDrawer = payload
  },
  setTitle({title}, payload) {
    title = payload;
    document.title = `${title} - AP SMS Manager`
  },
  startLoading(state, _) {
    state.loading = true;
  },
  stopLoading(state, _) {
    state.loading = false;
  },
  commitMetaData(state, payload) {
    state.groups.metaList = payload.groups;
    state.gateways.metaList = payload.gateways;
    state.contacts.contactSources = payload.sources;
    state.stats = payload.stats;
  },
  showNotification(state, payload) {
    let text, icon, type;
    if (payload[1] === 'error') {
      let errorMsg = payload[0]
      if (errorMsg) {
        text = errorMsg
      } else {
        text = "Error!"
      }
      icon = 'mdi-alert-circle'
      type = 'error'
    } else if (payload[1] === 'success') {
      let successMsg = payload[0]
      if (successMsg) {
        text = successMsg
      } else {
        text = "Successful!"
      }
      icon = 'mdi-check-all'
      type = 'success'
    }
    state.notifications = {text, icon, type}
    setTimeout(() => {
      state.notifications = {}
    }, 10000)
  },
}
