<template>
  <div class="ConteneurResetMotDePasse">
    <div class="sectionGauche">
      <img src="@/assets/child.png" alt="Image d'inscription" class="imageInscription">
    </div>
    <div class="sectionDroite">
      <div class="conteneurFormulaire">
        <div class="conteneurLogo">
          <img src="@/assets/logo2.png" alt="Logo de la plateforme" class="logoPlateforme">
        </div>
        <h1>Mot de passe oublié</h1>
        <form @submit.prevent="submitForm">
          <div class="groupeInput">
            <label for="email">Email:</label>
            <input type="email" id="email" v-model="email" required>
          </div>
          <div class="groupeInput">
            <button type="submit">Réinitialiser le mot de passe</button>
          </div>
          <p class="already-registered">
            <router-link to="/signin">Retour à la connexion</router-link>
          </p>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/axios';

export default {
  name: 'ForgetPassword',
  components: {  },
  data() {
    return {
      email: ''
    };
  },
  methods: {
    submitForm() {
      axios.post('http://localhost:8000/api/forget-password', { email: this.email })
        .then(response => {
          alert('Un email de réinitialisation a été envoyé!');
          console.log(response.data);
          this.$router.push('/signin');
        })
        .catch(error => {
          console.error('Erreur lors de la réinitialisation du mot de passe:', error);
          console.log(error.response.data.message);
          alert(error.response.data.message);
        });
    }
  }
};
</script>

<style scoped>
.ConteneurResetMotDePasse {
  display: flex;
  height: 100vh;
  background-color: #f0f2f5;
}

.sectionGauche {
  flex: 0 0 63%; /* Prend 60% de l'espace */
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #ffffff;
}

.imageInscription {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.sectionDroite {
  flex: 0 0 37%; /* Prend 40% de l'espace */
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #ffffff;
}

.conteneurFormulaire {
  width: 80%;
  max-width: 450px;
  background-color: #ffffff;
  padding: 40px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.conteneurLogo {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin-bottom: 20px;
}

.logoPlateforme {
  width: 150px;
}

h1 {
  color: #333;
  margin-bottom: 20px;
}

.groupeInput {
  margin-bottom: 20px;
  width: 100%;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #333;
  font-weight: 600;
}


input[type="password"],
input[type="text"],
input[type="email"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: border-color 0.2s, box-shadow 0.2s;
}

input[type="password"],
input[type="text"],
input[type="email"]:focus {
  border-color: #3498db;
  box-shadow: 0 0 8px rgba(50, 150, 250, 0.3);
}

button {
  padding: 10px 20px;
  border: none;
  background-color: #3498db;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  transition: background-color 0.3s, box-shadow 0.3s;
}

button:hover {
  background-color: #2980b9;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

button:active {
  background-color: #2575b5;
}

.already-registered {
  text-align: center;
  margin-top: 15px;
  color: #666;
}

.already-registered a {
  color: #2980b9;
  text-decoration: none;
}

.already-registered a:hover {
  text-decoration: underline;
}
</style>
