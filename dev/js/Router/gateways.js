export default [
  {
    name: 'Gateways',
    path: '/gateways',
    component: () => import('@/Pages/Gateways/Gateways'),
    children: [
      {
        name: "All Gateways",
        path: 'list',
        component: () => import('@/Pages/Gateways/GatewaysList'),

      },
      {
        name: "Gateway",
        path: '/gateway/:id',
        component: () => import('@/Pages/Gateways/Gateway/Gateway'),
      }
    ]
  }
]
