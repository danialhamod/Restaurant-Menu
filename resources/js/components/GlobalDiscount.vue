<template>
  <v-card class="discount-card">
      <v-card-title>
        Update All Menu Discount
        <v-spacer></v-spacer>
      </v-card-title>
      <v-card-text>
        <v-text-field label="Discount" v-model="editableItem.discount"></v-text-field>
        
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="update">Save</v-btn>
      </v-card-actions>
    </v-card>
</template>

<script>
import axios from 'axios';

export default {
  inject: ['showToast'],
  data: () => ({
    editableItem: {},
  }),
  mounted() {
    this.getGlobalDiscount()
  },
  methods: {
    getGlobalDiscount() {
      axios.get('/api/globalDiscount')
        .then(response => {
          this.editableItem.discount = response.data.content
        })
        .catch(error => {
          this.showToast(error);
        });
    },
    update() {
      this.loading = true;
      axios.post(`/api/globalDiscount/update`, this.editableItem)
        .then(() => {
          this.showToast('All menu discount has been saved!', true);
        })
        .catch(error => {
          this.showToast(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
}
</script>

<style>
.discount-card {
  max-width: 700px !important;
}
</style>


