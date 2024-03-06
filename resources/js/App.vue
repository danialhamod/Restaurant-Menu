<template>


  <v-app>

    <v-snackbar v-model="snackbar.show" :color="snackbar.color" timeout="6000" :bottom="true" :right="true">
        {{ snackbar.message }}
        <v-btn color="white" text @click="snackbar.show = false">Close</v-btn>
    </v-snackbar>
    
    <v-navigation-drawer app permanent>
      <!-- Logo -->
      <v-list-item class="px-2">
        <v-list-item-content>
          <v-img src="logo.png" contain class="align-start" height="70" aspect-ratio="1"></v-img>
        </v-list-item-content>
      </v-list-item>
      
      <v-list>
        <v-list-item v-for="(item, index) in [{icon: '', title: 'Categories'}, {icon: '', title: 'Items'}]" :key="index" link>
          <v-list-item-icon>
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- App Bar (Navbar) -->
    <v-app-bar app :color="`rgb(var(--v-theme-primary))`" dark>
      <v-toolbar-title>Restaurant Menu</v-toolbar-title>
    </v-app-bar>

    <!-- Main Content Area -->
    <v-main>
      <v-container>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>


<script>
export default {
  data: () => ({
    snackbar: {
      show: false,
      message: '',
      color: 'error',
    }
  })
}
</script>

<style>
.v-btn--icon {
  margin: 5px;
  cursor: pointer!important;
}


header {
  color: white!important;
}

.v-container {
  max-width: none!important;
}

.v-spacer {
  height: 20px;
}
</style>