<template>
  <div class="faq-container">
    <h1>Foire aux Questions (FAQ)</h1>
    <div class="faq-item" v-for="(faq, index) in faqs" :key="index">
      <div class="faq-question" @click="toggleFaq(index)">
        <h3>{{ faq.question }}</h3>
        <i :class="{'fas fa-chevron-down': !faq.open, 'fas fa-chevron-up': faq.open}"></i>
      </div>
      <div class="faq-answer" v-show="faq.open">
        <p>{{ faq.answer }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FAQPage',
  data() {
    return {
      faqs: [
        { question: "Comment créer un compte ?", answer: "Pour créer un compte, cliquez sur le bouton 'S'inscrire' et remplissez le formulaire.", open: false },
        { question: "Comment réinitialiser mon mot de passe ?", answer: "Pour réinitialiser votre mot de passe, cliquez sur 'Mot de passe oublié' et suivez les instructions.", open: false },
        // Ajoutez plus de FAQ ici
      ]
    };
  },
  methods: {
    toggleFaq(index) {
      this.faqs[index].open = !this.faqs[index].open;
    }
  }
};
</script>

<style scoped>
.faq-container {
  max-width: 800px;
  margin: 40px auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h1 {
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #34495e;
  font-size: 2.5rem;
  margin-bottom: 20px;
}

.faq-item {
  margin-bottom: 20px;
}

.faq-question {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px;
  background: #fff;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  cursor: pointer;
  transition: background 0.3s;
}

.faq-question:hover {
  background: #eaf1f8;
}

.faq-question h3 {
  margin: 0;
  font-size: 1.2rem;
  color: #2c3e50;
}

.faq-question i {
  color: #3498db;
}

.faq-answer {
  padding: 15px;
  background: #fff;
  border-radius: 5px;
  margin-top: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  transition: max-height 0.3s ease-out;
}

.faq-answer p {
  margin: 0;
  font-size: 1rem;
  color: #7f8c8d;
}
</style>
