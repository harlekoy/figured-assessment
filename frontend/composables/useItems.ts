import { sumBy, groupBy } from 'lodash-es'

const state = reactive({
  items: [],
})

export default function () {
  const { $axios } = useNuxtApp()

  const apply = async (quantity) => {
    const { data: response } = await $axios.post('/api/apply-units', {
      quantity
    })

    state.items = response.data
  }

  const clear = () => {
    state.items = []
  }

  const total = computed(() => {
    return sumBy(state.items, 'price')
  })

  const summary = computed(() => {
    return groupBy(state.items, 'price')
  })

  return {
    ...toRefs(state),
    apply,
    total,
    summary,
    clear
  }
}
