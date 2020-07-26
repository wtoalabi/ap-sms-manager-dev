export default {
  settingsMutators(state, payload) {
    state.settings = payload
  },
  setSettings(state, settings) {
    if (settings.themeColors) {
      if (settings.themeColors.primaryColor) {
        state.settings.themeColors.primaryColor = settings.themeColors.primaryColor
      } else {
        state.settings.themeColors.primaryColor = "#1E88E5"
      }
      if (settings.themeColors.secondaryColor) {
        state.settings.themeColors.secondaryColor = settings.themeColors.secondaryColor
      } else {
        state.settings.themeColors.secondaryColor = "#FAFAFA"
      }
      if (settings.themeColors.successColor) {
        state.settings.themeColors.successColor = settings.themeColors.successColor
      } else {
        state.settings.themeColors.successColor = "#4baf50"
      }
      if (settings.themeColors.infoColor) {
        state.settings.themeColors.infoColor = settings.themeColors.infoColor
      } else {
        state.settings.themeColors.infoColor = "#1E88E5"
      }
      if (settings.themeColors.warningColor) {
        state.settings.themeColors.warningColor = settings.themeColors.warningColor
      } else {
        state.settings.themeColors.warningColor = "#FFC107"
      }
      if (settings.themeColors.errorColor) {
        state.settings.themeColors.errorColor = settings.themeColors.errorColor
      } else {
        state.settings.themeColors.errorColor = "#FF5252"
      }
      state.settings.reload++
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
