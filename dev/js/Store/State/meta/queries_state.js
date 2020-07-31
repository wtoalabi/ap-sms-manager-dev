export default {
    queries: {
        pagination: {
            queryPagination: {
                itemsPerPage: 2
            }
        },
        dateFilters: {
            filter_by_date: {}
        },
        querySearch: {
            searchText: ''
        },
        queryFilterByRelationship: {
            filter_by_relationship: {}
        },
        queryFilterByColumn: {
            filter_by_column: {}
        },
        customFilters: {
            filter_by_category: {}
        }
    },
    mergeAllQueries() {
        return {
            ...this.queries.pagination,
            ...this.queries.dateFilters,
            ...this.queries.querySearch,
            ...this.queries.queryFilterByRelationship,
            ...this.queries.queryFilterByColumn,
            ...this.queries.customFilters,
        }
    },
}

