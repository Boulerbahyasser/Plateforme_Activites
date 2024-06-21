<template>
  <div class="container">
    <h2 class="text-center">Ajouter une Offre</h2>
    <form @submit.prevent="submitForm" class="form">
      <div class="form-group">
        <input type="text" id="title" v-model="offer.titre" required class="form-control" placeholder="Titre de l'offre" />
      </div>
      <div class="form-group">
        <input type="date" id="date_debut" v-model="offer.date_debut" required class="form-control" />
      </div>
      <div class="form-group">
        <input type="date" id="date_fin" v-model="offer.date_fin" required class="form-control" />
      </div>
      <div class="form-group">
        <input type="number" id="remise" v-model="offer.remise" required class="form-control" placeholder="Remise (%)" />
      </div>
      <div class="form-group">
        <textarea id="description" v-model="offer.description" required class="form-control" placeholder="Description"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div v-if="message" class="message">
      <p>{{ message }}</p>
    </div>
  </div>
</template>


<script>
import axios from '@/axios';
export default {
  name: 'AjouterOffre',
  data() {
    return {
      offer: {
        id : localStorage.getItem('userid'),
        titre: '',
        date_debut: '',
        date_fin: '',
        description: '',
        remise: '',
      // Remplacer par la méthode pour obtenir l'ID de l'administrateur
      },
      message: '',

    };
  },
  methods: {
    submitForm() {
      // Assurez-vous que l'ID de l'administrateur est défini

      // Create a form data object to send the offer details
      const formData = new FormData();
      formData.append('id',this.id);
      formData.append('titre', this.offer.titre);
      formData.append('date_debut', this.offer.date_debut);
      formData.append('date_fin', this.offer.date_fin);
      formData.append('description', this.offer.description);
      formData.append('remise', this.offer.remise);


      // Use Axios to submit the form data
      axios.post('http://localhost:8000/api/create/offer/', formData)

        .then(response => {

          console.log('Offre ajoutée:', response.data.id);
          this.message = 'Offre ajoutée avec succès!';
          // Reset form fields after submission
          this.offer = {
            titre: '',
            date_debut: '',
            date_fin: '',
            description: '',
            remise: '',
            //admin_id: 1 // Réinitialiser l'admin_id
          };
          // Optionally, navigate to another route or show a success message
          this.$router.push('/offerspage');
        })
        .catch(error => {
          console.error('Erreur lors de l\'ajout de l\'offre:', error.response?.data || error.message);
          this.message = 'Erreur lors de l\'ajout de l\'offre : ' + (error.response?.data?.detail || error.message);
        });
    },

  }
};
</script>

<style scoped>
.container {
  max-width: 400px; /* Réduction de la largeur maximale */
  margin: 40px auto; /* Augmentation de la marge pour centrer le formulaire */
  padding: 20px;
  background: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
}
.text-center {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
  font-size: 24px;
}
.form-group {
  margin-bottom: 10px;
}
.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 14px;
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
  margin-top: 15px; /* Ajout d'une marge supérieure */
}
.btn:hover {
  background: #0056b3;
}
.message {
  margin-top: 20px;
  text-align: center;
  font-size: 1rem;
  color: #28a745; /* Changement de couleur pour un message de succès */
}
</style>
