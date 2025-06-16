<script>
import { ref } from 'vue'
import axios from 'axios'

const response = ref("")
const article = ref({}) 

const getArticleById = async(id) =>{
  try {
    const request = await axios.get('http://localhost:8000/learningApi.php/articles/' + id)
    article.value = request.data
    response.value = JSON.stringify(request.data)
  }
  catch(error){
    response.value= "Error fetching data" +error.message
  }
}


export {getArticleById, response, article}
</script>


<template>
    <div class="card">
        <h2>Get Article By Id</h2>
        <input type="number" v-model="id" placeholder="Id" />
        <button type="button" @click="getArticleById(id)">Get Articles BY id {{ id }}</button>
        <p>
        The response is {{ response }}
        </p>
    </div>
</template>