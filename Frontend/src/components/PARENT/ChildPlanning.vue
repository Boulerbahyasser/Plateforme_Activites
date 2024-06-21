<template>
  <div class="child-planning">
    <h1>Planification de l'enfant</h1>
    <p class="instruction-text">Veuillez trouver ci-dessous les activités planifiées pour votre enfant.</p>
    <div v-if="loading" class="loader">Chargement de la planification...</div>
    <div v-else-if="error" class="error-message">Erreur lors de la récupération de la planification. Veuillez réessayer plus tard.</div>
    <div v-else class="calendar">
      <div class="week">
        <div v-for="(plan, index) in planning" :key="index" class="day">
          <h2>{{ plan.jour }}</h2>
          <div class="activity">
            <p><strong>{{ plan.titre }}</strong></p>
            <p>{{ plan.heure_debut }} - {{ plan.heure_fin }}</p>
            <p><span class="animer_par">Animé par :</span> {{ plan.name }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from '@/axios';
export default {
  name: 'ChildPlanning',
  data() {
    return {
      planning: [],
      loading: true,
      error: false
    };
  },
  created() {
    this.fetchPlanning();
  },
  methods: {
    async fetchPlanning() {
      const enfantId = this.$route.params.id;
      try {
        const response = await axios.get(`http://localhost:8000/api/show/enfant/planning/${enfantId}`);
        console.log('la reponse est', response.data);
        this.planning = response.data;
        this.loading = false;
      } catch (error) {
        console.error('Erreur lors de la récupération de la planification:', error);
        this.loading = false;
        this.error = true;
      }
    }
  }
};
</script>
<style scoped>
.child-planning {
  padding: 20px;
  text-align: center;
  background: #f5f7fa;
  color: #333;
}

h1 {
  font-size: 2.5rem;
  margin-bottom: 20px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #0056b3;
  font-weight: bold;
}

.instruction-text {
  font-size: 1.2rem;
  color: #4e6267;
  margin-bottom: 20px;
}

.loader {
  font-size: 1.5rem;
  color: #3498db;
}

.error-message {
  color: red;
  font-size: 1.2rem;
}

.calendar {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.week {
  display: flex;
  justify-content: space-around;
  flex-wrap: wrap;
  margin-top: 20px;
  gap: 20px;
}

.day {
  background: #ffffff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  flex: 1;
  margin: 10px;
  min-width: 250px;
  transition: transform 0.3s, box-shadow 0.3s;
}

.day:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.day h2 {
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #2c3e50;
  font-size: 1.8rem;
  margin-bottom: 10px;
  border-bottom: 2px solid #000000;
  padding-bottom: 5px;
}

.activity {
  background: #eaf1f8;
  padding: 15px;
  border-radius: 5px;
  margin-bottom: 10px;
  transition: background-color 0.3s;
}

.activity p {
  margin: 10px 0;
  font-size: 1.1rem;
  color: #34495e;
}

.activity strong {
  color: #3498db;
  font-size: 1.2rem;
}

.activity:hover {
  background-color: #d0e4f7;
}

.animer_par {
  font-size: 1.2rem;
  color: #7f8c8d;
  font-weight: bold;
}
</style>
