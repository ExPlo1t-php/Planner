<template>
  <div>
    <button
      @click="toggleCollapse"
      :class="['flex items-center space-x-3 text-black w-full bg-white p-8 justify-between', { 'collapsed': !isOpen }]"
      :aria-expanded="isOpen"
      :aria-controls="collapseId"
    >
      <slot name="title" />
      <svg
        class="w-3 transition-all duration-200 transform"
        :class="{
          'rotate-180': isOpen,
          'rotate-0': !isOpen,
        }"
        fill="none"
        stroke="currentColor"
        xmlns="http://www.w3.org/2000/svg"
        viewBox="0 0 16 10"
        aria-hidden="true"
      >
        <path
          d="M15 1.2l-7 7-7-7"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        />
      </svg>
    </button>

    <div class="ml-2 border-l-2" v-show="isOpen" :id="collapseId">
      <slot name="content" />
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      isOpen: false,
      collapseId: 'collapse_' + this._uid,
    };
  },
  props: {
    uniqueKey: String, // Pass a unique key as a prop
  },
  methods: {
    toggleCollapse() {
      this.isOpen = !this.isOpen;
      localStorage.setItem('accordionState_' + this.uniqueKey, JSON.stringify(this.isOpen));
    },
  },
  computed: {
    collapseId() {
      return 'collapse_' + this.uniqueKey;
    },
  },
  created() {
    const accordionState = localStorage.getItem('accordionState_' + this.uniqueKey);
    this.isOpen = accordionState ? JSON.parse(accordionState) : false;
  },
};
</script>

<style>
.collapsed .rotate-180 {
  transform: rotate(180deg);
}

/* Add CSS transitions for smoother animations */
.transition-all {
  transition: all 0.3s ease-in-out;
}
</style>
