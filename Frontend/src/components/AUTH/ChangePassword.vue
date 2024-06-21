<template>
  <div class="ConteneurChangementMotDePasse">
    <div class="SectionGauche">
      <img src="../../assets/child.png" alt="Image de changement de mot de passe" class="ImageConnexion">
    </div>
    <div class="SectionDroite">
      <div class="ConteneurFormulaire">
        <img src="../../assets/logo2.png" alt="Logo de la plateforme" class="LogoPlateforme">
        <h1>Changer le Mot de Passe</h1>
        <form @submit.prevent="submitForm">
          <div class="GroupeInput">
            <label for="newPassword"><i class="fas fa-lock-open"></i> Nouveau Mot de Passe</label>
            <div class="ConteneurMotDePasse">
              <input :type="showPassword ? 'text' : 'password'" id="newPassword" v-model="passwords.password" required>
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" @click="togglePasswordVisibility"></i>
            </div>
          </div>
          <div class="GroupeInput">
            <label for="confirmPassword"><i class="fas fa-lock"></i> Confirmer Nouveau Mot de Passe</label>
            <div class="ConteneurMotDePasse">
              <input :type="showPassword ? 'text' : 'password'" id="confirmPassword" v-model="passwords.password_confirmation" required>
              <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" @click="togglePasswordVisibility"></i>
            </div>
          </div>
          <div class="GroupeInput">
            <button type="submit" class="BoutonSoumettre">Changer Mot de Passe</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '@/axios';

export default {
  data() {
    return {
      passwords: {
        password: '',
        password_confirmation: ''
      },
      showPassword: false,
      token: null,
    };
  },
  mounted() {
    const url = window.location.href;
    const token = url.substring(url.lastIndexOf('/') + 1);
    this.token = token;
  },
  methods: {
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    submitForm() {
      this.changePassword(this.token);
    },
    changePassword(token) {
      if (!token) {
        alert("Token non trouvé dans l'URL.");
        return;
      }
      if (this.passwords.password !== this.passwords.password_confirmation) {
        alert("Les mots de passe ne correspondent pas.");
        return;
      }
      axios.post(`http://localhost:8000/api/reset-password/${token}`, this.passwords)
        .then(response => {
          alert(response.data.message);
          this.$router.push('/ConnexionPage');
        })
        .catch(error => {
          console.error('Erreur de réinitialisation du mot de passe:', error);
          alert(error.response.data.message);
        });
    }
  }
}
</script>

<style scoped>
.ConteneurChangementMotDePasse {
  display: flex;
  height: 100vh;
  background-color: #f0f2f5;
}

.SectionGauche {
  flex: 0 0 63%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #ffffff;
}

.ImageConnexion {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.SectionDroite {
  flex: 0 0 37%;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: #ffffff;
}

.LogoPlateforme {
  width: 150px;
  margin-bottom: 20px;
  margin-left: 28%;
}

.ConteneurFormulaire {
  width: 80%;
  max-width: 450px;
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

.GroupeInput {
  margin-bottom: 25px;
}

label {
  display: block;
  margin-bottom: 5px;
  color: #333;
  font-weight: 600;
}

.ConteneurMotDePasse {
  position: relative;
  display: flex;
  align-items: center;
}

.ConteneurMotDePasse i {
  position: absolute;
  right: 10px;
  cursor: pointer;
  color: #3498db;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 15px;
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

button.BoutonSoumettre {
  width: 100%;
  padding: 15px 20px;
  border: none;
  background-color: #3498db;
  color: white;
  border-radius: 5px;
  cursor: pointer;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
  transition: background-color 0.3s, box-shadow 0.3s;
}

button.BoutonSoumettre:hover {
  background-color: #2980b9;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
}

button.BoutonSoumettre:active {
  background-color: #2575b5;
}
</style>
