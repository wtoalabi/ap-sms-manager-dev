export default [
  {
    name: 'Messages',
    path: '/messages',
    component: () => import('@/Pages/Messages/Messages'),
    children: [
      {
        name: "All Messages",
        path: 'list',
        component: () => import('@/Pages/Messages/MessagesList'),

      },
      {
        name: "Message",
        path: '/message/:id',
        component: () => import('@/Pages/Messages/Message/Message'),
      }
    ]
  }
]
