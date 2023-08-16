<template>
    <div>
      <div
        v-for="(item, index) in items"
        :key="index"
        class="accordion-item"
        @click="toggleItem(index)"
      >
        <div class="accordion-title">
          {{ item.title }}
        </div>
        <div
          v-if="item.expanded"
          class="accordion-content"
        >
          {{ item.content }}
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        items: [
          {
            title: 'Accordion Item 1',
            content: 'Content for Item 1',
            expanded: false,
          },
          {
            title: 'Accordion Item 2',
            content: 'Content for Item 2',
            expanded: false,
          },
          // Add more items as needed
        ],
      };
    },
    methods: {
      toggleItem(index) {
        this.items[index].expanded = !this.items[index].expanded;
      },
    },
  };
  </script>

  