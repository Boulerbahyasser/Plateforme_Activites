<template>
  <div class="container">
    <h2 class="text-center">Détails de l'offre</h2>
    <div v-if="offer" class="offer-details">
      <div class="offer-info card">
        <h3 class="card-title">{{ offer.titre }}</h3>
        <p><strong>Date début:</strong> {{ formatDate(offer.date_debut) }}</p>
        <p><strong>Date fin:</strong> {{ formatDate(offer.date_fin) }}</p>
        <p><strong>Remise:</strong> {{ offer.remise }}%</p>
        <p><strong>Description:</strong> {{ offer.description }}</p>
      </div>
      <div class="offer-image card" v-if="offer.image">
        <img :src="`http://localhost:8000/${offer.image}`" alt="Image de l'offre">
      </div>
    </div>
    <div v-else class="loading">
      <p>Chargement des détails de l'offre...</p>
    </div>

    <div class="button-container">
      <button @click="toggleActivities" class="btn-activities">Afficher les activités</button>
      <button @click="toggleAvailableActivities" class="btn-add-activity">Ajouter une activité</button>
      <button @click="deleteOffer" class="btn-delete">Supprimer l'offre</button>
    </div>
 
    <div v-if="showActivities && activities.length" class="activities">
      <h3>Activités associées</h3>
      <div v-for="activity in activities" :key="activity.id" class="activity-card card">
        <p><strong>Titre :</strong> {{ activity.titre }}</p>
        <p><strong>Description:</strong> {{ activity.description }}</p>
        <router-link :to="{ name: 'ListeEnfantActivites', params: { id: activity.id }}" class="details-btn">
          <button type="button" class="btn btn-info">Les enfants</button>
        </router-link>
      </div>
    </div>
    <br><br>
    <div v-if="showAvailableActivities && availableActivities.length" >
      <h3 class="text-center">Activités disponibles</h3>
      <div class="available-activities">
      <div v-for="activity in availableActivities" :key="activity.id" class="activity-card card">
        <p><strong>Titre :</strong> {{ activity.titre }}</p>
        <p><strong>Description:</strong> {{ activity.description }}</p>
        <p><strong>Lien YouTube :</strong> {{ activity.lien_youtube }}</p>
        <button @click="openActivityForm(activity)" class="btn-add-to-offer">Ajouter à l'offre</button>
      </div>
    </div>
      <div v-if="showActivityForm" class="modal">
      <div class="modal-content">
        <h6 class="text-center">Ajouter une activité à l'offre</h6>
        <form @submit.prevent="submitActivityForm">
          <input v-model="formFields.tarif" type="number" placeholder="Tarif" required>
          <input v-model="formFields.age_min" type="number" placeholder="Âge minimum" required>
          <input v-model="formFields.age_max" type="number" placeholder="Âge maximum" required>
          <input v-model="formFields.nbr_seance" type="number" placeholder="Nombre de séances" required>
          <input v-model="formFields.volume_horaire" type="number" placeholder="Volume horaire" required>
          <select v-model="formFields.option_paiement" required>
            <option value="">Choisir une option de paiement</option>
            <option value="annuel">Annuel</option>
            <option value="mensuel">Mensuel</option>
            
          </select>
          <div class="button-container">
            <button @click="showActivityForm = false">Annuler</button>
          <button type="submit" class="btn-add-activity">Ajouter</button>
          
          </div>
        </form>
      </div>
    </div>
    </div>
  </div>

</template>

<script>
import axios from 'axios';

export default {
  name: 'OffersDetailsAdmin',
  data() {
    return {
      offer: null,
      activities: [],
      availableActivities: [],
      loadingActivities: false,
      activitiesError: null,
      showActivities: false,  // Ajoutée pour contrôler l'affichage des activités,
      showAvailableActivities: false,  // Ajoutée pour contrôler l'affichage des activités disponibles
      showActivityForm: false,
      selectedActivity: null,
      formFields: {
        tarif: '',
        age_min: '',
        age_max: '',
        nbr_seance: '',
        volume_horaire: '',
        option_paiement: ''
      }
    };
  },
  created() {
    this.fetchOfferDetails();
  },
  methods: {
    toggleActivities() {
  if (this.activities.length === 0) {
    this.fetchOfferActivities();  // Charge les activités si pas encore chargées
  } else {
    this.showActivities = !this.showActivities;  // Bascule l'affichage
  }
},
toggleAvailableActivities() {
    if (this.availableActivities.length === 0) { // Charge les activités disponibles si elles ne sont pas encore chargées
      this.fetchAvailableActivities();
    } else {
      this.showAvailableActivities = !this.showAvailableActivities; // Bascule l'affichage
    }
  },
    fetchOfferDetails() {
      const offerId = this.$route.params.id;
      axios.get(`http://localhost:8000/api/show/offer/${offerId}`)
        .then(response => {
          this.offer = response.data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des détails de l\'offre:', error);
        });
    },
    fetchOfferActivities() {
      const offerId = this.$route.params.id;
      this.loadingActivities = true;
      this.activitiesError = null;
      axios.get(`http://localhost:8000/api/show/offer/activities/${offerId}`)
        .then(response => {
          console.log('Réponse des activités:', response.data);
          this.activities = response.data;
          this.loadingActivities = false;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des activités de l\'offre:', error);
          this.activitiesError = 'Erreur lors de la récupération des activités.';
        })
        .finally(() => {
          this.loadingActivities = false;
        });
    },
    fetchAvailableActivities() {
      axios.get('http://localhost:8000/api/show/activities')
        .then(response => {
          console.log('Réponse des activités disponibles:', response.data);
          this.availableActivities = response.data;
          this.showAvailableActivities = true; // Affiche automatiquement les activités après les avoir chargées

        })
        .catch(error => {
          console.error('Erreur lors de la récupération des activités disponibles:', error);
        });
    },
    openActivityForm(activity) {
      this.selectedActivity = activity;
      this.showActivityForm = true;
    },
    submitActivityForm() {
      const activityId = this.selectedActivity.id;
      const offerId = this.$route.params.id;
      axios.post(`http://localhost:8000/api/add/offer/activity/${offerId}/${activityId}`, this.formFields)
        .then(()=> {
          alert('Activité ajoutée avec succès!');
          this.fetchOfferActivities(); // Refresh activities
          this.showActivityForm = false;
          this.formFields = {}; // Reset form fields
        })
        .catch(error => {
          alert('Erreur lors de l\'ajout de l\'activité: ' + error.message);
        });
    },
    deleteOffer() {
      const offerId = this.$route.params.id;
      axios.delete(`http://localhost:8000/api/delete/offer/${offerId}`)
        .then(() => {
          alert('Offre supprimée avec succès');
          this.$router.push('/offers'); // Redirige vers la liste des offres après la suppression
        })
        .catch(error => {
          console.error('Erreur lors de la suppression de l\'offre:', error);
          alert('Erreur lors de la suppression de l\'offre');
        });
    },
    formatDate(date) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(date).toLocaleDateString('fr-FR', options);
    }
  }
};
</script>
<style scoped>
/* Styles généraux pour la mise en page */
.container {
  max-width: 1200px;
  margin: 20px auto;
  padding: 20px;
  background: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.text-center {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
  font-size: 1.8rem; /* Taille réduite pour les titres */
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
}

/* Style des détails de l'offre */
.offer-details {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.card {
  background: #f9f9f9;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
}

.card-title {
  font-size: 1.4rem; /* Taille réduite pour les titres de cartes */
  color: #333;
  margin-bottom: 10px;
}

.offer-info p, .activity-card p {
  font-size: 0.9rem; /* Réduction de la taille de la police pour les paragraphes */
  color: #666;
  padding: 5px 0;
}

/* Amélioration des images */
.offer-image img {
  width: 100%;
  max-height: 250px; /* Hauteur maximale réduite pour les images */
  object-fit: cover;
  border-radius: 8px;
}

/* Boutons et interactions */
.button-container {
  display: flex;
  justify-content: center;
  gap: 20px;
  margin-top: 20px;
}

/* Boutons réduits */
.btn, .btn-add-to-offer, .details-btn button {
  padding: 6px 12px;
  font-size: 0.8rem;
  border-radius: 4px;
}

.btn-activities {
  background-color: #007bff;
  color: white;
  border: none;
  padding: 6px 12px;
}

.btn-add-activity {
  background-color: #28a745;
  padding: 6px 12px;
}

.btn-delete {
  background-color: #dc3545;
  padding: 6px 12px;
}

/* Hover effects */
.btn:hover, .btn-add-to-offer:hover, .details-btn button:hover {
  background-color: #0056b3;
  opacity: 0.9;
}

.btn-delete:hover {
  background-color: #b02a37;
}

/* Modal et formulaires */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.6);
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  width: 90%;
  max-width: 450px; /* Largeur maximale réduite pour les contenus modaux */
}

/* Amélioration des cartes d'activité */
.activities, .available-activities {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 20px;
}

.activity-card, h3 {
  background: #f9f9f9;
  padding: 15px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.details-btn, .btn-add-to-offer {
  margin-top: 10px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  padding: 10px 15px;
}

.details-btn:hover, .btn-add-to-offer:hover {
  background-color: #0056b3;
}

/* Responsive design */
@media (max-width: 768px) {
  .button-container {
    flex-direction: column;
  }

  .btn {
    width: 100%;
    margin-top: 10px;
  }

  .activities, .available-activities {
    grid-template-columns: 1fr;
  }
}
</style>