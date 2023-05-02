<template>
    <div>
      <table v-if="clients.length > 0">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <!-- Add more table headers for other client attributes -->
          </tr>
        </thead>
        <tbody>
          <tr v-for="client in clients" :key="client.id">
            <td>{{ client.first_name }}</td>
            <td>{{ client.email }}</td>
            <!-- Add more table cells for other client attributes -->
          </tr>
        </tbody>
      </table>
      <div v-else-if="loading">
        Loading...
      </div>
      <div v-else>
        No data available.
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        clients: [],
        loading: true,
      };
    },
    mounted() {
      this.fetchClients();
    },
    methods: {
      fetchClients() {
        axios
          .get('/clients')
          .then((response) => {
            this.clients = response.data;
            this.loading = false;
          })
          .catch((error) => {
            console.error(error);
            this.loading = false;
          });
      },
    },
  };
  </script>

  <style scoped>
  /* Add any custom CSS styles for the Clients component */
  </style>
