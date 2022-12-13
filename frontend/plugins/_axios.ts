import axios from 'axios'

export default defineNuxtPlugin(() => {
  const config = useRuntimeConfig()

  const instance = axios.create({
    withCredentials: true,
    baseURL: config.public.API_URL,
  })

  instance.interceptors.request.use((config) => {
    if (['post', 'put', 'delete'].includes(config.method)) {
      const token = useCookie('XSRF-TOKEN')
      const { validate } = useAuth()

      if (! token.value) {
        return validate().then(response => config)
      }
    }

    return config
  })

  return {
    provide: {
      axios: instance
    }
  }
})
