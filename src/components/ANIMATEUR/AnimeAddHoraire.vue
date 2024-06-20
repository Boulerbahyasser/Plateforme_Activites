<template>
  <div class="add-horaire-container">
    <h1>Ajouter un Horaire Disponible</h1>
    <form @submit.prevent="addHoraire" class="add-horaire-form">
      <div class="form-group">
        <label for="start_time">Heure de début:</label>
        <input type="time" v-model="horaire.start_time" required>
      </div>
      <div class="form-group">
        <label for="end_time">Heure de fin:</label>
        <input type="time" v-model="horaire.end_time" required>
      </div>
      <div class="form-group">
        <label for="day">Jour:</label>
        <select v-model="horaire.day" required>
          <option value="Lundi">Lundi</option>
          <option value="Mardi">Mardi</option>
          <option value="Mercredi">Mercredi</option>
          <option value="Jeudi">Jeudi</option>
          <option value="Vendredi">Vendredi</option>
          <option value="Samedi">Samedi</option>
          <option value="Dimanche">Dimanche</option>
        </select>
      </div>
      <button type="submit" class="submit-btn">Ajouter Horaire</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AddHoraire',
  data() {
    return {
      horaire: {
        start_time: '',
        end_time: '',
        day: 'Lundi'
      },
    };
  },
  methods: {
    async addHoraire() {
      try {
        const animId = this.$route.params.anim_id;
        await axios.post('http://localhost:8000/api/add/available/horaires/anim/', {
          anim_id: animId,
          start_time: this.horaire.start_time,
          end_time: this.horaire.end_time,
          day: this.horaire.day,
        });
        alert('Horaire ajouté avec succès');
        this.$router.push(`/show/available/horaires/animateur/${animId}`);
      } catch (error) {
        console.error('Erreur lors de l\'ajout de l\'horaire:', error);
        alert('Erreur lors de l\'ajout de l\'horaire. Veuillez réessayer plus tard.');
      }
    }
  }
};
</script>

<style scoped>
.add-horaire-container {
  padding: 40px;
  text-align: center;
  background: #f5f7fa;
  color: #333;
}

h1 {
  font-size: 2.5rem;
  color: #0056b3;
  font-weight: bold;
}

.add-horaire-form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.form-group {
  margin-bottom: 20px;
  text-align: left;
  width: 100%;
  max-width: 400px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
  color: #333;
}

input, select {
  width: 100%;
  padding: 10px;
  border-radius: 5px;
  border: 2px solid #ddd;
  transition: border-color 0.3s;
}

input:focus, select:focus {
  border-color: #3498db;
}

.submit-btn {
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  background-color: #2ecc71;
  color: white;
  transition: background-color 0.3s, box-shadow 0.3s;
  font-size: 1rem;
}

.submit-btn:hover {
  background-color: #27ae60;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.submit-btn:active {
  background-color: #1e8449;
}
</style>
