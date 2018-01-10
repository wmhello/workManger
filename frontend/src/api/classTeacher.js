import fetch from '@/utils/fetch'

export function getClassTeacher (current_page) {
  return fetch({
    url: '/api/classTeacher',
    method: 'get',
    params: {
      page: current_page,
    },
  })
}

export function getClassTeacherById (id) {
  return fetch({
    url: '/api/classTeacher/' + id,
    method: 'get'
  })
}

export function updateClassTeacherInfo (id, data) {
  return fetch({
    url: '/api/classTeacher/' + id,
    method: 'patch',
    data: {
      session_id: data.session_id,
      teacher_id: data.teacher_id,
      class: data.class,
      grade: data.grade,
      remark: data.remark
    }
  })
}

export function addNewClassTeacher (data) {
  return fetch({
    url: '/api/classTeacher',
    method: 'post',
    data
  })
}

export function deleteClassTeacherById (id) {
  return fetch({
    url: '/api/classTeacher/' + id,
    method: 'delete'
  })
}
