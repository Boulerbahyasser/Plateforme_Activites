<template>
  <div class="offers-list">
    <h3>Toutes les Offres</h3>
    <div v-if="loading" class="loading">
      Chargement des offres...
    </div>
    <div v-else class="offer" v-for="offer in offers" :key="offer.id">
      <img :src="require('@/assets/child.png')" alt="Offer Image" class="offer-image">
      <div class="offer-details">
        <p>{{ offer.description }}</p>
        <router-link :to="{ name: 'OffersDetailsAdmin', params: { id: offer.id } }" class="btn btn-primary">Détails</router-link>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'OffersListAdmin',
  data() {
    return {
      offers: [],
      loading: true
    }
  },
  created() {
    this.fetchOffers();
  },
  methods: {
    fetchOffers() {
      this.loading = true;
      axios.get('http://localhost:8000/api/show/offers/')
        .then(response => {
          this.offers = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error('There was an error fetching the offers:', error);
          this.loading = false;
        });
    }
  }
}
</script>

<style scoped>
.offers-list {
  background: #f9fafc;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.loading {
  text-align: center;
  color: #999;
  font-size: 1.2rem;
}

.offer {
  display: flex;
  align-items: flex-start;
  margin-bottom: 20px;
  padding: 20px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  transition: transform 0.3s, box-shadow 0.3s;
}

.offer:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.offer-image {
  width: 150px;
  height: 100px;
  object-fit: cover;
  margin-right: 20px;
  border-radius: 8px;
}

.offer-details {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
}

.offer-text {
  flex: 1;
}

.offer-details h4 {
  font-size: 1.6rem;
  color: #333;
  margin-bottom: 10px;
}

.offer-details p {
  font-size: 1.2rem;
  color: #555;
  margin-bottom: 15px;
}

.details-btn {
  padding: 10px 15px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s;
  margin-left: 20px;
}

.details-btn:hover {
  background-color: #0056b3;
}

h3 {
  color: #333;
  font-size: 2.5rem;
  margin-bottom: 20px;
  text-align: center;
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  background: linear-gradient(to right, #007bff, #00c6ff);
  -webkit-background-clip: text;
  color: transparent;
}
</style>
