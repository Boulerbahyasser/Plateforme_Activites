<template>
  <div class="main-container">
    <!-- En-tête -->
    <nav class="navbar">
      <div class="menu-icon">
        <button @click="toggleSidebar" class="btn-custom">
          <i class="fas fa-bars"></i> BIENVENUE
        </button>
      </div>
      <div class="logout-btn">
        <button @click="logout" class="btn-custom btn-danger">Déconnexion</button>
      </div>
    </nav>

    <!-- Sidebar Component, shown only if isSidebarOpen is true -->
    <transition name="slide">
      <sidebar v-if="isSidebarOpen"></sidebar>
    </transition>
    <div class="main-container" :class="{ 'sidebar-open': isSidebarOpen }">
    <TopOffers></TopOffers>
    </div>
  </div>
</template>


<script>
import Sidebar from '@/components/ADMIN/sidebar.vue'; // Make sure the path is correct
import TopOffers from '@/components/ADMIN/TopOffers.vue';
export default {
  name: 'AdminPage',
  components: {
    Sidebar ,// Make sure the component is registered correctly
    TopOffers
  },
  data() {
    return {
      isSidebarOpen: false, // Controls the display of the sidebar
      showProfileMenu: false // Controls the display of the profile menu
    };
  },
  methods: {
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
    logout() {
      this.$router.push('/signin');
    }
  }
};
</script>
<style scoped>
.main-container {
  display: flex;
  flex-direction: column;
  height: 100vh;
  overflow: hidden;
}

.navbar {
  display: flex;
  justify-content: space-between;
  padding: 0.5rem 1rem;
  background-color: #0056b3;
  color: #fff;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.btn-custom {
  border: none;
  padding: 8px 16px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-custom.btn-danger {
  background-color: #ff6b6b;
}

.btn-custom:hover {
  background-color: #004495;
}

.btn-custom.btn-danger:hover {
  background-color: #ff3b3b;
}

.menu-icon i {
  margin-right: 5px;
}

/* Transition pour le sidebar */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease;
}

.slide-enter, .slide-leave-to /* Nom de classe pour la version 2.1.8+ */ {
  transform: translateX(-100%);
}

/* Amélioration de la visibilité et de l'esthétique */
.offers-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1rem;
  padding: 1rem;
}

.offer {
  transition: box-shadow 0.3s;
}

.offer:hover {
  box-shadow: 0 12px 24px rgba(0,0,0,0.2);
}

.sidebar {
  width: 250px;
  background-color: #f4f4f4;
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 1000;
  transform: translateX(-100%);
  transition: transform 0.3s ease-out;
} 
</style>

