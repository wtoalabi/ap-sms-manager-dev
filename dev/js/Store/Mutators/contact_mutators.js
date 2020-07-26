export default {
  updatedSelectedContacts(state, payload) {
    state.contacts.selectedContacts = payload
  },
  selectAllContacts(state) {
    state.contacts.selectAllContacts = true
  },
  contact_mutators(state, payload){
    state.contacts.list = payload
  },
  resetContacts(state){
    state.contacts.selectedContacts = []
  },
  toggleSavedContactsFlag(state, flag=false){
    state.contacts.contactsSaved = flag;
    state.notifications = {}
  }
}
