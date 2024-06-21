<template>
  <NavbarElement />
  <div class="conteneurBienvenue">
    <div class="sectionTexte">
      <h1>Apprenez vos enfants Sans Limites</h1>
      <p>Commencez dès maintenant, inscrivez vos enfants à des activités enrichissantes, gérez les plannings et les paiements en toute simplicité.</p>
      <div>
        <button type="button" @click="InscriptionMethode" class="boutonInscription">Inscrivez-vous gratuitement</button>
        <button type="button" @click="ConnexionMethoode" class="boutonConnexion">Explorez les cours</button>
      </div>
    </div>
    <div class="sectionImage">
      <img src="@/assets/photo1.png" alt="Learning" class="imageBienvenue">
    </div>
  </div>
</template>

<script>
import NavbarElement from "@/components/NavBar.vue";

export default {
  name:'PageAccueil' ,
  components: {
    NavbarElement
  },
  methods: {
    InscriptionMethode() {
      this.$router.push('/InscriptionPage');
    },
    ConnexionMethoode() {
      this.$router.push('/ConnexionPage');
    }
  }
}
</script>

<style scoped>
.conteneurBienvenue {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 20px;
  background-color: #f0f8ff; /* Fond clair et doux */
  height: 100vh;
  background-size: cover;
  background-repeat: no-repeat;
}

.sectionTexte {
  flex: 1;
  max-width: 50%;
  padding-right: 50px;
}

h1 {
  font-size: 3rem;
  color: #4a90e2;
  font-family: 'Baloo Bhaijaan 2', cursive; /* Police adaptée aux enfants */
  margin-bottom: 20px;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
}

p {
  font-size: 1.5rem;
  color: #333;
  font-family: 'Baloo Bhaijaan 2', cursive;
  margin-bottom: 30px;
  line-height: 1.5;
}

.boutonInscription, .boutonConnexion {
  padding: 15px 30px;
  margin-top: 20px;
  border-radius: 10px;
  font-size: 1.2rem;
  font-weight: bold;
  cursor: pointer;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.boutonInscription {
  background-color: #ff6384;
  color: white;
}

.boutonConnexion {
  background-color: #36a2eb;
  color: white;
}

.boutonInscription:hover, .boutonConnexion:hover {
  transform: scale(1.05);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.sectionImage {
  flex: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.imageBienvenue {
  max-width: 80%;
  border-radius: 15px;
  object-fit: cover;
}

@media (max-width: 768px) {
  .conteneurBienvenue {
    flex-direction: column;
    text-align: center;
  }

  .sectionTexte, .sectionImage {
    max-width: 100%;
    padding: 0 20px;
  }

  .imageBienvenue {
    max-width: 100%;
    height: auto;
  }
}
</style>
