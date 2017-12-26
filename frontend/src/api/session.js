import fetch from '@/utils/fetch'

export function getTeach() {
  return fetch({
    url: '/api/session',
    method: 'get'
  })
}

export function getTeachById(id) {
  return fetch({
    url: '/api/session/' + id,
    method: 'get'
  })
}

export function updataTeachInfo(id, data) {
  return fetch({
    url: '/api/session/' + id,
    method: 'patch',
    params: {
      year: data.year,
      team: data.team,
      one: data.one,
      two: data.two,
      three: data.three
    },
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
}

export function addNewTeach(data) {
  return fetch({
    url: '/api/session',
    method: 'post',
    data,
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    }
  })
}

export function deletTeachById(id) {
  return fetch({
    url: '/api/session/' + id,
    method: 'delete'
  })
}
