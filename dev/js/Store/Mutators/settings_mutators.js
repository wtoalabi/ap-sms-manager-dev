export default {
  settingsMutators(state, payload) {
    state.settings = payload
  },
  setSettings(state, settings) {
    if (settings && settings.themeColors) {
      if (settings.themeColors.primaryColor) {
        state.settings.themeColors.primaryColor = settings.themeColors.primaryColor
      }
      if (settings.themeColors.secondaryColor) {
        state.settings.themeColors.secondaryColor = settings.themeColors.secondaryColor
      }
      if (settings.themeColors.successColor) {
        state.settings.themeColors.successColor = settings.themeColors.successColor
      }
      if (settings.themeColors.infoColor) {
        state.settings.themeColors.infoColor = settings.themeColors.infoColor
      }
      if (settings.themeColors.warningColor) {
        state.settings.themeColors.warningColor = settings.themeColors.warningColor
      }
      if (settings.themeColors.errorColor) {
        state.settings.themeColors.errorColor = settings.themeColors.errorColor
      }
      state.settings.reload++
    }else{
      state.settings.themeColors.errorColor = "#FF5252"
      state.settings.themeColors.warningColor = "#FFC107"
      state.settings.themeColors.primaryColor = "#1E88E5"
      state.settings.themeColors.secondaryColor = "#FAFAFA"
      state.settings.themeColors.successColor = "#4baf50"
      state.settings.themeColors.infoColor = "#1E88E5"
    }
  },
  resetSettings(state) {
    state.settings.themeColors.primaryColor = "#1E88E5"
    state.settings.themeColors.secondaryColor = "#FAFAFA"
    state.settings.themeColors.successColor = "#4baf50"
    state.settings.themeColors.warningColor = "#FFC107"
    state.settings.themeColors.errorColor = "#FF5252"
    state.settings.themeColors.infoColor = "#1E88E5"
    state.settings.reload++
  }
}
