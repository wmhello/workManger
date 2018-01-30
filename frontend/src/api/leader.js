import fetch from '@/utils/fetch'

export function getLeader (current_page) {
  return fetch({
    url: '/api/leader',
    method: 'get',
    params: {
      page: current_page,
    },
  })
}

export function getLeaderById (id) {
  return fetch({
    url: '/api/leader/' + id,
    method: 'get'
  })
}

export function updateLeaderInfo (id, data) {
  return fetch({
    url: '/api/leader/' + id,
    method: 'patch',
    data: {
      teacher_id: data.teacher_id,
      leader_type: data.leader_type,
      job: data.job,
      remark: data.remark
    }
  })
}

export function addNewLeader (data) {
  return fetch({
    url: '/api/leader',
    method: 'post',
    data,
  })
}

export function deleteLeaderById (id) {
  return fetch({
    url: '/api/leader/' + id,
    method: 'delete'
  })
}
