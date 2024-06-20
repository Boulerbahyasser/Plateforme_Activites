<template>
  <div class="horaires-container">
    <h1>Horaires de l'Animateur</h1>
    <div v-if="loading">Chargement...</div>
    <div v-else-if="error" class="error-message">Erreur lors de la récupération des horaires.</div>
    <div v-else>
      <div v-for="horaire in horaires" :key="horaire.id" class="horaire-card">
        <h2>{{ formatTime(horaire.start_time) }} - {{ formatTime(horaire.end_time) }}</h2>
        <p>Jour: {{ horaire.day }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AnimateurHoraires',
  data() {
    return {
      horaires: [],
      loading: true,
      error: false,
    };
  },
  created() {
    this.fetchHoraires();
  },
  methods: {
    async fetchHoraires() {
      const animId = this.$route.params.anim_id;
      try {
        const response = await axios.get(`http://localhost:8000/api/show/all/horaires/animateur/${animId}`);
        this.horaires = response.data;
        this.loading = false;
      } catch (error) {
        console.error('Erreur lors de la récupération des horaires:', error);
        this.loading = false;
        this.error = true;
      }
    },
    formatTime(time) {
      const date = new Date(`1970-01-01T${time}Z`);
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    }
  },
};
</script>

<style scoped>
.horaires-container {
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

.horaire-card {
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
