// import Vue from 'vue'
// import Router from 'vue-router'
// const _import = require('./_import_' + process.env.NODE_ENV)
// // in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading

// /* layout */
// import Layout from '../views/layout/Layout'

// Vue.use(Router)

// /**
//  * icon : the icon show in the sidebar
//  * hidden : if `hidden:true` will not show in the sidebar
//  * redirect : if `redirect:noredirect` will not redirct in the levelbar
//  * noDropdown : if `noDropdown:true` will not has submenu in the sidebar
//  * meta : `{ role: ['admin'] }`  will control the page role
//  **/
// export const constantRouterMap = [
//   {
//     path: '/login',
//     component: _import('login/index'),
//     hidden: true
//   },
//   {
//     path: '/404',
//     component: _import('404'),
//     hidden: true
//   },
//   {
//     path: '/',
//     component: Layout,
//     redirect: '/dashboard',
//     name: 'Dashboard',
//     hidden: true,
//     children: [{
//       path: 'dashboard',
//       component: _import('dashboard/index')
//     }]
//   }
// ]

// export default new Router({
//   mode: 'history',
//   scrollBehavior: () => ({
//     y: 0
//   }),
//   routes: constantRouterMap
// })

import Vue from 'vue'
import Router from 'vue-router'
const _import = require('./_import_' + process.env.NODE_ENV)
// in development-env not use lazy-loading, because lazy-loading too many pages will cause webpack hot update too slow. so only in production use lazy-loading;
// detail: https://panjiachen.github.io/vue-element-admin-site/#/lazy-loading

Vue.use(Router)

/* Layout */
import Layout from '../views/layout/Layout'

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* redirect: noredirect           if `redirect:noredirect` will no redirct in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    title: 'title'               the name show in submenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar,
  }
**/
export const constantRouterMap = [{
    path: '/login',
    component: _import('login/index'),
    hidden: true
  },
  {
    path: '/404',
    component: _import('404'),
    hidden: true
  },

  {
    path: '/',
    component: Layout,
    redirect: '/dashboard',
    name: 'Dashboard',
    hidden: true,
    children: [{
      path: 'dashboard',
      component: _import('dashboard/index')
    }]
  },

  {
    path: '*',
    redirect: '/404',
    hidden: true
  }
]

export default new Router({
  mode: 'history', //后端支持可开
  scrollBehavior: () => ({
    y: 0
  }),
  routes: constantRouterMap
})


export const asyncRouterMap = [
  {
    path: '/admin',
    component: Layout,
    redirect: '/admin/index',
    name: 'admin',
    meta: {
      role: ['admin'],
      icon: 'user',
      title: '用户管理'
    },
    children: [
      {
        path: 'index',
        name: 'admin/index',
        component: _import('admin/Index'),
        meta: {
          role: ['admin'],
          title: '用户列表',
          icon: 'table'
        }
      },
      {
        path: 'new',
        name: 'admin/new',
        component: _import('admin/New'),
        meta: {
          role: ['admin'],
          title: '新增用户',
          icon: 'a'
        }
      }
    ]
  },

  {
    path: '/role',
    component: Layout,
    redirect: '/role/index',
    name: 'role',
    meta: {
      role: ['admin'],
      icon: 'tab',
      title: '角色管理',
    },
    children: [
      {
        path: 'index',
        name: 'role/index',
        component: _import('role/Index'),
        meta: {
          role: ['admin'],
          title: '角色列表',
          icon: 'table'
        }
      },
      {
        path: 'new',
        name: 'role/new',
        component: _import('role/New'),
        meta: {
          role: ['admin'],
          title: '新增角色',
          icon: 'wujiaoxing'
        }
      }
    ]
  },

  {
    path: '/teachmanage',
    component: Layout,
    redirect: '/teachmanage/session',
    name: 'teachermanage',
    meta: {
      role: ['admin'],
      icon: 'tubiao',
      title: '教学过程管理'
    },
    children: [
      {
        path: 'session',
        name: 'teachermanage/session',
        component: _import('teachmanage/Session'),
        meta: {
          role: ['admin'],
          title: '学期管理',
          icon: 'zonghe'
        }
      },
      {
        path: 'leader',
        name: 'teachermanage/leader',
        component: _import('teachmanage/Leader'),
        meta: {
          role: ['admin'],
          title: '学校行政管理',
          icon: 'zujian'
        }
      },
      {
        path: 'classteacher',
        name: 'teachermanage/classteacher',
        component: _import('teachmanage/Classteacher'),
        meta: {
          role: ['admin'],
          title: '班主任管理',
          icon: 'EXCEL'
        }
      },
      {
        path: 'department',
        name: 'teachmanage/department',
        component: _import('teachmanage/Department'),
        meta: {
          role: ['admin'],
          title: '教研组长管理',
          icon: 'shouce'
        }
      },
      {
        path: 'teaching',
        name: 'teachmanage/teaching',
        component: _import('teachmanage/Teaching'),
        meta: {
          role: ['admin'],
          title: '教师代课管理',
          icon: 'quanxian'
        }
      }
    ]
  },
  {
    path: '*',
    redirect: '/404',
    hidden: true
  }
]

// export const asyncRouterMap = [{
//     path: '/admin',
//     component: Layout,
//     redirect: '/admin/index',
//     icon: 'tubiao',
//     name: '用户管理',
//     meta: {
//       role: ['admin'],

//     },
//     children: [{
//         path: 'index',
//         name: '用户列表',
//         component: _import('admin/Index'),
//         meta: {
//           role: ['admin']
//         }
//       },
//       {
//         path: 'new',
//         name: '新增用户',
//         component: _import('admin/New'),
//         meta: {
//           role: ['admin']
//         }
//       }
//     ]
//   },

//   {
//     path: '/role',
//     component: Layout,
//     redirect: '/role/index',
//     icon: 'tubiao',
//     name: '角色管理',
//     meta: {
//       role: ['admin']
//     },
//     children: [{
//         path: 'index',
//         name: '角色列表',
//         component: _import('role/Index'),
//         meta: {
//           role: ['admin']
//         }
//       },
//       {
//         path: 'new',
//         name: '新增角色',
//         component: _import('role/New'),
//         meta: {
//           role: ['admin']
//         }
//       }
//     ]
//   },

//   {
//     path: '/teachmanage',
//     component: Layout,
//     redirect: '/teachmanage/session',
//     icon: 'tubiao',
//     name: '教学过程管理',
//     meta: {
//       role: ['admin']
//     },
//     children: [{
//         path: 'session',
//         name: '学期管理',
//         component: _import('teachmanage/Session'),
//         meta: {
//           role: ['admin']
//         }
//       },
//       {
//         path: 'leader',
//         name: '学校行政管理',
//         component: _import('teachmanage/Leader'),
//         meta: {
//           role: ['admin']
//         }
//       },
//       {
//         path: 'classteacher',
//         name: '班主任管理',
//         component: _import('teachmanage/Classteacher'),
//         meta: {
//           role: ['admin']
//         }
//       },
//       {
//         path: 'department',
//         name: '教研组长管理',
//         component: _import('teachmanage/Department'),
//         meta: {
//           role: ['admin']
//         }
//       },
//       {
//         path: 'teaching',
//         name: '教师代课管理',
//         component: _import('teachmanage/Teaching'),
//         meta: {
//           role: ['admin']
//         }
//       }
//     ]
//   },
//   {
//     path: '*',
//     redirect: '/404',
//     hidden: true
//   }
// ]

