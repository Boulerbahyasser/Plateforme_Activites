<template>
  <div class="activities-list">
    <h3>Toutes les Activités</h3>
    <div class="search-box">
      <input type="text" v-model="searchQuery" placeholder="Rechercher des activités..." @input="searchActivities" class="search-input"/>
      <i class="fa-solid fa-magnifying-glass search-icon"></i>
    </div>
    <div v-if="loading" class="loader">Chargement des activités...</div>
    <div v-else>
      <div v-if="error" class="error-message">
        <p>Une erreur s'est produite lors du chargement des activités : {{ error }}</p>
        <button @click="fetchActivities">Réessayer</button>
      </div>
      <div v-else class="offers-grid">
        <div class="offer" v-for="activity in filteredActivities" :key="activity.id">
          <img :src="activity.image_pub" alt="Activity Image" class="offer-image">
          <div class="offer-details">
            <h4>{{ activity.titre }}</h4>
            <h4>{{ activity.objectif }}</h4>
            <h4>{{ activity.lien_youtube }}</h4>

            <p>{{ activity.description.slice(0, 10) }}...</p>
            <button class="btn btn-danger" @click="deleteActivity(activity.id)">Supprimer</button>

        </div>
      </div>  
    </div>
  </div>
  </div>
  <div class="pagination">
        <button @click="prevPage" :disabled="currentPage === 1">Précédent</button>
        <span>Page {{ currentPage }} sur {{ totalPages }}</span>
        <button @click="nextPage" :disabled="currentPage === totalPages">Suivant</button>
  </div>
  
</template>

<script>
import axios from 'axios'; // Importer axios si ce n'est pas déjà fait dans votre configuration globale

export default {
  name: 'ActivitiesList',
  data() {
    return {
      activities: [],
      loading: true,
      error: null,
      searchQuery: '',
      currentPage: 1,
      itemsPerPage: 8,
    }
  },
  computed: {
    filteredActivities() {
      const searchLower = this.searchQuery.toLowerCase();
      return this.activities.filter(activity =>
        activity.titre.toLowerCase().includes(searchLower) ||
        activity.description.toLowerCase().includes(searchLower)
      ).slice(this.startIndex, this.endIndex);
    },
    startIndex() {
      return (this.currentPage - 1) * this.itemsPerPage;
    },
    endIndex() {
      return this.currentPage * this.itemsPerPage;
    },
    totalPages() {
      return Math.ceil(this.activities.length / this.itemsPerPage);
    }
  },
  created() {
    this.fetchActivities();
  },
  methods: {
    fetchActivities() {
      this.loading = true;
      this.error = null;
      axios.get('http://localhost:8000/api/show/activities')
        .then(response => {
          this.activities = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('There was an error fetching the activities:', error);
          this.error = 'Impossible de charger les activités. Veuillez réessayer plus tard.';
          this.loading = false;
        });
    },
    searchActivities() {
      this.currentPage = 1;
    },
    nextPage() {
      if (this.currentPage < this.totalPages) {
        this.currentPage++;
      }
    },
    prevPage() {
      if (this.currentPage > 1) {
        this.currentPage--;
      }
    },
    deleteActivity(activityId) {
      axios.delete(`http://localhost:8000/api/delete/activity/${activityId}`)
        .then(() => {
          this.activities = this.activities.filter(activity => activity.id !== activityId);
          alert('Activité supprimée avec succès.');
        })
        .catch(error => {
          console.error('Erreur lors de la suppression de l\'activité:', error);
          alert('Échec de la suppression de l\'activité.');
        });
    }
  }
}
</script>

<style scoped>
.activities-list {
  background: #ffffff;
  padding: 20px;
  border-radius: 12px;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
  max-width: 1200px;
  margin-left: auto;
  margin-right: auto;
}

h3 {
  color: #333;
  font-family: 'Baloo Bhaijaan 2', cursive;
  font-size: 2rem;
  padding-bottom: 10px;
  border-bottom: 3px solid #eee;
  margin-bottom: 30px;
  text-align: center;
}

.loader {
  text-align: center;
  font-size: 1.2rem;
  margin: 20px 0;
}

.offers-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}

.offer {
  background: #f9f9f9;
  padding: 15px;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  justify-content: space-between; /* Assure une répartition égale de l'espace */
  height: 100%; /* Assure que toutes les cartes ont la même hauteur */
}

.offer:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.offer-image {
  width: 100%;
  height: auto;
  border-radius: 10px;
  margin-bottom: 10px;
  object-fit: cover;
}

.offer-details {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  height: 100%; /* Assurez-vous que le conteneur prend toute la hauteur pour pousser le bouton en bas */
}

.offer-details h4 {
  font-size: 1.2rem;
  margin-bottom: 10px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #333;
}

.offer-details p {
  font-size: 1rem;
  color: #666;
  margin-bottom: 10px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  flex-grow: 1;
}

.btn-primary {
  padding: 3px 10px;
  font-size: 1.2rem;
  border-radius: 8px;
  background-color: #007bff;
  color: white;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.search-box {
  position:relative;
  display:flex;
  align-items:center;
}

.search-input {
  padding: 10px;
  padding-right: 30px;
  border-radius: 5px;
  border: 1px solid #ddd;
  width: 100%;
}

.search-icon {
  position: absolute;
  right: 10px;
  color: #aaa;
  pointer-events: none;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items:center;
  margin-top: 20px;
}

.pagination button {
  padding: 10px 20px;
  margin: 0 5px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.pagination button:hover:not(:disabled) {
  background-color: #0056b3;
}
.btn-danger {
  background-color: #dc3545;
  width: 150px; /* Définissez la largeur souhaitée */

  color: white;
  border: none;
  padding: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-danger:hover {
  background-color: #c82333;
}
</style>
