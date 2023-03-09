import { createRouter, createWebHistory } from "vue-router";
import Index from "../components/Index.vue"
import Home from "../components/Users/Home.vue"
import OrdersComponents from "../components/Users/Manage/OrdersComponents.vue"
import NewOrdersComponents from "../components/Users/Manage/NewOrdersComponents.vue"
import AddNewProductsComponenets from "../components/Users/Manage/AddNewProductsComponenets.vue"
import HistoryComponents from "../components/Users/Manage/HistoryComponents.vue"
import ManageProductsComponents from "../components/Users/Manage/ManageProductsComponents.vue"
import HomeManageProductComponents from "../components/Users/Manage/HomeManageProductComponents.vue"

const routes = [
    {
        path: '/',
        component: Home,
        
    },
    {
        path: '/orders/:ordersId',
        component: OrdersComponents,
        params: true
    },
    {
        path: '/create_orders',
        component: NewOrdersComponents
    },
    {
        path: '/addnewproducts',
        component: AddNewProductsComponenets
    },
    {
        path: '/history',
        component: HistoryComponents
    },
    {
        path: '/manageproduct',
        component: ManageProductsComponents
    },
    {
        path: '/home_manageproduct',
        component: HomeManageProductComponents
    },
]

const router = createRouter({
    history: createWebHistory(process.env.BASE_URL),
    routes
})


// router.beforeEach((to, from, next) => {
//     if (to.matched.some(record => record.meta.requiresAuth)) {
//       // check if user is authenticated
//       if (!isAuthenticated()) {
//         next({
//           path: '/',
//           query: { redirect: to.fullPath }
//         })
//       } else {
//         next()
//       }
//     } else {
//       next()
//     }
//   })

export default router