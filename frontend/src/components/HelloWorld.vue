<template>
  <v-container class="fill-height">
    <v-responsive class="d-flex align-center text-center fill-height">

      <v-row class="d-flex align-center justify-center">
        <v-col>
          <VAutocomplete
            v-model="country"
            label="Autocomplete"
            variant="underlined"
            :items="countries"
            item-title="attributes.land"
            item-value="attributes.iso"
          ></VAutocomplete>
        </v-col>
      </v-row>
      <v-row>
        <v-col>
          <VBtn
            prepend-icon="mdi-vuetify"
            variant="outlined"
            @click="fireEvent"
          >
            Persist
          </VBtn>
        </v-col>
      </v-row>
    </v-responsive>
  </v-container>
</template>

<script setup lang="ts">
import { onMounted, ref } from '@vue/runtime-core';
import axios from "axios";
const countries = ref();
const country = ref('')


const fireEvent = ()=>{
  
}

onMounted(() => {
  axios.get('http://localhost:8000/api/v1/lands', {
    headers: {
        'Accept': 'application/vnd.api+json',
        'Content-Type': 'application/vnd.api+json',
        'Authorization': `Bearer 1|e2EPcgpjZvnkyuq0S8GfI6SrAHWboRNfW5WNnsQU` 
    }}
    )
  .then(function (response) {
    console.log(response.data.data);
    countries.value = response.data.data;
  })
  .catch(function (error) {
    // handle error
    console.log(error);
  })
  .finally(function () {
    // always executed
  });

})

</script>
