<template>
    <div>
      <button
        @click="onToggle(buttonId)"
        class="bg-purple-500 border border-purple-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-md hover:shadow-lg hover:bg-purple-600"
      >
        <slot name="button"/>
      </button>
  
      <transition name="fade" v-for="modal in modals" :key="modal.id">
        <div v-if="modal.isOpen">
          <div
            @click="onToggle(modal.id)"
            class="absolute bg-black opacity-70 inset-0 z-0"
          ></div>
          <slot name="content"/>
        </div>
      </transition>
    </div>
  </template>
  <script>
    export default {
        props: {
            buttonId:{
                type:Number
            },
            modals:{
                type: Array
            },
        },
        methods: {
            onToggle(modalId) {
                const modal = this.modals.find(modal => modal.id === modalId);
                if (modal) {
                modal.isOpen = !modal.isOpen;
                }
            }
        },

    }
</script>
  