import Requests from "@/utils/forms/StatefulRequest";

export default {
  async loadGroups(store) {
    await Requests("groups", {
      action: "post",
      store: store,
      state: "groups",
      showNotification: false,
      showInnerLoading: true,
      mutator: "group_mutators"
    })
  },
  async addGroup(store, payload) {
    await Requests("save-group", {
      action: "post",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "groups",
      showInnerLoading: true,
      mutator: "group_mutators",
    })
  },
  async updateGroup(store, payload) {
    await Requests("groups", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: payload,
      state: "groups",
      showInnerLoading: true,
      mutator: "group_mutators",
    })
  },
  async deleteGroup(store, payload) {
    let ids = payload.map(group=>group.id)
    await Requests("delete-groups", {
      action: "patch",
      mergeQueries: false,
      store: store,
      showNotification: true,
      data: {group_ids: ids},
      state: "groups",
      showInnerLoading: true,
      mutator: "group_mutators"
    })
  },
}
