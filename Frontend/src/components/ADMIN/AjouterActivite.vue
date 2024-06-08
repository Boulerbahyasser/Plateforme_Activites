<template>
  <div class="container">
    <h2 class="text-center">Ajouter une Activité</h2>
    <form @submit.prevent="submitForm" class="form">
      <div class="form-group">
        <label for="titre">Titre de l'activité:</label>
        <input type="text" id="titre" v-model="activite.titre" required class="form-control" />
      </div>
      <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" v-model="activite.description" required class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="objectifs">Objectifs:</label>
        <textarea id="objectifs" v-model="activite.objectifs" required class="form-control"></textarea>
      </div>
      <div class="form-group">
        <label for="domaine">Domaine:</label>
        <input type="text" id="domaine" v-model="activite.domaine" required class="form-control" />
      </div>
      <div class="form-group">
        <label for="image">Image:</label>
        <input type="file" id="image" @change="handleFileUpload" required class="form-control" ref="image" />
      </div>
      <div class="form-group">
        <label for="lien_youtube">Lien YouTube:</label>
        <input type="text" id="lien_youtube" v-model="activite.lien_youtube" class="form-control" />
      </div>
      <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
    <div v-if="message" class="message">
      <p>{{ message }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AjouterActivite',
  data() {
    return {
      activite: {
        titre: '',
        description: '',
        objectifs: '',
        domaine: '',
        lien_youtube: ''
      },
      image_pub: null,
      message: ''
    };
  },
  methods: {
    handleFileUpload(event) {
      this.image_pub = event.target.files[0];
    },
    submitForm() {
      const formData = new FormData();
      formData.append('titre', this.activite.titre);
      formData.append('description', this.activite.description);
      formData.append('objectifs', this.activite.objectifs);
      formData.append('domaine', this.activite.domaine);
      formData.append('lien_youtube', this.activite.lien_youtube);
      if (this.image_pub) {
        formData.append('image_pub', this.image_pub);
      }

      axios.post('http://localhost:8000/api/create/activity/', formData)
        .then(response => {
          console.log('Activité ajoutée:', response.data);
          this.message = 'Activité ajoutée avec succès!';
          this.activite = {
            titre: '',
            description: '',
            objectifs: '',
            domaine: '',
            lien_youtube: ''
          };
          this.image_pub = null;
          this.$refs.image.value = '';
          this.$router.push('/AdminPgae');
        })
        .catch(error => {
          console.error('Erreur lors de l\'ajout de l\'activité:', error.response.data);
          this.message = 'Erreur lors de l\'ajout de l\'activité : ' + error.response.data.detail;
        });
    }
  }
};
</script>

<style scoped>
.container {
  max-width: 600px;
  margin: 0 auto;
  padding: 20px;
  background: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.text-center {
  text-align: center;
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
.form-group label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}
.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.btn {
  display: block;
  width: 100%;
  padding: 10px;
  background: #007BFF;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 16px;
}
.btn:hover {
  background: #0056b3;
}
.message {
  margin-top: 20px;
  text-align: center;
  font-size: 1.2rem;
  color: #d9534f;
}
</style>
