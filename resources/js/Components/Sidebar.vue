<template>
  <section
    :class="{
      'w-[16rem]': !collapsed,
      'w-[1.7rem]': collapsed,
      'bg-gray-300': !collapsed,
      'bg-transparent': collapsed,
      'text-white': !collapsed,
      'text-transparent': collapsed,
      'border-trr rounded-tr-[13px] rounded-br-[13px]': !collapsed,
      'border-none': collapsed,
      'p-[0.5em]': !collapsed,
      'p-0': collapsed,
      'transition-all ease duration-300': true,
      'flex flex-col': true,
    }"
    class="fixed top-0 left-0 bottom-0 z-0"
  >
  <button v-if="!collapsed" @click="closeSidebar" class="text-gray-700 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center">
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
      <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
    </svg>
    <span class="sr-only">Close modal</span>
  </button>
  <span @click="toggleSidebar" v-if="collapsed" class="text-black cursor-pointer p-2 bg-gray-300 h-full">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
      </svg>
    </span>
    <template v-if="!collapsed">
      <slot/>
    </template>
  </section>
</template>

<script>
export default {
  props: {
    collapsed: Boolean,
  },
  methods: {
    toggleSidebar() {
      this.$emit('toggle-sidebar', !this.collapsed);
    },
    closeSidebar() {
      this.$emit('toggle-sidebar', true);
    },
  },
};
</script>
