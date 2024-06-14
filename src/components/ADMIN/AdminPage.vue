<template>
  <div class="main-container">
    <!-- En-tête -->
    <header class="header">
      <div class="logo">
        <img src="@/assets/child.png" alt="Logo" class="logo-img" />
        <span>Nom de l'entreprise </span>
      </div>
      <div class="header-right">
        <i class="fas fa-comment-dots icon"></i>
        <i class="fas fa-bell icon"></i>
        <i class="fas fa-right-from-bracket icon logout-icon"><router-link :to="{name:'WelcomePage'}">logout</router-link></i>
      </div>
    </header>
    <br>
    <br>
    <!-- Contenu principal -->
    <main class="content">
      <h1>Bienvenue Monsieur "Administrateur"</h1>
      <div class="card-grid">
        <div class="card" v-for="(option, index) in opciones" :key="index" @click="handleOptionClick(option)">
          <i :class="option.icon + ' card-icon'"></i>
          <h3>{{ option.title }}</h3>
          <p>{{ option.description }}</p>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'AdminPage',
  data() {
    return {
      opciones: [
        {
          title: 'Calendrier',
          icon: 'fas fa-calendar-alt',
          description: '',
          route: '/calendar'
        },
        {
          title: 'Mes Offres',
          icon: 'fas fa-users',
          description: '',
          route: '/OffersListAdmin'
        },
        {
          title: 'Ajouter une offre',
          icon: 'fas fa-plus-circle',
          description: '',
          route: '/ajouteroffre'
        },
        {
          title: 'Ajouter une activité',
          icon: 'fas fa-plus-circle',
          description: '',
          route: '/AjouterActivite'
        },
        {
          title: 'Mes demandes',
          icon: 'fas fa-plus-circle',
          description: '',
          route: '/requests'
        }
      ]
    }
  },
  methods: {
    handleOptionClick(option) {
      if (option.route) {
        this.$router.push(option.route); // Redirige vers la route spécifiée
      } else {
        console.log(`Option sélectionnée : ${option.title}`);
      }
    },
    handleLogout() {
      // Logic for handling logout
      console.log('User logged out');
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
}body {
  background-color: #ffffff;
  color: #c51818;
}

/* Header Styles */
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 20px;
  background-color: #f3f3f3;
  box-shadow: 0 4px 6px rgba(233, 7, 7, 0.1);
}
.logo {
  display: flex;
  align-items: center;
}
.logo-img {
  height: 50px; /* Adjusted height for better visibility */
  margin-right: 10px;
}
.header-right {
  display: flex;
  align-items: center;
}
.icon {
  font-size: 20px;
  margin: 0 10px;
  cursor: pointer;
}
.logout-icon {
  color: red; /* You can change this color to suit your design */
}

/* Main Content Styles */
.main-container {
  padding: 20px;
}
.content {
  max-width: 1200px;
  margin: 0 auto;
  text-align: center;
}
h1 {
  font-size: 24px;
  margin-bottom: 20px;
}
.search-bar {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 30px;
}
.search-bar input {
  width: 400px;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  margin-right: 10px;
}
.btn-help {
  background-color: #ff6b6b;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
}
.btn-help:hover {
  background-color: #e65c5c;
}

/* Card Grid Styles */
.card-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
}
.card {
  background-color: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  cursor: pointer;
  transition: transform 0.3s;
}
.card:hover {
  transform: translateY(-5px);
}
.card-icon {
  font-size: 36px;
  margin-bottom: 10px;
  color: #36f045;
}
h3 {
  margin-bottom: 10px;
  font-size: 18px;
}
p {
  color: #666;
}
</style>