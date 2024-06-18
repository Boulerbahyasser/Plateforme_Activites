<template>
  <div class="animateurs-container">
    <h2 class="h2">Animateurs</h2>
    <div v-if="loading" class="loading">Chargement...</div>
    <div v-else-if="error" class="error">{{error}}</div>
    <button @click="showAddForm = true" class="btn btn-primary">Ajouter Animateur</button>
    <div v-if="showAddForm" class="add-animateur-form">
  <form @submit.prevent="addAnimateur" class="animateur-form">
    <div class="form-group">
      <input type="text" v-model="newAnimateur.name" placeholder="Nom de l'animateur" required>
    </div>
    <div class="form-group">
      <input type="email" v-model="newAnimateur.email" placeholder="Email" required>
    </div>
    <div class="form-group">
      <input type="text" v-pencil.on="newAnimateur.domaine" placeholder="Domaine" required>
    </div>
    <div class="form-group">
      <input type="password" v-model="newAnimateur.password" placeholder="Mot de passe" required>
    </div>
    <div class="form-buttons">
      <button type="submit" class="btn btn-success">Enregistrer</button>
      <button @click="showAddForm = false" class="btn btn-warning">Annuler</button>
    </div>
  </form>
</div>
    <table class="animateurs-table">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Domaine</th>
          <th>Horaires </th>
          <th>Horaires Occupés</th>
          <th>Horaires Libres</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="animateur in animateurs" :key="animateur.id">
          <td>{{ animateur.name }}</td>
          <td>{{ animateur.email }}</td>
          <td>{{ animateur.domaine }}</td>
          <td><button @click="fetchHoraires(animateur.id)" class="table-button">Afficher Horaires</button></td>
          <td><button @click="fetchBusyHoraires(animateur.id)" class="table-button">Afficher Horaires Occupés</button></td>
          <td><button @click="fetchavailableHoraires(animateur.id)" class="table-button">Afficher Horaires disponible</button></td>
        </tr>
      </tbody>
    </table>
    <div v-if="selectedHoraires.length" class="modal">
      <h2 class="h2">Horaires</h2>
      <table class="horaires-table">
        <thead>
          <tr>
            <th>Jour</th>
            <th>Heure de début</th>
            <th>Heure de fin</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="horaire in selectedHoraires" :key="horaire.id">
            <td>{{ horaire.jour }}</td>
            <td>{{ horaire.heure_debut }}</td>
            <td>{{ horaire.heure_fin }}</td>
          </tr>
        </tbody>
      </table>
      <button @click="selectedHoraires = []">Fermer</button>
    </div>
  </div>
</template>


<script>
import axios from '@/axios';

export default {
  name: 'AnimateursList',
  data() {
    return {
      animateurs: [],
      loading: false,
      error: null,
      selectedHoraires: [],
      showAddForm: false, // Contrôle l'affichage du formulaire d'ajout
      newAnimateur: { // Modèle pour le nouvel animateur
        name: '',
        email: '',
        domaine: '',
        password: ''
      }
    };
  },
  created() {
    this.fetchAnimateurs();
  },
  methods: {
    fetchAnimateurs() {
      this.loading = true;
      axios.get('/api/show/animateurs/')
        .then(response => {
          this.animateurs = response.data;
          this.loading = false;
        })
        .catch(error => {
          console.error("Error fetching animateur", error);
          this.error = "Une erreur est survenue lors du chargement des animateurs";
          this.loading = false;
        });
    },
    fetchHoraires(animId) {
      axios.get(`http://localhost:8000/api/show/all/horaires/animateur/${animId}`)
        .then(response => {
          this.selectedHoraires = response.data;
        })
        .catch(error => {
          console.error("Error fetching horaires:", error);
          this.error = "Une erreur est survenue lors du chargement des horaires";
        });
    },
    fetchBusyHoraires(animId) {
    axios.get(`http://localhost:8000/api/show/busy/horaires/animateur/${animId}`)
      .then(response => {
        this.selectedHoraires = response.data;
      })
      .catch(error => {
        console.error("Error fetching busy horaires:", error);
        this.error = "Une erreur est survenue lors du chargement des horaires occupés";
      });
  },
  fetchavailableHoraires(animId){
    axios.get(`http://localhost:8000/api/show/available/horaires/animateur/${animId}`)
      .then(response => {
        this.selectedHoraires = response.data;
      })
      .catch(error => {
        console.error("Error fetching available horaires:", error);
        this.error = "Une erreur est survenue lors du chargement des horaires occupés";
      });
  },addAnimateur() {
      axios.post('/api/register-animateur', this.newAnimateur)
        .then(response => {
          this.animateurs.push(response.data);
          this.newAnimateur = { name: '', email: '', domaine: '',password:''};
          this.showAddForm = false; // Fermer le formulaire après l'ajout
          this.fetchAnimateurs(); // Rafraîchir la liste des animateurs
        })
        .catch(error => {
    if (error.response && error.response.status === 422) {
      console.error("Erreur de validation: ", error.response.data);
      // Traiter les détails de l'erreur
    } else {
      console.error("Erreur réseau ou serveur: ", error);
    }
  });
    }
  
  }
};
</script>


<style scoped>
.animateurs-container {
  text-align: center;
  padding: 20px;
}

.animateurs-table {
  width: 100%;
  border-collapse: collapse;
  margin: 20px auto;
  box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.animateurs-table th, .animateurs-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.animateurs-table th {
  background-color: #0056b3;
  color: white;
}

.animateurs-table tbody tr:hover {
  background-color: #f5f5f5;
}

.loading, .error {
  margin-top: 20px;

}
.h2{
  font-size: 1.2rem;
  margin-bottom: 10px;
  font-family: 'Baloo Bhaijaan 2', cursive;
  color: #333;
}
.modal {
  position: fixed;
  top: 30%;
  left: 50%;
  transform: translate(-50%, -50%);
  background-color: white;
  padding: 20px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  z-index: 1050;
  width: 40%;
  max-width: 400px;
  display: flex;
  flex-direction: column;
  align-items: center;

}

.modal h2 {
  margin-top: 0;
  width: 100%;
}

.horaires-table {
  width: 100%;
  margin-top: 10px;
}

.horaires-table th, .horaires-table td {
  color: #0056b3;
  text-align: left;
  border: 1px solid #ddd; /* Assure que les bordures sont visibles */
  padding: 8px; /* Ajustement des paddings pour plus de clarté */
}

.horaires-table th {
  background-color: #0056b3; /* Fond plus foncé pour le contraste */
  color: white;
}

.horaires-table tbody tr:nth-child(odd) {
  background-color: #f2f2f2; /* Alternance des couleurs pour une meilleure lisibilité */
}

.modal button {
  padding: 10px;
  margin-top: 20px;
  width: 100%; /* Assurez que le bouton occupe toute la largeur pour une symétrie */
  background-color: #0056b3; /* Couleur cohérente avec le tableau */
  color: white;
  border: none;
  cursor: pointer;
  border-radius: 5px; /* Boutons arrondis pour un look moderne */
}
.table-button {
  padding: 6px 12px; /* Réduction du padding */
  font-size: 12px; /* Réduction de la taille de la police */
  background-color: #007BFF; /* Couleur de fond */
  color: white; /* Couleur du texte */
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.table-button:hover {
  background-color: #0056b3; /* Couleur de fond au survol */
}
.add-animateur-form {
  background: #f9f9f9;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  margin-top: 20px;
}

.form-group {
  margin-bottom: 10px;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  transition: border-color 0.3s;
}

.form-group input:focus {
  border-color: #0056b3;
  outline: none;
}

.form-buttons button {
  padding: 10px 15px;
  margin-right: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.btn-success {
  background-color: #28a745;
  color: white;
}

.btn-success:hover {
  background-color: #218838;
}

.btn-warning {
  background-color: #ffc107;
  color: white;
}

.btn-warning:hover {
  background-color: #e0a800;
}
</style>
