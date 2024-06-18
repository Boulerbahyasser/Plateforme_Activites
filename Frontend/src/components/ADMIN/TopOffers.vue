<template>
  <div class="top-offers">
    <h3>Offres Top</h3>
    <div v-if="loading" class="loader">Chargement des offres...</div>
    <div v-else>
      <div v-if="error" class="error-message">
        <p>Une erreur s'est produite lors du chargement des offres : {{ error }}</p>
      </div>
      <div v-else class="offers-grid">
        <div class="offer" v-for="offer in offers" :key="offer.id">
          <img src="@/assets/child.png" alt="Offer Image" class="offer-image">
          <div class="offer-details">
            <h4>{{ offer.titre }}</h4>
            <p>{{ offer.description.slice(0, 100) }}...</p>
            <router-link :to="{ name: 'OfferDetailsAdmin', params: { id: offer.id }}">
              <button type="button" class="btn btn-primary">détails</button>
            </router-link>
          </div> 
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/axios';

export default {
  name: 'TopOffers',
  data() {
    return {
      offers: [],
      loading: true,
      error: null,
    }
  },
  created() {
    this.fetchTopOffers();
  },
  methods: {
    fetchTopOffers() {
      axios.get('http://localhost:8000/api/show/offers/top/')
        .then(response => {
          this.offers = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('There was an error fetching the top offers:', error);
          this.error = 'Impossible de charger les offres top. Veuillez réessayer plus tard.';
          this.loading = false;
        });
    },
  }
}
</script>

<style scoped>
.top-offers {
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
  text-align: center;
  display: flex;
  flex-direction: column;
  flex-grow: 1;
  justify-content: space-between;
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
</style>
