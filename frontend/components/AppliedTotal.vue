<script setup>
  const { total } = useItems()
</script>
<template>
  <div class="rounded-md bg-green-50 border-4 border-green-600 p-4">
    <div class="flex item-center">
      <div class="ml-3 flex-1 md:flex justify-center">
        <p class="text-xl text-green-600"><span class="text-3xl font-bold">${{ total }}</span> in total requested</p>
      </div>
    </div>
  </div>
</template>
