<template>
  <div class="ConteneurInscription">
    <div class="sectionGauche">
      <img src="@/assets/child.png" alt="Image d'inscription" class="imageInscription">
    </div>
    <div class="sectionDroite">
      <div class="conteneurFormulaire">
        <img src="@/assets/logo2.png" alt="Logo de la plateforme" class="logoPlateforme">
        <h1>Inscription</h1>
        <form @submit.prevent="submitForm">

          <div class="groupeInput">
            <label for="name">Nom d'utilisateur</label>
            <input type="text" id="name" v-model="user.name" required>
          </div>

          <div class="groupeInput">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="user.email" @blur="validerEmail" required>
            <span v-if="emailError" class="erreur">{{ emailError }}</span>
          </div>

          <div class="groupeInput">
            <label for="password">Mot de passe</label>
            <div class="conteneurMotDePasse">
              <input :type="showPassword ? 'text' : 'password'" id="password" v-model="user.password" @blur="validerPassword" required>
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" @click="togglePasswordVisibility"></i>
            </div>
            <span v-if="passwordError" class="erreur">{{ passwordError }}</span>
          </div>

          <div class="groupeInput">
            <button type="submit" class="boutonSoumettre">S'inscrire</button>
          </div>

          <p class="dejaInscrit">Déjà inscrit ? <router-link to="/ConnexionPage">Connectez-vous</router-link></p>

        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'PageInscription',
  components: {},
  data() {
    return {
      user: {
        name: '',
        email: '',
        password: ''
      },
      emailError: '',
      passwordError: '',
      showPassword: false // Variable pour suivre l'état de la visibilité du mot de passe
    };
  },
  methods: {
    validerEmail() {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!re.test(this.user.email)) {
        this.emailError = 'Veuillez entrer un email valide';
      } else {
        this.emailError = '';
      }
    },
    validerPassword() {
      if (this.user.password.length < 8) {
        this.passwordError = 'Le mot de passe doit contenir au moins 8 caractères';
      } else {
        this.passwordError = '';
      }
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    submitForm() {
      this.validerEmail();
      this.validerPassword();
      if (this.emailError || this.passwordError) {
        return;
      }
      axios.post('http://localhost:8000/api/register-parent', this.user)
        .then(response => {
          alert('Inscription réussie!');
          console.log(response.data);
          this.$router.push('/ConnexionPage');
        })
        .catch(error => {
          console.error('Erreur lors de l\'inscription:', error);
          alert(error.response.data.message);
        });
    }
  }
};
</script>

<style scoped>
.ConteneurInscription {
  display: flex;
  height: 100vh;
  background-color: #f0f2f5;
}

.sectionGauche {
  flex: 0 0 63%; /* Prend 40% de l'espace */
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
  flex: 0 0 37%; /* Prend 60% de l'espace */
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
}

.logoPlateforme {
  width: 150px;
  margin-bottom: 20px;
  margin-left: 28%;
}

h1 {
  color: #333;
  margin-bottom: 20px;
}

.groupeInput {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #333;
  font-weight: 600;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
  transition: border-color 0.2s, box-shadow 0.2s;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  border-color: #3498db;
  box-shadow: 0 0 8px rgba(50, 150, 250, 0.3);
}

.conteneurMotDePasse {
  position: relative;
  display: flex;
  align-items: center;
}

.conteneurMotDePasse i {
  position: absolute;
  right: 10px;
  cursor: pointer;
  color: #3498db;
}

button.boutonSoumettre {
  width: 100%;
  padding: 10px 20px;
  border: none;
  background-color: #3498db;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  transition: background-color 0.3s, box-shadow 0.3s;
}

button.boutonSoumettre:hover {
  background-color: #2980b9;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

button.boutonSoumettre:active {
  background-color: #2575b5;
}

.dejaInscrit {
  text-align: center;
  margin-top: 15px;
  color: #666;
}

.dejaInscrit a {
  color: #2980b9;
  text-decoration: none;
}

.dejaInscrit a:hover {
  text-decoration: underline;
}

.erreur {
  color: red;
  font-size: 0.9em;
}
</style>
