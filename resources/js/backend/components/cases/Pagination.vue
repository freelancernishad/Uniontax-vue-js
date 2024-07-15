<template>
    <nav aria-label="Page navigation">
      <ul class="pagination justify-content-center">
        <li class="page-item" :class="{ disabled: currentPage === 1 }">
          <a class="page-link" @click="changePage(currentPage - 1)">Previous</a>
        </li>
        <li class="page-item" v-for="page in totalPages" :key="page" :class="{ active: page === currentPage }">
          <a class="page-link" @click="changePage(page)">{{ page }}</a>
        </li>
        <li class="page-item" :class="{ disabled: currentPage === totalPages }">
          <a class="page-link" @click="changePage(currentPage + 1)">Next</a>
        </li>
      </ul>
    </nav>
  </template>
  
  <script>
  export default {
    props: ['currentPage', 'total', 'perPage'],
    computed: {
      totalPages() {
        return Math.ceil(this.total / this.perPage);
      },
    },
    methods: {
      changePage(page) {
        this.$emit('page-changed', page);
      },
    },
  };
  </script>
  