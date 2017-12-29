import fetch from '@/utils/fetch'

export function getRole () {
  return fetch({
    url: '/api/role',
    method: 'get',
  })
}

export function getRoleById (id) {
  return fetch({
    url: '/api/role/' + id,
    method: 'get',
  })
}

export function updataRoleInfo (id, data) {
  return fetch({
    url: '/api/role/' + id,
    method: 'PATCH',
    params: {
      name: data.name,
      explain: data.explain,
      remark: data.remark
    },
    headers: {
      "Content-Type": "application/x-www-form-urlencoded"
    }
  })
}

export function deleteRoleById (id) {
  return fetch({
    url: '/api/role/' + id,
    method: 'delete',
  })
}

export function addNewRole (data) {
  return fetch({
    url: '/api/role',
    method: 'post',
    data,
  })
}
