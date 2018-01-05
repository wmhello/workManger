import fetch from '@/utils/fetch'

export function getAdmin() {
  return fetch({
    url: '/api/admin',
    method: 'get',
  })
}

export function getCurrentPage(current_page) {
  return fetch({
    url: '/api/admin',
    method: 'get',
    params: {
      page: current_page,
    },
  })
}

export function getAdminById(id) {
  return fetch({
    url: '/api/admin/' + id,
    method: 'get',
  })
}

export function resetAdminByPsw(id, password) {
  return fetch({
    url: '/api/admin/' + id + '/reset',
    method: 'post',
    data: {
      password
    }
  })
}

export function uploadAdminByImg(data) {
  return fetch({
    url: '/api/admin/upload',
    method: 'post',
    data,
    headers: {
      'Content-Type': 'multipart/form-data'
    }
  })
}

export function updataAdminInfo(id, data) {
  return fetch({
    url: '/api/admin/' + id,
    method: 'put',
    params: {
      name: data.name,
      role: data.role,
      avatar: data.avatar
    },
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
}

export function deletAdminById(id) {
  return fetch({
    url: '/api/admin/' + id,
    method: 'delete',
  })
}

export function addNewAdmin(data) {
  return fetch({
    url: '/api/admin',
    method: 'post',
    data,
  })
}