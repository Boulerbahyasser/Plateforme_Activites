<template>
  <nav class="BarreDeNavigation">
    <div class="NavigationGauche">
      <router-link to="/" class="MarqueNavigation">
        <img src="@/assets/logo2.png" alt="Logo" class="LogoNavigation">
      </router-link>
    </div>
    <ul class="NavigationCentre" :class="{ 'afficher': menuOuvert }">
      <li><router-link to="/">Accueil</router-link></li>
      <li><router-link to="/AproposNous">À propos de nous</router-link></li>
      <li><router-link to="/how-to-use">FAQ</router-link></li>
      <li><router-link to="/contact">Contact</router-link></li>
    </ul>
    <div class="NavigationDroite">
      <router-link to="/notification"><i class="fas fa-bell"></i></router-link>
      <router-link to="/profile"><i class="fas fa-user"></i></router-link>
    </div>
    <button class="ToggleNavigation" @click="basculerMenu">
      <span class="Barre"></span>
      <span class="Barre"></span>
      <span class="Barre"></span>
    </button>
  </nav>
</template>

<script>
export default {
  name: 'ElementNavigation',
  data() {
    return {
      menuOuvert: false,
    };
  },
  methods: {
    basculerMenu() {
      this.menuOuvert = !this.menuOuvert;
    }
  }
};
</script>

<style scoped>
.BarreDeNavigation {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(to right, #6a11cb 0%, #2575fc 100%);
  color: white;
  padding: 0.75rem 1.5rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

.NavigationGauche, .NavigationDroite {
  flex: 1;
}

.NavigationGauche {
  flex: 1;
  position: relative;
}

.NavigationGauche::after {
  content: "";
  display: block;
  width: 2px;
  height: 100%;
  background-color: white;
  position: absolute;
  right: 0;
  top: 0;
}

.NavigationCentre {
  flex: 3;
  list-style: none;
  display: flex;
  justify-content: space-around;
  margin: 0;
  padding: 0;
}

.LogoNavigation {
  height: 70px;
  transition: transform 0.3s ease-in-out;
}

.LogoNavigation:hover {
  transform: scale(1.1);
}

.BarreDeNavigation a {
  text-decoration: none;
  color: white;
  font-weight: 500;
  transition: color 0.3s ease-in-out;
}

.BarreDeNavigation a:hover {
  font-weight: bold;
}

.fas {
  margin-left: 20px;
  font-size: 20px;
  transition: transform 0.3s ease-in-out;
}

.fas:hover {
  transform: rotate(180deg);
}

.ToggleNavigation {
  display: none;
  flex-direction: column;
  cursor: pointer;
  border: none;
  background: none;
}

.ToggleNavigation .Barre {
  display: block;
  width: 25px;
  height: 3px;
  margin: 3px auto;
  background-color: white;
  transition: all 0.3s ease;
}

@media (max-width: 768px) {
  .NavigationGauche::after {
    display: none;
  }

  .NavigationCentre {
    position: absolute;
    top: 60px;
    width: 100%;
    background-color: rgba(1, 17, 52, 0.85);
    flex-direction: column;
    display: none;
  }

  .NavigationCentre.afficher {
    display: flex;
  }

  .ToggleNavigation {
    display: flex;
  }
}
</style>
