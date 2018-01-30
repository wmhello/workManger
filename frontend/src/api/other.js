import fetch from '@/utils/fetch'

export function getSession () {
  return fetch({
    url: '/api/getSession',
    method: 'get',
  })
}

export function getTeach () {
  return fetch({
    url: '/api/getTeach',
    method: 'get',
  })
}

export function getTeacher () {
  return fetch({
    url: '/api/getTeacher',
    method: 'get',
  })
}

export function getDefaultSession () {
  return fetch({
    url: '/api/getDefaultSession',
    method: 'get',
  })
}


