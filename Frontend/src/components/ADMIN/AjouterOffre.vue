<template>
  <div class="container">
    <h2 class="text-center">Ajouter une Offre</h2>
    <form @submit.prevent="submitForm" class="form">
      <div class="form-group">
        <label for="titre">Titre de l'offre:</label>
        <input type="text" id="title" v-model="offer.titre" required class="form-control" />
      </div>
      <div class="form-group">
        <label for="date_debut">Date début</label>
        <input type="date" id="date_debut" v-model="offer.date_debut" required class="form-control" />
      </div>
      <div class="form-group">
        <label for="date_fin">Date fin</label>
        <input type="date" id="date_fin" v-model="offer.date_fin" required class="form-control" />
      </div>
      <div class="form-group">
        <label for="remise">Remise (%):</label>
        <input type="number" id="remise" v-model="offer.remise" required class="form-control" />
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" v-model="offer.description" required class="form-control"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div v-if="message" class="message">
      <p>{{ message }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AjouterOffre',
  data() {
    return {
      offer: {
        titre: '',
        date_debut: '',
        date_fin: '',
        description: '',
        remise: '',
      // Remplacer par la méthode pour obtenir l'ID de l'administrateur
      },
      message: ''
    };
  },
  methods: {
    submitForm() {
      // Assurez-vous que l'ID de l'administrateur est défini
      if (!this.offer.admin_id) {
        this.message = "L'ID de l'administrateur est requis.";
        return;
      }

      // Create a form data object to send the offer details
      const formData = new FormData();
      formData.append('titre', this.offer.titre);
      formData.append('date_debut', this.offer.date_debut);
      formData.append('date_fin', this.offer.date_fin);
      formData.append('description', this.offer.description);
      formData.append('remise', this.offer.remise);
      formData.append('admin_id', this.offer.admin_id);

      // Use Axios to submit the form data
      axios.post('http://localhost:8000/api/create/offer/', formData)
        .then(response => {
          console.log('Offre ajoutée:', response.data);
          this.message = 'Offre ajoutée avec succès!';
          // Reset form fields after submission
          this.offer = {
            titre: '',
            date_debut: '',
            date_fin: '',
            description: '',
            remise: '',
            admin_id: 1 // Réinitialiser l'admin_id
          };
          // Optionally, navigate to another route or show a success message
          this.$router.push('/offerspage');
        })
        .catch(error => {
          console.error('Erreur lors de l\'ajout de l\'offre:', error.response?.data || error.message);
          this.message = 'Erreur lors de l\'ajout de l\'offre : ' + (error.response?.data?.detail || error.message);
        });
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.text-center {
  text-align: center;
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.btn {
  display: block;
  width: 100%;
  padding: 10px;
  background: #007BFF;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}
.btn:hover {
  background: #0056b3;
}
.message {
  margin-top: 20px;
  text-align: center;
  font-size: 1.2rem;
  color: #d9534f;
}
</style>
