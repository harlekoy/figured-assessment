<script setup>
  const { apply, clear } = useItems()
  const quantity = ref(null)
  const error = ref('')
  const loading = ref(false)

  const submit = async () => {
    try {
        error.value = ''
        loading.value = true

        await apply(quantity.value)
        quantity.value = null
    } catch ({ response }) {
        clear()
        error.value = response.data.message
    }

    loading.value = false
  }
</script>
<template>
  <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <img class="mx-auto h-12 w-auto" src="https://www.figured.com/hubfs/Figured_October2019/Images/figured-logo.png" alt="Your Company">
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <form @submit.prevent="submit()" class="space-y-6" action="#" method="POST">
          <div>
            <label for="quantity" class="block text-sm font-medium text-gray-700">How many products do you want to apply?</label>
            <div class="mt-1">
              <input id="quantity" name="quantity" type="number" v-model="quantity" required class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-slate-500 focus:outline-none focus:ring-slate-500 sm:text-sm"
              :class="{
                'border-red-300': error
              }">
            </div>
            <p v-if="error" class="mt-2 text-sm text-red-600" id="applied-error">{{ error }}</p>
          </div>

          <div>
            <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-slate-600 py-2 px-4 text-sm font-bold text-white shadow-sm hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 uppercase tracking-widest disabled:bg-slate-500" :disabled="loading">
            <Loader v-if="loading" /> Apply
          </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
