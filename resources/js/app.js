require('./bootstrap');
import axios from 'axios'
import Vue from 'vue'

import BootstrapVue from 'bootstrap-vue'

window._token = document.head.querySelector('meta[name="csrf-token"]').content


import App from './MainApp'
import VueRouter from 'vue-router'
import Container from './Container'
import StudentList from './components/StudentList.vue'
import StudentForm from './components/StudentForm.vue'
import { ValidationObserver, ValidationProvider } from 'vee-validate'
import './vendor/vee-validate'

Vue.use(BootstrapVue)
Vue.use(VueRouter)

Vue.component("ValidationProvider", ValidationProvider)
Vue.component("ValidationObserver", ValidationObserver)

export const createApp = () => {
  Vue.prototype.$app = window.settings
  Vue.prototype.$http = axios
  Vue.prototype.$app.route = window.route

  /**
   * Object to FormData converter
   */
  let objectToFormData = (obj, form, namespace) => {
    let fd = form || new FormData()

    for (let property in obj) {
      if (!obj.hasOwnProperty(property)) {
        continue
      }

      let formKey = namespace ? `${namespace}[${property}]` : property

      if (obj[property] === null) {
        fd.append(formKey, '')
        continue
      }
      if (typeof obj[property] === 'boolean') {
        fd.append(formKey, obj[property] ? '1' : '0')
        continue
      }
      if (obj[property] instanceof Date) {
        fd.append(formKey, obj[property].toISOString())
        continue
      }
      if (
        typeof obj[property] === 'object' &&
        !(obj[property] instanceof File)
      ) {
        objectToFormData(obj[property], fd, formKey)
        continue
      }
      fd.append(formKey, obj[property])
    }

    return fd
  }

  Vue.prototype.$app.objectToFormData = objectToFormData

  const routes = [
    {
      path: '/',
      component: Container,
      children: [
        {
          path: '/',
          name: 'student-list',
          component: StudentList,
        },
        {
          path: '/student/add',
          name: 'student-add',
          component: StudentForm,
        },
        {
          path: '/student/:id/update',
          name: 'student-update',
          props: true,
          component: StudentForm,
        },
        {
          path: '/student/:id/detail',
          name: 'student-detail',
          props: true,
          component: StudentForm,
        },
      ],
    },
  ]

  const router = new VueRouter({
    mode: 'history',
    base: '',
    scrollBehavior: () => ({ y: 0, x: 0 }),
    routes
  })

  const app = new Vue({
    router,
    render: h => h(App)
  })

  return {
    app,
    router
  }
}

if (document.getElementById('app')) {
  const { app } = createApp()
  app.$mount('#app')
}
