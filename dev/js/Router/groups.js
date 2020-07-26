export default [
  {
    name: 'Groups',
    path: '/groups',
    component: () => import('@/Pages/Groups/Groups'),
    children: [
      {
        name: "All Groups",
        path: 'list',
        component: () => import('@/Pages/Groups/GroupsList'),
        beforeEnter(to, from, next){
          next()
        }
      },
      {
        name: "Group",
        path: '/groups/:id',
        component: () => import('@/Pages/Groups/Group/Group'),
        /*beforeEnter(to, from, next){
            next()
        }*/
      }
    ]
  }
]
