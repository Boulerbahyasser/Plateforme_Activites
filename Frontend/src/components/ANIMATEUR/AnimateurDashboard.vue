<template>
  <div class="animateur-dashboard">
    <h1>Tableau de Bord des Animateurs</h1>
    <nav>
      <ul>
        <li><router-link to="/AnimeHoraire"><i class="fas fa-calendar-alt"></i> Horaires de l'Animateur</router-link></li>
        <li><router-link to="/AnimeOcuperHoraire"><i class="fas fa-calendar-times"></i> Horaires Occupés</router-link></li>
        <li><router-link to="/AnimeDispHoraire"><i class="fas fa-calendar-check"></i> Horaires Disponibles</router-link></li>
        <li><router-link to="/AnimeAddHoraire"><i class="fas fa-plus-circle"></i> Ajouter des Horaires</router-link></li>
      </ul>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'AnimateurDashboard'
};
</script>

<style scoped>
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');

.animateur-dashboard {
  padding: 20px;
  text-align: center;
  background: linear-gradient(135deg, #6e8efb, #a777e3);
  color: #fff;
  min-height: 100vh;
}

h1 {
  font-size: 3rem;
  margin-bottom: 20px;
  font-family: 'Baloo Bhaijaan 2', cursive;
}

nav ul {
  list-style-type: none;
  padding: 0;
  display: flex;
  justify-content: center;
  gap: 20px;
  flex-wrap: wrap;
}

nav ul li {
  background: rgba(255, 255, 255, 0.1);
  padding: 10px 20px;
  border-radius: 8px;
  transition: transform 0.3s, background-color 0.3s;
}

nav ul li:hover {
  transform: translateY(-5px);
  background: rgba(255, 255, 255, 0.2);
}

nav ul li a {
  text-decoration: none;
  color: #fff;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 10px;
}

nav ul li a i {
  font-size: 1.2rem;
}

nav ul li a:hover {
  text-decoration: underline;
}
</style>
