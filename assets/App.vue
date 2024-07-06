<template>
    <div class="container">
      <h1>Formularz</h1>
      <form @submit.prevent="submitForm" novalidate>
        <div class="form-group">
          <label for="firstname">Imię:</label>
          <input class="form-control mb-1 mt-1" id="firstname" v-model="formData.firstname" required>
        </div>
        <div class="form-group">
          <label for="lastname">Nazwisko:</label>
          <input class="form-control mb-1 mt-1" id="lastname" v-model="formData.lastname" required>
          
        </div>
        <div class="form-group">
          <label for="email">Adres e-mail:</label>
          <input class="form-control mb-1 mt-1" id="email" v-model="formData.email" required>
          
          
        </div>
        <div class="form-group">
          <label for="message">Treść wiadomości:</label>
          <textarea class="form-control mb-1 mt-1" id="message" v-model="formData.message" required></textarea>
          
        </div>
        <button type="submit" class="btn btn-primary mb-1 mt-1">Wyślij</button>
      </form>
      <div v-if="submittedData">
      <h2>Przesłane dane:</h2>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Pole</th>
            <th>Wartość</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Imię</td>
            <td>{{ submittedData.data.firstname }}</td>
          </tr>
          <tr>
            <td>Nazwisko</td>
            <td>{{ submittedData.data.lastname }}</td>
          </tr>
          <tr>
            <td>E-mail</td>
            <td>{{ submittedData.data.email }}</td>
          </tr>
          <tr>
            <td>Treść wiadomości</td>
            <td>{{ submittedData.data.message }}</td>
          </tr>
        </tbody>
      </table>
      </div>

      <FormErrors :errors="backErrors" title="Błędy w formularzu od strony serwera:" />
      <FormErrors :errors="errors" title="Błędy w formularzu:" />
      
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import validator from 'validator';
  import FormErrors from './components/FormErrors.vue';

  export default {
    name: 'App',
    components: {
        FormErrors,
  },
    data() {
      return {
        formData: {
          firstname: '',
          lastname: '',
          email: '',
          message: ''
        },
        submittedData: null,
        errors: [],
        backErrors: [],
      };
    },
    methods: {
      async submitForm() {
        this.submittedData = null
        this.errors= []
        this.backErrors= []
        if (this.validateForm()) {
          try {
            const response = await axios.post('/api/contact-form', this.formData);
            this.submittedData = response.data;
          } catch (error) {
            //console.error('Błąd podczas wysyłania formularza:', error);
            //console.log(error)
            this.backErrors.push(error.message)
            if(error.message!="Network Error"){
            this.backErrors.push(error.response.data.errors);
            }
          }
        }
      },
      validateForm() {
        const { firstname, lastname, email, message } = this.formData;
        this.errors = [];

        if (!firstname || firstname.trim() === '') {
          this.errors.push('Imie jest wymagane.');
        }
        
        if (!lastname || firstname.trim() === '') {
          this.errors.push('Nazwisko jest wymagane.');
        }
        if (!email) {
          this.errors.push('Adres e-mail jest wymagany.');
        } else if (!validator.isEmail(email)) {
          this.errors.push('Adres e-mail jest niepoprawny.');
        }
        if (!message || lastname.trim() === '') {
          this.errors.push('Treść wiadomości jest wymagana.');
        }
  
        return this.errors.length == 0;
      }
    }
  };
  </script>
  
  <style>

  </style>
  