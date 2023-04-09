<template>
  <div>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <form @submit.prevent="saveData">
        <div v-for="(field, index) in fields" :key="index">
          <label :for="field.name">{{ field.label }}</label>
          <input
            :type="field.type"
            :name="field.name"
            :id="field.name"
            v-model="formData[field.name]"
          />
        </div>
        <button type="submit">Save</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      loading: true,
      formData: {},
      fields: [
        { name: 'title', label: 'Title', type: 'text' },
        { name: 'description', label: 'Description', type: 'text' },
        { name: 'button_text', label: 'Button Text', type: 'text' },
        { name: 'button_url', label: 'Button URL', type: 'text' },
      ],
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData() {
      this.loading = true;
      axios
        .get('/nova-vendor/landing-page-card/data')
        .then((response) => {
          this.formData = response.data;
          this.loading = false;
        })
        .catch((error) => {
          console.error(error);
          this.loading = false;
        });
    },
    saveData() {
      axios
        .post('/nova-vendor/landing-page-card/save', this.formData)
        .then(() => {
          alert('Data saved successfully');
        }) 
        .catch((error) => {
          console.error(error);
          alert('Error saving data');
        });
    },
  },
};
</script>

