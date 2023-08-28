<template>
  <div class="flex flex-wrap">
    <div class="w-full text-center">
      <div ref="btnRef" v-on:mouseenter="toggleTooltip()" v-on:mouseleave="toggleTooltip()" class="ease-linear transition-all duration-150" type="button">
        <slot name="button"/>
      </div>
      <div ref="tooltipRef" v-bind:class="{'hidden': !tooltipShow, 'block': tooltipShow}" class="text-white bg-gray-800/70 ml-3 block z-50 font-normal leading-normal text-sm text-left no-underline break-words rounded-lg">
        <div>
          <div class="bg-gray-800 text-white text-center opacity-75 font-normal p-3 mb-0 uppercase rounded-lg w-56">
            <slot name="title"/>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

import { createPopper } from "@popperjs/core";

export default {
  name: "right-gray-tooltip",
  data() {
    return {
      tooltipShow: false
    }
  },
  methods: {
    toggleTooltip: function(){
      if(this.tooltipShow){
        this.tooltipShow = false;
      } else {
        this.tooltipShow = true;
        createPopper(this.$refs.btnRef, this.$refs.tooltipRef, {
          placement: "right"
        });
      }
    }
  }
}
</script>