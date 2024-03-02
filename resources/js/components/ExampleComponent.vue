<template>
    <div>
      <p v-if="user">Hello, {{ user.name }}!</p>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        user: null,
      };
    },
    mounted() {
      this.getCurrentUser();
    },
    methods: {
      getCurrentUser() {
        axios.get('/api/user')
          .then(response => {
            this.user = response.data;
          })
          .catch(error => {
            console.error("There was an error fetching the user data:", error);
          });
      }
    }
  }
  </script>
  