<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps(["buttonId", "modals", "payload"]);
const loadItem = (payload)=>{
    if(props.modals.includes(payload)){
        return 1
    }else{
        props.modals.push(payload);
        return 0
    }
}
onMounted(() => {
  loadItem(props.payload)
});
</script>
<template>
    <div>
      <div
        @click="onToggle(buttonId)"
        class=" flex justify-center items-center hover:bg-gray-200 h-20 "
      >
        <slot name="button"/>
    </div>
  
      <transition name="fade" v-for="modal in modals" :key="modal.id">
        <div v-if="modal.isOpen">
          <div
            @keydown.esc="onToggle(modal.id)"
            class="absolute bg-black/70 inset-0 z-[100] w-full top-0 overflow-auto"
          >
          <div class="bg-white h-fit m-10 rounded-md">
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Gestion Planning
                </h3>
                <button class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" @click="onToggle(modal.id)">
                  <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                  </svg>
                  <span class="sr-only">Close modal</span>
                </button>
            </div>
            <br>
            <div class="p-6 space-y-6">
              <slot name="content"/>
            </div>
          </div>
        </div>
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
            payload: {
                type: Object
            }
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
  