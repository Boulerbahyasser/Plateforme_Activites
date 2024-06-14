<template>
  <NavBar/>
  <div class="about-us">
    <div class="header-section">
      <h1>À propos de nous</h1>
      <p>Bienvenue sur notre plateforme dédiée à l'épanouissement et au développement personnel des enfants.</p>
    </div>
    <div class="mission-section">
      <h2>Notre Mission</h2>
      <p>Notre mission est de fournir un environnement sûr et stimulant où les enfants peuvent apprendre, jouer et grandir. Nous croyons que chaque enfant a un potentiel unique et  nous efforçons de les aider à le réaliser pleinement.</p>
    </div>
    <div class="values-section">
      <h2>Nos Valeurs</h2>
      <ul>
        <li><strong>Éducation:</strong> Offrir des activités éducatives de haute qualité.</li>
        <li><strong>Sécurité:</strong> Assurer un environnement sûr pour tous les enfants.</li>
        <li><strong>Inclusivité:</strong> Accueillir tous les enfants, quelles que soient leurs origines ou leurs capacités.</li>
        <li><strong>Innovation:</strong> Utiliser des méthodes et des outils innovants pour l'apprentissage.</li>
      </ul>
    </div>
    <div class="team-section">
      <h2>Notre Équipe</h2>
      <p>Notre équipe est composée de professionnels passionnés par l'éducation et le développement des enfants. Nous travaillons ensemble pour créer les meilleures expériences possibles pour nos jeunes participants.</p>
    </div>
  </div>
</template>
<script>
import NavBar from "@/components/NavBar.vue";

export default {
  name: 'AboutUs',
  components: { NavBar }
};
</script>
<style scoped>
.about-us {
  padding: 40px;
  max-width: 800px;
  margin: 0 auto;
  font-family: Arial, sans-serif;
  line-height: 1.6;
}

.header-section {
  text-align: center;
  margin-bottom: 40px;
}

.header-section h1 {
  font-size: 2.5rem;
  color: #0056b3;
}

.header-section p {
  font-size: 1.2rem;
  color: #333;
}

.mission-section, .values-section, .team-section {
  margin-bottom: 30px;
}

.history-section h2, .mission-section h2, .values-section h2, .team-section h2 {
  font-size: 2rem;
  color: #0056b3;
  margin-bottom: 15px;
}

.values-section ul {
  list-style: none;
  padding: 0;
}

.values-section li {
  background: #f0f0f0;
  margin: 10px 0;
  padding: 10px;
  border-radius: 5px;
  font-size: 1rem;
}

.values-section li strong {
  color: #007BFF;
}

.values-section li:before {
  content: "•";
  color: #0056b3;
  font-weight: bold;
  display: inline-block;
  width: 1em;
  margin-left: -1em;
}

p {
  color: #333;
  font-size: 1.1rem;
}
</style>
