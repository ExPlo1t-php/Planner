<template>
    <div>
      <div class="grid-stack">
        <VueDraggable v-for="item in items" :key="item.id" :element="item">
            <template #item>
                <div class="grid-stack-item">
                    <div class="grid-stack-item-content bg-red-800">
                        {{ item.content }}
                    </div>
                </div>
            </template>
        </VueDraggable>
      </div>
    </div>
  </template>
  
  <script>
   import VueDraggable from 'vuedraggable';
  import 'gridstack/dist/gridstack.min.css';
  import { GridStack } from 'gridstack';
  
  export default {
    props: {
      items: Array,
    },
    components: {
     VueDraggable,
   },
    mounted() {
      const grid = GridStack.init();
      // Load the items into the grid
      this.items.forEach(item => {
        grid.addWidget({
          x: item.x,
          y: item.y,
          width: item.width,
          height: item.height,
          content: item.content
        });
      });
    },
  };
  </script>