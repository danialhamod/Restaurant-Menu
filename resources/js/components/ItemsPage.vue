<template>
  <v-card>
      <v-card-title>
        Items
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="addItem()">Add New Item</v-btn>
      </v-card-title>
      <v-card-text>
        <v-data-table-server
          v-model:items-per-page="itemsPerPage"
          :headers="headers"
          :items="serverItems"
          :items-length="totalItems"
          :loading="loading"
          :search="search"
          item-value="name"
          @update:options="(options) => getItems(options)"
        >
          <template v-slot:item.actions="{ item }">
            <v-btn icon @click="editItem(item)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn icon @click="deleteItem(item)">
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>
        </v-data-table-server>
        
        <!-- Create Item Modal -->
        <v-dialog v-model="showCreateModal" max-width="600px">
          <v-card>
            <v-card-title>
              Add New Item
            </v-card-title>
            <v-card-text>
              <v-text-field label="Name" v-model="editableItem.name"></v-text-field>
              <v-text-field label="Price" v-model="editableItem.price"></v-text-field>
              <v-text-field label="Discount" v-model="editableItem.discount"></v-text-field>
              <v-select
                :items="categories"
                item-title="name"
                item-value="id"
                v-model="editableItem.category_id"
                label="Select Category"
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="showCreateModal = false">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="saveItem">Save</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <!-- Edit Item Modal -->
        <v-dialog v-model="showEditModal" max-width="600px">
          <v-card>
            <v-card-title>
              Edit Item
            </v-card-title>
            <v-card-text>
              <v-text-field label="Name" v-model="editableItem.name"></v-text-field>
              <v-text-field label="Price" v-model="editableItem.price"></v-text-field>
              <v-text-field label="Discount" v-model="editableItem.discount"></v-text-field>
              <v-select
                :items="categories"
                item-title="name"
                item-value="id"
                v-model="editableItem.category_id"
                label="Select Category"
              ></v-select>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="showEditModal = false">Cancel</v-btn>
              <v-btn color="blue darken-1" text @click="updateItem">Update</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-card-text>
    </v-card>
</template>

<script>
import axios from 'axios';
import { VDataTableServer } from 'vuetify/lib/components/index.mjs';

export default {
  inject: ['showToast'],
  data: () => ({
    itemsPerPage: 10,
    page: 1,
    headers: [
      { title: 'Name', align: 'start', sortable: false, key: 'name' },
      { title: 'Price', align: 'start', sortable: false, key: 'price', prefix: '$' },
      { title: 'Discount', key: 'discount', align: 'end', sortable: false },
      { title: 'Discounted Price', align: 'start', sortable: false, key: 'discounted_price', prefix: '$' },
      { title: 'Category', align: 'start', sortable: false, key: 'category_name' },
      { title: 'Created at', key: 'created_at', align: 'end', sortable: false },
      { title: 'Actions', key: 'actions', align: 'center', sortable: false },
    ],
    search: '',
    serverItems: [],
    loading: true,
    totalItems: 0,
    showCreateModal: false,
    showEditModal: false,
    editableItem: {},
    categories: []
  }),
  mounted() {
    this.getCategories()
  },
  methods: {
    getCategories() {
      axios.get('/api/categories?all=1')
        .then(response => {
          this.categories = response.data.content.data
        })
        .catch(error => {
          this.showToast(error);
        });
    },
    getItems(options) {
      this.loading = true;
      const page = options && options.page ? options.page : this.page;
      const itemsPerPage = options && options.itemsPerPage ? options.itemsPerPage : this.itemsPerPage;

      axios.get('/api/items', {
        params: {
          page: page,
          page_size: itemsPerPage,
        },
      })
        .then(response => {
          this.serverItems = response.data.content.data
          this.totalItems = response.data.content.total
          this.itemsPerPage = response.data.content.per_page;
          this.page = response.data.content.current_page;
          this.loading = false;
        })
        .catch(error => {
          this.loading = false;
          this.showToast(error);
        });
    },
    addItem() {
      this.editableItem = { };
      this.showCreateModal = true;
    },
    editItem(item) {
      this.editableItem = { ...item };
      this.showEditModal = true;
    },
    deleteItem(item) {
      if (confirm('Are you sure you want to delete this item?')) {
        this.loading = true;
        axios.post(`/api/items/delete/${item.id}`)
          .then(() => {
            this.getItems(); // Refresh list after deletion
          })
          .catch(error => {
            this.showToast(error);
          })
          .finally(() => {
            this.loading = false;
          });
      }
    },
    saveItem() {
      this.loading = true;
      axios.post('/api/items', this.editableItem)
        .then(() => {
          this.showCreateModal = false;
          this.getItems(); // Refresh list after saving
        })
        .catch(error => {
          this.showToast(error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    updateItem() {
      this.loading = true;
      axios.post(`/api/items/${this.editableItem.id}`, this.editableItem)
        .then(() => {
          this.showEditModal = false;
          this.getItems(); // Refresh list after update
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


