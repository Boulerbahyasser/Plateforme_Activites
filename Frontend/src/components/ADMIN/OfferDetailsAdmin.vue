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

    <div class="activities-section">
      <button @click="fetchOfferActivities" class="btn-activities">Afficher les activités</button>
      <div v-if="loadingActivities" class="loading">
        <p>Chargement des activités...</p>
      </div>
      <div v-if="activitiesError" class="error">
        <p>{{ activitiesError }}</p>
      </div>
      <div v-if="activities.length" class="activities">
        <h3>Activités associées</h3>
        <div v-for="activity in activities" :key="activity.id" class="activity-card card">
          <p><strong>Tarif :</strong> {{ activity.tarif }}</p>
          <p><strong>Âge minimum :</strong> {{ activity.age_min }}</p>
          <p><strong>Âge maximum :</strong> {{ activity.age_max }}</p>
          <p><strong>Nombre de séances :</strong> {{ activity.nbr_seance }}</p>
          <p><strong>Volume horaire :</strong> {{ activity.volume_horaire }}</p>
          <p><strong>Option de paiement :</strong> {{ activity.option_paiement }}</p>
        </div>
      </div>
    </div>

    <button @click="fetchAvailableActivities" class="btn-add-activity">Ajouter une activité</button>
    <div v-if="availableActivities.length" class="available-activities">
      <h3>Activités disponibles</h3>
      <div v-for="activity in availableActivities" :key="activity.id" class="activity-card card">
        <p><strong>Tarif :</strong> {{ activity.tarif }}</p>
        <p><strong>Description :</strong> {{ activity.description}}</p>
        <p><strong>Âge minimum :</strong> {{ activity.age_min }}</p>
        <p><strong>Âge maximum :</strong> {{ activity.age_max }}</p>
        <p><strong>Nombre de séances :</strong> {{ activity.nbr_seance }}</p>
        <p><strong>Volume horaire :</strong> {{ activity.volume_horaire }}</p>
        <p><strong>Option de paiement :</strong> {{ activity.option_paiement }}</p>
        <button @click="addActivityToOffer(activity.id)" class="btn-add-to-offer">Ajouter à l'offre</button>
      </div>
    </div>

    <button @click="deleteOffer" class="btn-delete">Supprimer l'offre</button>
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
      activitiesError: null
    };
  },
  created() {
    this.fetchOfferDetails();
  },
  methods: {
    fetchOfferDetails() {
      const offerId = this.$route.params.id;
      axios.get(`http://localhost:8000/api/show/offer/${offerId}`)
        .then(response => {
          this.offer = response.data;
          if (!this.offer.activities) {
            this.offer.activities = [];
          }
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
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des activités disponibles:', error);
        });
    },
    addActivityToOffer(activityId) {
      const offerId = this.$route.params.id;
      axios.post(`http://localhost:8000/api/add/offer/activity/${offerId}/${activityId}`)
        .then(() => {
          alert('Activité ajoutée à l\'offre avec succès');
          this.fetchOfferActivities(); // Refresh the list of activities for the offer
        })
        .catch(error => {
          console.error('Erreur lors de l\'ajout de l\'activité à l\'offre:', error);
          alert('Erreur lors de l\'ajout de l\'activité à l\'offre');
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
.container {
  max-width: 900px;
  margin: 20px auto;
  padding: 20px;
  background: #f7f7f7;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.text-center {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
  font-size: 2rem;
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
}

.offer-details {
  display: flex;
  flex-wrap: wrap;
  gap: 20px;
  margin-bottom: 20px;
}

.card {
  background: #fff;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  flex: 1;
}

.card-title {
  font-size: 1.5rem;
  color: #333;
  margin-bottom: 10px;
}

.offer-info p, .activity-card p {
  font-size: 1rem;
  color: #555;
  margin-bottom: 8px;
}

.offer-image img {
  max-width: 100%;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.activities-section {
  margin-top: 20px;
}

.btn-activities, .btn-add-activity, .btn-delete, .btn-add-to-offer {
  display: block;
  margin: 10px auto;
  padding: 10px 20px;
  background: #007bff;
  color: #fff;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-size: 1rem;
  text-transform: uppercase;
}

.btn-add-activity {
  background: #28a745;
}

.btn-delete {
  background: #ff0000;
}

.btn-add-to-offer {
  background: #17a2b8;
  margin-top: 10px;
}

.btn-activities:hover, .btn-add-activity:hover, .btn-delete:hover, .btn-add-to-offer:hover {
  opacity: 0.9;
}

.activities {
  margin-top: 20px;
}

.activities h3 {
  color: #333;
  font-size: 1.5rem;
  margin-bottom: 10px;
  text-align: center;
}

.activity-card {
  margin-bottom: 20px;
}

.loading, .no-activities, .error {
  text-align: center;
  color: #999;
  font-size: 1.2rem;
}

.error {
  color:red;
}
</style>
