<template>
  <!-- Navigation Supérieure -->
  <nav class="navbar">
    <div>
      <button @click="toggleSidebar" class="navbar-button">
        <i class="fas fa-bars"></i> BIENVENUE
      </button>
    </div>
    <div class="navbar-center">
      <router-link to="/offerspage" class="nav-link">Accueil</router-link>
      <router-link to="/AproposNous" class="nav-link">À propos de nous</router-link>
      <router-link to="/contact" class="nav-link">Contact</router-link>
      <router-link to="/FAQ" class="nav-link">FAQ</router-link>
    </div>
    <div class="navbar-right">
      <router-link to="/notificationpage" class="icon-link"><i class="fas fa-bell"></i></router-link>
      <div class="profile-dropdown">
        <button @click="toggleProfileMenu" class="icon-link profile-button"><i class="fas fa-user"></i></button>
        <div v-if="showProfileMenu" class="dropdown-menu">
          <router-link to="/userprofile">Profil</router-link>
          <router-link to="/userchildren">Mes Enfants</router-link>
          <router-link :to="`/changepassword/${token}`">Changer mot de passe</router-link>
          <router-link to="/parentrequests">Mes demandes</router-link>
          <button @click="logout">Déconnexion</button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Navigation Latérale -->
  <aside :class="{ 'closed': !isSidebarOpen }" class="sidebar">
    <div class="sidebar-close">
      <button @click="closeSidebar" class="sidebar-close-button">
        <i class="fas fa-times"></i>
      </button>
    </div>
    <nav>
      <ul class="sidebar-menu">
        <li v-for="(option, index) in opciones" :key="index" class="option-with-dropdown">
          <div class="sidebar-item" @click="toggleDropdown(index)">
            <div class="sidebar-item-content">
              <i :class="option.icon"></i>
              <span>{{ option.title }}</span>
            </div>
            <i class="fas fa-chevron-down"></i>
          </div>
          <ul v-show="option.isActive" class="sidebar-submenu">
            <li v-for="child in children" :key="child.id">
              <a href="#" class="sidebar-submenu-item" @click.prevent="selectChild(child)">
                <i class="fas fa-chevron-right"></i>
                {{ child.prenom }} {{ child.nom }}
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </aside>

  <div class="modal" v-show="showForm">
    <div class="modal-background" @click="closeForm"></div>
    <div class="modal-content">
      <form @submit.prevent="submitForm">
        <h3>Détails de {{ selectedChild.prenom }} {{ selectedChild.nom }}</h3>
        <div class="form-group">
          <label for="firstName">Nom:</label>
          <input id="firstName" v-model="selectedChild.prenom" type="text" placeholder="Nom" disabled>
        </div>
        <div class="form-group">
          <label for="lastName">Prénom:</label>
          <input id="lastName" v-model="selectedChild.nom" type="text" placeholder="Prénom" disabled>
        </div>
        <div class="form-group">
          <label for="courses">Niveau:</label>
          <input id="courses" v-model="selectedChild.niveau" placeholder="Le niveau de l'enfant" disabled type="text">
        </div>
        <button type="submit">Enregistrer</button>
        <button type="button" @click="closeForm">Annuler</button>
      </form>
    </div>
  </div>

  <!-- Formulaire Modal pour Ajouter un Enfant -->
  <div class="modal" v-show="showAddChildForm">
    <div class="modal-background" @click="closeAddChildForm"></div>
    <div class="modal-content">
      <form @submit.prevent="addNewChild">
        <i class="fas fa-user-circle text-white text-2xl"></i>
        <input v-model="newChild.prenom" type="text" placeholder="Nom" required>
        <input v-model="newChild.nom" type="text" placeholder="Prénom" required>
        <input v-model="newChild.niveau" type="text" placeholder="Niveau" required>
        <input v-model="newChild.dateOfBirth" type="date" placeholder="Date de naissance" required>
        <button type="submit">Ajouter</button>
        <button type="button" @click="closeAddChildForm">Annuler</button>
      </form>
    </div>
  </div>

  <!-- Contenu principal -->
  <div class="main">
    <!-- Votre contenu principal ici -->
  </div>
</template>

<script>
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';

import axios from '@/axios';

export default {
  name: 'UtilisateurParent',
  data() {
    return {
      isSidebarOpen: false,
      showProfileMenu: false,
      showForm: false,
      showAddChildForm: false,
      selectedChild: { prenom: '', nom: '', niveau: '' },
      newChild: { prenom: '', nom: '', niveau: '', dateOfBirth: '' },
      opciones: [
        {
          title: 'Mes Enfants',
          icon: 'fa fa-users',
          isActive: false,
          items: []
        },
        {
          title: 'Ajouter un enfant',
          icon: 'fas fa-plus-circle',
          isActive: false,
          items: []
        }
      ],
      token: '' // Ajouter ici pour stocker le token
    };
  },
  created() {
    this.fetchChildren();
    this.token = this.$route.params.token; // Initialiser le token à partir des paramètres de la route
  },
  methods: {
    toggleProfileMenu() {
      this.showProfileMenu = !this.showProfileMenu;
    },
    logout() {
      localStorage.removeItem('token');
      this.$router.push('/ConnexionPage');
    },
    toggleSidebar() {
      this.isSidebarOpen = !this.isSidebarOpen;
    },
    closeSidebar() {
      this.isSidebarOpen = false;
    },
    toggleDropdown(index) {
      if (this.opciones[index].title === 'Ajouter un enfant') {
        this.openAddChildForm();
      } else {
        this.opciones[index].isActive = !this.opciones[index].isActive;
      }
    },
    openForm() {
      this.showForm = true;
    },
    closeForm() {
      this.showForm = false;
    },
    openAddChildForm() {
      this.showAddChildForm = true;
    },
    closeAddChildForm() {
      this.showAddChildForm = false;
    },
    async fetchChildren() {
      try {
        const response = await axios.get('http://localhost:8000/api/show/parent/enfant/');
        console.log('Response data:', response.data);
        if (Array.isArray(response.data) && Array.isArray(response.data[0])) {
          this.children = response.data[0]; // Assigne le tableau imbriqué
        } else {
          this.children = response.data;
        }
        this.loading = false;
      } catch (error) {
        console.error('Erreur lors de la récupération des enfants:', error);
        this.loading = false;
        this.error = true;
      }
    },
    selectChild(child) {
      this.selectedChild = child;
      this.openForm();
    },
    addNewChild() {
      axios.post('http://localhost:8000/api/children', this.newChild)
        .then(response => {
          console.log("Enfant ajouté:", response.data);
          this.fetchChildren();
          this.closeAddChildForm();
        })
        .catch(error => {
          console.error("Erreur lors de l'ajout de l'enfant:", error);
        });
    },
    submitForm() {
      console.log("Updating child:", this.selectedChild);
      this.closeForm();
    }
  }
};
</script>

<style scoped>
/* Global Styles */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Roboto', sans-serif;
}
html, body {
  height: 100%;
  width: 100%;
  background-color: #ffffff;
  color: #334155;
}

/* Navbar Styling */
.navbar {
  background-color: #007BFF;
  padding: 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.navbar-button {
  color: white;
  font-size: 18px;
  font-weight: bold;
  border: none;
  background: none;
  cursor: pointer;
}
.navbar-center {
  display: flex;
  gap: 100px; /* Espace entre les liens */
  flex: 3; /* élément prendra deux 3 plus d'espace disponible que les autres éléments flexibles avec une valeur flex de 1.*/
  list-style: none;
  justify-content:center;
  margin: 0;
  padding: 0;
}

.nav-link {
  color: white;
  text-decoration: none;
  font-size: 18px;
}
.nav-link:hover {
  text-decoration: underline;
  font-weight: bold;
}
.navbar-right {
  display: flex;
  align-items: center;
}
.icon-link {
  color: white;
  padding: 10px;
  cursor: pointer;
}

/* Sidebar Styling */
.sidebar {
  width: 280px;
  height: 100%;
  position: fixed;
  top: 0;
  left: 0;
  background: linear-gradient(to bottom, #312a96, #595588);
  box-shadow: 2px 0 15px rgba(0, 0, 0, 0.1);
  z-index: 2000; /* Make sure sidebar is above other content */
  transition: transform 0.3s ease;
  padding: 20px;
}
.sidebar.closed {
  transform: translateX(-280px);
}
.sidebar-close {
  display: flex;
  justify-content: flex-end;
}
.sidebar-close-button {
  color: white;
  border: none;
  background: none;
  cursor: pointer;
}
.sidebar-menu {
  list-style-type: none;
  padding: 0;
  margin-top: 20px;
}
.sidebar-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 12px 20px;
  color: #b2c6e4;
  cursor: pointer;
  transition: background-color 0.3s, color 0.3s;
}
.sidebar-item:hover {
  background: #0056b3;
  color: #ffffff;
}
.sidebar-submenu {
  list-style-type: none;
  padding-left: 20px;
}
.sidebar-submenu-item {
  display: flex;
  align-items: center;
  padding: 8px 20px;
  color: #b2c6e4;
  text-decoration: none;
  transition: background-color 0.3s, color 0.3s;
}
.sidebar-submenu-item:hover {
  background: #0056b3;
  color: #ffffff;
}
.sidebar-item-content {
  display: flex;
  align-items: center;
}
.sidebar-item-content i {
  margin-right: 10px;
}
.sidebar-item i {
  font-size: 12px;
  transition: transform 0.3s ease-in-out;
}
.sidebar-item:hover i {
  transform: rotate(90deg);
}

/* Modal Styling */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  visibility: visible;
  z-index: 3000; /* Ensure modals are above all content */
}
.modal-background {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}
.modal-content {
  background-color: white;
  padding: 20px;
  margin: auto;
  z-index: 2;
  width: 400px;
}
.modal-content input,
.modal-content button {
  display: block;
  width: 100%;
  box-sizing: border-box;
}
.modal-content input {
  margin-bottom: 30px;
}
.modal-content button {
  margin-bottom: 10px;
}

.modal-content label{
  font-weight: bold;
  margin-bottom: 30px;
}


/* Dropdown Menu Styling */
.profile-dropdown {
  position: relative;
  display: inline-block;
}
.dropdown-menu {
  display: block;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 260px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
  z-index: 1;
  right: 0;
  top: 48px;
}
.dropdown-menu a,
.dropdown-menu button {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  width: 100%;
  text-align: left;
  border: none;
  background: none;
}
.dropdown-menu a:hover,
.dropdown-menu button:hover {
  background-color: #b9b9b9;
}

/* Main Content Styling */
.main {
  margin-left: 280px;
  padding: 20px;
  transition: margin-left 0.3s ease;
}

/* Button and Interactive Element Styling */
button, .button-like {
  background-color: #007BFF;
  color: white;
  border: none;
  padding: 15px;
  border-radius: 5px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  cursor: pointer;
  transition: all 0.3s ease;
}
button:hover, .button-like:hover {
  background-color: #0056b3;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
  transform: translateY(-3px);
}

/* Icon Styling */
.fas {
  margin-left: 10px;
  font-size: 20px;
  transition: transform 0.3s ease-in-out;
  color: white;
}
.fas:hover {
  transform: rotate(180deg);
}

/* Responsive Adjustments for Sidebar */
@media (max-width: 768px) {
  aside {
    transform: translateX(-100%);
  }
  .main {
    margin-left: 0;
  }
}
</style>
