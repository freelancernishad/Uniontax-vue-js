<template>
    <div class="modal" v-if="isVisible" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <slot name="header"></slot>
            <button type="button" class="btn-close" @click="$emit('close')"></button>
          </div>
          <div class="modal-body">
            <slot name="body"></slot>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="$emit('close')">Close</button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: ['isVisible'],
  };
  </script>
  
  <style scoped>
  .modal {
    display: block;
    background: rgba(0, 0, 0, 0.5);
  }
  .modal {
  overflow: auto;
}
  </style>
  