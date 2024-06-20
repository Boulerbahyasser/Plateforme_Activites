<template>
  <div class="animateurs-container">
    <h1>Liste des Animateurs</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else-if="error" class="error-message">Erreur lors de la récupération des animateurs.</div>
    <div v-else>
      <div v-for="animateur in animateurs" :key="animateur.id" class="animateur-card">
        <h2>{{ animateur.name }}</h2>
        <p>Email: {{ animateur.email }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AnimateursList',
  data() {
    return {
      animateurs: [],
      loading: true,
      error: false,
    };
  },
  created() {
    this.fetchAnimateurs();
  },
  methods: {
    async fetchAnimateurs() {
      try {
        const response = await axios.get('http://localhost:8000/api/show/animateurs/');
        console.log('les donner recue :',response.data);
        this.animateurs = response.data;
        this.loading = false;
      } catch (error) {
        console.error('Erreur lors de la récupération des animateurs:', error);
        this.loading = false;
        this.error = true;
      }
    },
  },
};
</script>

<style scoped>
.animateurs-container {
  padding: 20px;
  text-align: center;
  background: #f5f7fa;
  color: #333;
}

h1 {
  font-size: 2.5rem;
  color: #0056b3;
  font-weight: bold;
}

.animateur-card {
  background: #fff;
  margin: 20px auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  text-align: left;
}

.error-message {
  color: red;
}
</style>
