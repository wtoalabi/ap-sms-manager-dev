import Requests from "@/utils/forms/StatefulRequest";

export default {
  async loadContacts(store) {

      await Requests("contacts", {
        action: "post",
        store: store,
        state:"contacts",
        showInnerLoading: true,
        mutator: "contact_mutators"
      })
    },
  async moveContacts(store, payload) {
    let groupID = payload[0];
    let contactsIDs = payload[1].map(contact=>contact.id);
    await Requests("move-contacts", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: {groupID, contactsIDs},
      state: "contacts",
      showInnerLoading: true,
      mutator: "contact_mutators",
      onSuccessCallback:()=>{
        store.commit("resetContacts")
      }
    })
  },

  async saveContacts(store, payload) {
    await Requests("save-contacts", {
      action: "post",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "contacts",
      showInnerLoading: true,
      mutator: "contact_mutators",
      onSuccessCallback:()=>{
        store.commit("toggleSavedContactsFlag", true)
      }
    })
  },
  async syncContacts(store, payload) {
    await Requests("sync-contacts", {
      action: "post",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "contacts",
      showInnerLoading: true,
      mutator: "contact_mutators",
      onSuccessCallback:()=>{
        store.commit("toggleSavedContactsFlag", true)
      }
    })
  },
  async updateContact(store, payload) {
    await Requests("contacts", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "contacts",
      showInnerLoading: true,
      mutator: "contact_mutators",
    })
  },
  async deleteContacts(store, payload) {
    let ids = payload.map(contact=>contact.id)
    await Requests("delete-contacts", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: ids,
      state: "contacts",
      showInnerLoading: true,
      mutator: "contact_mutators"
    })
  },
}
