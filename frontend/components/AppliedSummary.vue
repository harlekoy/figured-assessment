<script setup>
  import { get, sumBy } from 'lodash-es'

  const { summary } = useItems()

  const unitPrice = (collection) => {
    return get(collection, '0.price')
  }

  const total = (collection) => {
    return sumBy(collection, 'price')
  }
</script>
<template>
<div class="overflow-hidden bg-white shadow sm:rounded-lg">
  <div class="px-4 py-5 sm:px-6">
    <h3 class="text-lg font-medium leading-6 text-gray-900">Summary</h3>
    <p class="mt-1 max-w-2xl text-sm text-gray-500">Item details and application.</p>
  </div>
  <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
    <dl class="sm:divide-y sm:divide-gray-200">
      <div v-for="(group, index) in summary" class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
          <span class="font-bold text-lg">${{ total(group) }}</span> <span class="text-gray-500 text-sm">(${{ unitPrice(group) }}/unit)</span>
        </dd>
        <dt class="text-sm font-medium text-gray-500 flex item-center"><span class="bg-slate-500 text-white py-1 px-2 rounded-full">X{{ group.length }}</span></dt>
      </div>
      <!-- <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5 sm:px-6">
        <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
          <span class="font-bold text-lg">$18</span> <span class="text-gray-500 text-xs">($4.5/unit)</span>
        </dd>
        <dt class="text-sm font-medium text-gray-500 flex item-center"><span class="bg-slate-500 text-white py-1 px-2 rounded-full">X4</span></dt>
      </div> -->
    </dl>
  </div>
</div>
</template>
