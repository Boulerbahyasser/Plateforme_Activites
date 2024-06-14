<template>
  <div class="conteneurConnexion">
    <div class="sectionGauche">
      <img src="@/assets/child.png" alt="Image de connexion" class="imageConnexion">
    </div>
    <div class="sectionDroite">
      <div class="conteneurFormulaire">
        <h1>Connexion</h1>
        <form @submit.prevent="submitForm">
          <div class="groupeInput">
            <label for="email">Email</label>
            <input type="email" id="email" v-model="user.email" @blur="validateEmail" required>
            <span v-if="emailError" class="erreur">{{ emailError }}</span>
          </div>
          <div class="groupeInput">
            <label for="password">Mot de passe</label>
            <div class="conteneurMotDePasse">
              <input :type="showPassword ? 'text' : 'password'" id="password" v-model="user.password" @blur="validatePassword" required>
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" @click="togglePasswordVisibility"></i>
            </div>
            <span v-if="passwordError" class="erreur">{{ passwordError }}</span>
          </div>
          <div class="groupeInput">
            <button type="submit" class="boutonSoumettre">Se connecter</button>
          </div>
        </form>
        <p class="motDePasseOublie">
          <router-link to="/forgetpassword">Mot de passe oublié ?</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "@/axios";
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;

async function getCSRFToken() {
    try {
        await axios.get('http://localhost:8000/sanctum/csrf-cookie');

    } catch (error) {
        console.error('Failed to fetch CSRF token:', error);
    }
}

export default {
  name: 'PageConnexion',
  components: {
  },
  data() {
    return {
      user: {
        email: '',
        password: ''
      },
      emailError: '',
      passwordError: '',
      showPassword: false // Variable pour suivre l'état de la visibilité du mot de passe
    };
  },
  methods: {
    validateEmail() {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!re.test(this.user.email)) {
        this.emailError = 'Veuillez entrer un email valide';
      } else {
        this.emailError = '';
      }
    },
    validatePassword() {
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
      this.validateEmail();
      this.validatePassword();
      if (this.emailError || this.passwordError) {
        return;
      }
      getCSRFToken().then(()=>{

          axios.post('http://localhost:8000/api/login', this.user).then(response => {

          const token = response.data.token;

          // document.cookie = 'auth_token=' + token + '; HttpOnly';// quand ajouter HttpOnly la token pas voir dans cookies
          localStorage.setItem('auth_token', response.data.token);
          axios.defaults.headers.common[`Authorization`] = `Bearer ${token}`;
          alert('Connexion réussie!');
          this.$router.push('/offerspage');
          })
          .catch(error => {
          console.error('Erreur de connexion:', error);
          alert(error.response.data.message);
          });

      })
    }
  }
};
</script>

<style scoped>
.conteneurConnexion {
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

.imageConnexion {
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
  width: 80%; /* Augmenter la largeur */
  max-width: 500px; /* Augmenter la largeur maximale */
  background-color: #ffffff;
  padding: 40px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.groupeInput {
  margin-bottom: 25px; /* Augmenter la marge entre les groupes d'input */
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
  padding: 15px; /* Augmenter le padding */
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
  padding: 15px 20px; /* Augmenter le padding */
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

.motDePasseOublie {
  text-align: center;
  margin-top: 15px;
  color: #666;
}

.motDePasseOublie a {
  color: #2980b9;
  text-decoration: none;
}

.motDePasseOublie a:hover {
  text-decoration: underline;
}

.erreur {
  color: red;
  font-size: 0.9em;
}
</style>
