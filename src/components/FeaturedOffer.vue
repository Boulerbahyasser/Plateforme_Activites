<template>
  <div class="offer-container" v-if="offers.length">
    <button @click="prevOffer" class="nav-btn left-btn"></button>
    <transition name="fade" mode="out-in">
      <div class="offer-content" :key="currentOffer.id">
        <div class="text-section">
          <h2>{{ currentOffer.titre }}</h2>
          <p class="description">{{ currentOffer.description }}</p>
          <h3 class="remise">{{ currentOffer.remise }}% de remise</h3>
          <router-link :to="{ name: 'offerdetails', params: { id: currentOffer.id }}" class="btn">
            Inscrivez-vous à l'offre
          </router-link>
        </div>
        <div class="date-section">
          <div class="date">
            <span><strong>Date de début :</strong> {{ formatDate(currentOffer.date_debut) }}</span>
          </div>
          <div class="date">
            <span><strong>Date de fin :</strong> {{ formatDate(currentOffer.date_fin) }}</span>
          </div>
        </div>
        <div class="image-section">
          <img src="@/assets/child.png" alt="Offer Image" class="offer-image">
        </div>
      </div>
    </transition>
    <button @click="nextOffer" class="nav-btn right-btn"></button>
  </div>
  <div v-else class="loading-message">Chargement des offres...</div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      offers: [],
      currentIndex: 0,
      intervalId: null
    };
  },
  computed: {
    currentOffer() {
      return this.offers[this.currentIndex];
    }
  },
  created() {
    this.fetchOffers();
  },
  mounted() {
    this.intervalId = setInterval(this.nextOffer, 3000);
  },
  beforeUnmount() {
    clearInterval(this.intervalId);
  },
  methods: {
    fetchOffers() {
      axios.get('http://localhost:8000/api/show/offers/top/')
        .then(response => {
          this.offers = response.data;
        })
        .catch(error => {
          console.error('Erreur lors de la récupération des offres populaires:', error);
        });
    },
    nextOffer() {
      this.currentIndex = (this.currentIndex + 1) % this.offers.length;
    },
    prevOffer() {
      this.currentIndex = (this.currentIndex + this.offers.length - 1) % this.offers.length;
    },
    formatDate(dateString) {
      return dateString.split('T')[0];
    }
  }
}
</script>

<style scoped>
.offer-container {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #ffffff;
  height: auto;
  padding: 20px;
  border-radius: 15px;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out;
  position: relative;
  margin-top: 20px;
}

.offer-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.offer-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
}

.text-section {
  flex: 1;
  max-width: 40%;
  color: #333;
  text-align: left;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

h2 {
  font-size: 2.5rem;
  margin-bottom: 15px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  width: 100%;
}

.description {
  font-size: 1.2rem;
  margin-bottom: 20px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #666;
  max-height: 80px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.remise {
  font-size: 1.8rem;
  color: #010b46;
  font-weight: bold;
  margin-bottom: 20px;
}

.btn {
  padding: 12px 25px;
  background-color: #007bff;
  border-radius: 10px;
  font-size: 1.1rem;
  font-weight: bold;
  color: white;
  text-decoration: none;
  transition: background-color 0.3s;
  display: inline-block;
}

.btn:hover {
  background-color: #0056b3;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
}

.image-section {
  flex: 1;
  max-width: 30%;
  margin-right: 30px;
}

.offer-image {
  max-width: 100%;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.nav-btn {
  border: none;
  background: transparent;
  color: #007bff;
  font-size: 1.5rem;
  cursor: pointer;
  padding: 10px;
  transition: color 0.3s ease;
  position: absolute;
}

.left-btn {
  left: 20px;
}

.right-btn {
  right: 20px;
}

.nav-btn:hover {
  color: #0056b3;
}

.loading-message {
  text-align: center;
  font-size: 1.5rem;
  color: #333;
}

.date-section {
  flex: 1;
  text-align: left;
  margin-right: 30px;
  margin-left: 150px;
  margin-top: 180px;
  padding-top: 10px;
  display: flex;
  flex-direction: column;
}

.date {
  margin-bottom: 10px;
  display: flex;
  align-items: center;
}

.date h3, .date p {
  margin: 0 5px;
}

.date h3 {
  font-size: 1.2rem;
  color: #000325;
  font-weight: bold;
}

.date p {
  font-size: 1.2rem;
  color: #333;
}

/* Animation styles */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.5s ease-in-out;
}

.fade-enter, .fade-leave-to /* .fade-leave-active in <2.1.8 */ {
  opacity: 0;
}
</style>
