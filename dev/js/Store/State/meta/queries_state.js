export default {
  queries:{
    pagination: {
      queryPagination:{
        itemsPerPage: 2
      }
    },
    dateFilters:{
      filterByDate:{}
    },
    querySearch:{
      searchText: ''
    },
    queryFilterByRelationship:{
      filterByRelationship:{}
    },
    queryFilterByColumn:{
      filterByColumn:{}
    },
    customFilters:{
      filterByCategory:{}
    }
  },
  mergeAllQueries(){
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

