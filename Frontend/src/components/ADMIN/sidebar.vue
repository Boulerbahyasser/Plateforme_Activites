<template>
  <div class="app-container">
    <!-- Sidebar -->
    <aside :class="{ 'closed': !isSidebarOpen }" class="sidebar">
      <div class="flex justify-end">
        <button @click="closeSidebar">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <div class="profil-button"><i class="fa-solid fa-user">  Profil</i>
      </div>
      
      <nav>
        <ul>
          <li v-for="(option, index) in opciones" :key="index" class="option-with-dropdown">
            <div class="flex items-center justify-between p-3 hover:bg-gray-700 bg-[#1da1f2] text-white" @click="toggleDropdown(index)">
              <div class="flex items-center">
               
                <span>{{ option.title }}</span>
              </div>
              <i class="fas fa-chevron-down text-xs"></i>
            </div>
            <ul v-show="option.isActive" class="ml-3">
              <li v-for="item in option.items" :key="item.label">
                <router-link :to="item.path" class="block p-2 hover:bg-gray-700 flex items-center bg-[#1da1f2] text-white">
                  <i :class="item.icon" class="mr-3"></i>
                  {{ item.label }}
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
    </aside>
    
    <!-- Main Content Area where page content will be injected -->
    <main class="content">
      <slot></slot>
      <router-view></router-view>
    </main>
  </div>
</template>

<script>
export default {
  name: 'BaseLayout',
  data() {
    return {
      isSidebarOpen: true,
      opciones: [
        { title: 'Mes Offres', items: [{ label: 'liste des offres',icon: 'fas fa-list-alt', path: '/OffersListAdmin' }, { label: 'ajouter offre', path: '/AjouterOffre',icon:'fas fa-plus-circle' }], isActive: false },
        { title: 'Mes activites', items: [{ label: 'liste des activites', path: '/ActivitylistAdmin' ,icon:'fas fa-tasks'}, { label: 'ajouter une activite', path: '/AjouterActivite' ,icon:'fas fa-calendar-plus'}], isActive: false },
        { title: 'Demandes', items: [{ label: 'liste des activites', path: '/' ,icon:'fas fa-tasks'}, { label: 'ajouter une activite', path: '/AjouterActivite' ,icon:'fas fa-calendar-plus'}], isActive: false },
        { title: 'Animateurs', items: [{ label: 'liste des animateures', path: '/Animateur' ,icon:'fas fa-tasks'}, { label: 'ajouter animateur', path: '/' ,icon:'fas fa-calendar-plus'}], isActive: false },
      ]
    };
  },
  methods: {
    closeSidebar() {
      this.isSidebarOpen = false;
    },
    toggleDropdown(index) {
      this.opciones[index].isActive = !this.opciones[index].isActive;
    }
  }
}
</script>

<style>
/* Header Styles */
/* Global container styles */
.main-container {
  padding: 0;
}

/* Navbar styles */
.navbar {
  background-color: #5585e4; /* Light blue background */
  padding: 10px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

/* Custom button styles */
.btn-custom {
  background-color: hsl(257, 18%, 85%); /* White background for buttons */
  color: #333; /* Dark text for visibility */
  font-size: 0.875rem; /* Small text size */
  font-weight: 600; /* Medium font weight */
  padding: 12px 16px; /* Padding inside the button */
  border: none; /* No border */
  cursor: pointer; /* Pointer cursor on hover */
  border-radius: 4px; /* Rounded corners for aesthetic */
}

/* Red button for logout */
.btn-danger {
  background-color: #dc3545; /* Bootstrap danger color for emphasis */
  color: #ffffff; /* White text on danger button */
}

/* Icon inside button */
.btn-custom i {
  margin-right: 5px; /* Space between icon and text */
  color: #333;
}
.sidebar{
  color: #020101;
}
/* Styles pour les options de la sidebar */
.option-with-dropdown {
  margin-bottom: 10px; /* Espace entre les options */
}

/* Styles pour les sous-menus déroulants */
.option-with-dropdown ul {
  margin-top: 0; /* Réduit l'espace entre l'option et le début de son sous-menu */
  padding-top: 0; /* Réduit l'espace intérieur au haut de la liste */
}

/* Styles pour les items individuels dans le sous-menu */
.option-with-dropdown li {
  margin-bottom: 5px; /* Espace entre les items */
}
/* Styles généraux pour les icônes dans la sidebar */
.sidebar i {
  font-size: 20px; /* Taille de l'icône */
  color: white; /* Couleur de l'icône */
  margin-right: 10px; /* Espace à droite de l'icône */
}

/* Effet de survol pour les icônes */
.sidebar i:hover {
  margin-left: auto;
  color: #a4b0be; /* Change la couleur au survol */
  cursor: pointer; /* Change le curseur pour indiquer que c'est cliquable */
  transition: color 0.3s; /* Animation douce pour le changement de couleur */
}

/* Styles pour les liens dans la sidebar, y compris les icônes et le texte */
.sidebar a {
  display: flex;
  align-items: center; /* Centrer les icônes avec le texte verticalement */
  text-decoration: none; /* Supprimer le soulignement du texte */
  color: white; /* Couleur du texte */
  padding: 10px; /* Padding autour du texte et de l'icône pour plus de cliquabilité */
}

/* Style pour le texte des liens pour assurer une bonne visibilité et espacement */
.sidebar a span {
  margin-left: 20px; /* Petit espace entre l'icône et le texte */
}.profil-button {
  padding-left: 40px; /* Ajustez cette valeur selon vos besoins */
}

</style>
