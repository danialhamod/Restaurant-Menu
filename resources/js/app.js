
import {createRouter, createWebHashHistory} from 'vue-router'
import {createApp} from 'vue'
import App from './App.vue'
import HomePage from './components/HomePage.vue'
import AboutPage from './components/AboutPage.vue'
import { VAlert, VApp, VBtn, VCard, VCardActions, VCardText, VCardTitle, VDataTableServer, VDialog, VIcon, VSelect } from 'vuetify/components';
import vuetify from "./vuetify";

// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
  { path: '/', component: HomePage },
  { path: '/about', component: AboutPage },
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
  // 4. Provide the history implementation to use. We
  // are using the hash history for simplicity here.
  history: createWebHashHistory(),
  routes, // short for `routes: routes`
})

// 5. Create and mount the root instance.
const app = createApp(App)
// Make sure to _use_ the router instance to make the
// whole app router-aware.
app.use(router)
app.use(vuetify);

app.component('v-app', VApp)
app.component('v-data-table-server', VDataTableServer)
app.component('v-card-title', VCardTitle)
app.component('v-alert', VAlert)
app.component('v-card', VCard)
app.component('v-card-text', VCardText)
app.component('v-icon', VIcon)
app.component('v-btn', VBtn)
app.component('v-card-actions', VCardActions)
app.component('v-dialog', VDialog)
app.component('v-select', VSelect)

app.mount('#app')

// Now the app has started!
