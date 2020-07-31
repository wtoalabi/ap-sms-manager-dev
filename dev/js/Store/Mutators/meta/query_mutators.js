export default {
    /* Call after a table query option (sort_by, etc) is called*/
    setQueryOptions(state, payload) {
        state.queries.pagination.queryPagination = payload
        let existing = state.queries.pagination.queryPagination;
        existing.sort_by = payload['sort_by'];
        existing.sort_desc = payload['sort_desc'];
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
        state.queries.pagination.queryPagination.sort_by = 'date_added';
        state.queries.pagination.queryPagination.sort_desc = false;
        let existing = state.queries.dateFilters['filter_by_date'];
        return state.queries.dateFilters['filter_by_date'] = Object.assign(existing, payload);

    },
    setQuerySearchArray(state, payload) {
        let searchColumn = payload[0];
        let searchValue = payload[1];
        state.queries.querySearch = {"filter_by_search": [searchColumn, searchValue]}
    },
    setQueryFilterByColumn(state, payload) {
        return state.queries.queryFilterByColumn.filter_by_column[payload[0]] = payload[1]
    },
    setQueryFilterByBirthday(state, payload) {
        return state.queries.queryFilterByColumn.filter_by_birthday = payload
    },
    setQueryFilterByRelationship(state, payload) {
        return state.queries.queryFilterByRelationship.filter_by_relationship = payload
    },
    commitCustomFilter(state, payload) {
        //return state.queries.customFilters = payload
    },
    resetPageNumber(state){
        state.queries.pagination.queryPagination.page =  1;
    },
    resetQueryState(state) {
        state.queries.pagination.queryPagination = {
            'sort_by': null,
            'page': 1
        };
        state.queries.dateFilters.filter_by_date = {};
        state.queries.querySearch = {};
        state.queries.queryFilterByColumn.filter_by_column = {};
        state.queries.queryFilterByRelationship.filter_by_relationship = {};
        /*:{
            filter_by_relationship:{}
        },*/
    },
    resetSearchQueries(state) {
        state.queries.querySearch = {};
        state.queries.queryFilterByRelationship.filter_by_relationship = []
    }
}
