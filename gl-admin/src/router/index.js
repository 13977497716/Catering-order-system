import Vue from 'vue'
import VueRouter from 'vue-router'



import sou from '../views/Sou.vue'//管理员界面（主）
import kou from '../views/Kou.vue'//订单前台

Vue.use(VueRouter)

const routes = [

  {
    path: '/',
    redirect:'/home'
  },

  {
    path: '/home',
    component:()=>import('@/views/Home/home')
  },
  
  
  {
    path: '/sou/:img?',
    component:sou,
    children: [
      {
        path: 'dishes/:url?',
        component: ()=>import('@/views/Dishes/dishes')
      },
      {
        path: 'dishesds/:url?',
        component: ()=>import('@/views/Dishesds/dishesds')
      },
      {
        path: 'order/:url?',
        component: ()=>import('@/views/Order/order')
      },
      {
        path: 'userAdmin/:url?',
        component: ()=>import('@/views/UserAdmin/userAdmin')
      },
      {
        path: 'stat/:url?',
        component: ()=>import('@/views/Stat/stat')
      },
    ]
  },

  {
    path:'/kou/:img?',
    component:kou

  },

  // 404
  {
    path:'*',
    component:()=>import('@/views/404/404')
  }
  
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})


router.beforeEach((to,from,next) =>{
  if(to.path == '/'|| to.path == '/home') return next();
   
  var tokensr=window.sessionStorage.getItem('token')
   if(!tokensr) return next('/');
  next()

})


export default router





// Vue.use(VueRouter);

// const originalPush = VueRouter.prototype.push
// VueRouter.prototype.push = function push(location) {
//   return originalPush.call(this, location).catch(err => err)
// }
