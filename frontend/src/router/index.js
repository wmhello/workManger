import Vue from 'vue'
import Router from 'vue-router'
const _import = require('./_import_' + process.env.NODE_ENV)
// in development env not use Lazy Loading,because Lazy Loading too many pages will cause webpack hot update too slow.so only in production use Lazy Loading

/* layout */
import Layout from '../views/layout/Layout'

Vue.use(Router)

/**
 * icon : the icon show in the sidebar
 * hidden : if `hidden:true` will not show in the sidebar
 * redirect : if `redirect:noredirect` will not redirct in the levelbar
 * noDropdown : if `noDropdown:true` will not has submenu in the sidebar
 * meta : `{ role: ['admin'] }`  will control the page role
 **/
export const constantRouterMap = [
  {
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
  }
]

export default new Router({
  mode: 'history',
  scrollBehavior: () => ({
    y: 0
  }),
  routes: constantRouterMap
})

export const asyncRouterMap = [
  // {
  //   path: '/example',
  //   component: Layout,
  //   redirect: 'noredirect',
  //   name: 'Example',
  //   icon: 'zujian',
  //   children: [
  //     { path: 'index', name: 'Form', icon: 'zonghe', component: _import('page/form') }
  //   ]
  // },

  // {
  //   path: '/table',
  //   component: Layout,
  //   redirect: '/table/index',
  //   icon: 'tubiao',
  //   noDropdown: true,
  //   children: [{ path: 'index', name: 'Table', component: _import('table/index'), meta: { role: ['admin'] }}]
  // },
  {
    path: '/admin',
    component: Layout,
    redirect: '/admin/index',
    icon: 'tubiao',
    name: '用户管理',
    meta: {
      role: ['admin']
    },
    children: [
      {
        path: 'index',
        name: '用户列表',
        component: _import('admin/Index'),
        meta: {
          role: ['admin']
        }
      },
      {
        path: 'new',
        name: '新增用户',
        component: _import('admin/New'),
        meta: {
          role: ['admin']
        }
      }
    ]
  },

  {
    path: '/role',
    component: Layout,
    redirect: '/role/index',
    icon: 'tubiao',
    name: '角色管理',
    meta: {
      role: ['admin']
    },
    children: [
      {
        path: 'index',
        name: '角色列表',
        component: _import('role/Index'),
        meta: {
          role: ['admin']
        }
      },
      {
        path: 'new',
        name: '新增角色',
        component: _import('role/New'),
        meta: {
          role: ['admin']
        }
      }
    ]
  },

  {
    path: '/teachmanage',
    component: Layout,
    redirect: '/teachmanage/session',
    icon: 'tubiao',
    name: '教学过程管理',
    meta: {
      role: ['admin']
    },
    children: [
      {
        path: 'session',
        name: '学期管理',
        component: _import('teachmanage/Session'),
        meta: {
          role: ['admin']
        }
      },
      {
        path: 'leader',
        name: '学校行政管理',
        component: _import('teachmanage/Leader'),
        meta: {
          role: ['admin']
        }
      },
      {
        path: 'classteacher',
        name: '班主任管理',
        component: _import('teachmanage/Classteacher'),
        meta: {
          role: ['admin']
        }
      },
      {
        path: 'department',
        name: '教研组长管理',
        component: _import('teachmanage/Department'),
        meta: {
          role: ['admin']
        }
      },
      {
        path: 'teaching',
        name: '教师代课管理',
        component: _import('teachmanage/Teaching'),
        meta: {
          role: ['admin']
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
