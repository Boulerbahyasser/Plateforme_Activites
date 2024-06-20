<template>
  <div class="animateur-details-container">
    <h1>Détails de l'Animateur</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else-if="error" class="error-message">Erreur lors de la récupération des détails de l'animateur.</div>
    <div v-else>
      <h2>{{ animateur.name }}</h2>
      <p>Email: {{ animateur.email }}</p>
      <p>Téléphone: {{ animateur.phone }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AnimateurDetails',
  data() {
    return {
      animateur: null,
      loading: true,
      error: false,
    };
  },
  created() {
    this.fetchAnimateur();
  },
  methods: {
    async fetchAnimateur() {
      const animateurId = this.$route.params.animateur;
      try {
        const response = await axios.get(`http://localhost:8000/api/show/animateur/${animateurId}`);
        this.animateur = response.data;
        this.loading = false;
      } catch (error) {
        console.error('Erreur lors de la récupération des détails de l\'animateur:', error);
        this.loading = false;
        this.error = true;
      }
    },
  },
};
</script>

<style scoped>
.animateur-details-container {
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

.error-message {
  color: red;
}
</style>
