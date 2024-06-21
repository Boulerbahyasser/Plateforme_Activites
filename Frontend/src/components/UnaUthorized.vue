<template>
  <div class="unauthorized-container">
    <div class="unauthorized-content">
      <h1>Non Autorisé</h1>
      <p>Vous n'avez pas la permission d'accéder à cette page.</p>
      <router-link to="/" class="home-link">Retour à l'accueil</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'UnaUthorized'
};
</script>
<style scoped>
.unauthorized-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #0a0591;
}

.unauthorized-content {
  text-align: center;
  padding: 20px;
  border-radius: 10px;
  background: rgba(255, 255, 255, 0.1);
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.unauthorized-content:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
}

h1 {
  font-family: 'Baloo Bhaijaan 2', cursive;
  font-size: 3rem;
  margin-bottom: 20px;
}

p {
  font-size: 1.2rem;
  margin-bottom: 20px;
}

.home-link {
  display: inline-block;
  padding: 10px 20px;
  background-color: #2ecc71;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-size: 1rem;
  font-weight: bold;
  transition: background-color 0.3s, box-shadow 0.3s;
}

.home-link:hover {
  background-color: #27ae60;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.home-link:active {
  background-color: #1e8449;
}
</style>
