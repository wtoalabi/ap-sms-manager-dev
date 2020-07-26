export default [
  {
    name: 'Contacts',
    path: '/contacts',
    component: () => import('@/Pages/Contacts/Contacts'),
    children: [
      {
        name: "All Contacts",
        path: 'list',
        component: () => import('@/Pages/Contacts/ContactsList'),

      },
      {
        name: "Contact",
        path: '/contacts/:id',
        component: () => import('@/Pages/Contacts/Contact/Contact'),
      }
    ]
  }
]
