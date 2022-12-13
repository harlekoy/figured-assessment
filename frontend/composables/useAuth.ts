import { head } from 'lodash-es'

const state = reactive({
  //
})

export default function () {
  const { $axios } = useNuxtApp()

  const validate = () => {
    return $axios.get('/sanctum/csrf-cookie')
  }

  return {
    ...toRefs(state),
    validate,
  }
}
