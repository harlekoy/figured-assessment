<script setup>
  const { items } = useItems()
</script>
<template>
<div>
  <ApplyForm />
  <div v-if="items.length" class="sm:max-w-md mx-auto space-y-4">
    <AppliedTotal />
    <AppliedSummary />
  </div>
</div>
</template>
