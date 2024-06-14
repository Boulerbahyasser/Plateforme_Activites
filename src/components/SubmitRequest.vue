<template>
  <div class="submit-request-container">
    <h1>Récapitulatif de la Demande</h1>
    <div v-for="(activity, index) in selectedActivities" :key="index" class="activity-summary">
      <h2>Offre: {{ activity.offerTitre }}</h2>
      <p>Activité: {{ activity.activityTitre }}</p>
      <p>Enfant: {{ activity.childName }}</p>
      <p>Les Horaires:
        <span>Horaire est : {{ activity.schedule1 }} </span>
      </p>
    </div>
    <div class="pack-selection">
      <h3>Choisissez un Pack (Optionnel):</h3>
      <div class="pack-options">
        <label :class="{'active': selectedPack.includes('PackEnfant')}">
          <input type="checkbox" v-model="selectedPack" value="PackEnfant" />
          Pack Enfant
        </label>
        <label :class="{'active': selectedPack.includes('PackAtelier')}">
          <input type="checkbox" v-model="selectedPack" value="PackAtelier" />
          Pack Atelier
        </label>
      </div>
    </div>
    <button @click="submitRequest">Soumettre la Demande</button>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  name: 'SubmitRequest',
  data() {
    return {
      selectedActivities: JSON.parse(localStorage.getItem('selectedActivities')) || [],
      selectedPack: JSON.parse(localStorage.getItem('selectedPack')) || [] // Ajout du stockage des packs
    };
  },
  methods: {
    async submitRequest() {
      try {
        const response = await axios.post('http://localhost:8000/api/create/demande/', {
          activities: this.selectedActivities,
          selectedPack: this.selectedPack // Inclure le pack sélectionné
        });
        alert(response.data.name);
        localStorage.removeItem('selectedActivities'); // Nettoyer le localStorage après soumission
        localStorage.removeItem('selectedPack'); // Nettoyer le stockage des packs après soumission
        this.$router.push('/offerspage');
      } catch (error) {
        console.error('Erreur lors de la soumission de la demande:', error);
        alert('Erreur lors de la soumission de la demande. Veuillez réessayer plus tard.');
      }
    }
  },
  watch: {
    selectedPack(newPack) {
      localStorage.setItem('selectedPack', JSON.stringify(newPack));
    }
  }
};
</script>
<style scoped>
.submit-request-container {
  padding: 40px;
  text-align: center;
  background: #f5f7fa;
  color: #333;
}

h1 {
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #34495e;
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.activity-summary {
  background: #fff;
  margin: 20px auto;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  width: 80%;
  text-align: left;
}

.activity-summary h2 {
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #2c3e50;
  font-size: 1.8rem;
  margin-bottom: 10px;
}

.activity-summary p {
  font-size: 1.2rem;
  color: #7f8c8d;
  margin: 5px 0;
}

.pack-selection {
  margin-top: 30px;
}

.pack-selection h3 {
  font-size: 1.5rem;
  margin-bottom: 20px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #2c3e50;
}

.pack-options {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.pack-options label {
  font-size: 1.2rem;
  color: #34495e;
  cursor: pointer;
  padding: 10px 20px;
  border-radius: 5px;
  border: 1px solid #ddd;
  background: #fff;
  transition: background-color 0.3s, color 0.3s;
  display: flex;
  align-items: center;
  gap: 10px;
}

.pack-options label input {
  display: none;
}

.pack-options label.active {
  background-color: #2ecc71;
  color: white;
  border: none;
}

button {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: 20px;
  font-size: 1rem;
  transition: background-color 0.3s, box-shadow 0.3s;
  background-color: #2ecc71;
  color: white;
}

button:hover {
  background-color: #27ae60;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

button:active {
  background-color: #1e8449;
}
</style>
