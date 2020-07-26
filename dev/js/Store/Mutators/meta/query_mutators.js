export default {
  /* Call after a table query option (sortBy, etc) is called*/
  setQueryOptions(state, payload) {
    state.queries.pagination.queryPagination = payload
    let existing = state.queries.pagination.queryPagination;
    existing.sortBy = payload['sortBy'];
    existing.sortDesc = payload['sortDesc'];
    state.queries.pagination.queryPagination = existing;
  },
  /*Called after every successful AJAX call, to set the incoming pagination.*/
  setQueryPagination(state, payload) {
    let pagination = payload[0]
    let objectState = payload[1]
    let existing = state.queries.pagination.queryPagination;
    state.queries.pagination.queryPagination = Object.assign(existing, pagination)
    if (objectState) {
      state[objectState]['rowsNumber'] = pagination['rowsNumber']
    }
  },
  setFilterByDate(state, payload) {
    state.queries.pagination.queryPagination.sortBy = 'dateAdded';
    state.queries.pagination.queryPagination.sortDesc = false;
    let existing = state.queries.dateFilters['filterByDate'];
    return state.queries.dateFilters['filterByDate'] = Object.assign(existing, payload);

  },
  setQuerySearchArray(state, payload) {
    let searchColumn = payload[0];
    let searchValue = payload[1];
    state.queries.querySearch = {"filterBySearch":[searchColumn, searchValue]}
  },
  setQueryFilterByColumn(state, payload) {
    return state.queries.queryFilterByColumn.filterByColumn[payload[0]] = payload[1]
  },
  setQueryFilterByBirthday(state, payload) {
    return state.queries.queryFilterByColumn.filterByBirthday = payload
  },
    setQueryFilterByRelationship(state, payload) {
    return state.queries.queryFilterByRelationship.filterByRelationship = payload
  },
  commitCustomFilter(state, payload) {
    //return state.queries.customFilters = payload
  },
  resetQueryState(state) {
    state.queries.pagination.queryPagination = {
      'sortBy': null,
      'page': 1,
    };
    state.queries.dateFilters.filterByDate = {};
    state.queries.querySearch = {};
    state.queries.queryFilterByColumn.filterByColumn = {};
    state.queries.queryFilterByRelationship.filterByRelationship = {};
    /*:{
        filterByRelationship:{}
    },*/
  },
  resetSearchQueries(state) {
    state.queries.querySearch = {};
    state.queries.queryFilterByRelationship.filterByRelationship = []
  }
}
