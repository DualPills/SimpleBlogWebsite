<script setup>
import { ref } from 'vue'
import axios from 'axios'

const response = ref("")
const title = ref("")
const content = ref("")

const createArticle = async() => {
  try {
    const request = await axios.post('http://localhost:8000/learningApi.php/articles', {
      title: title.value,
      content: content.value
    })
    title.value = ""
    content.value = ""
    response.value = JSON.stringify(['success', request.data])
  }
  catch(error) {
    response.value = "Error creating article " + error.message
  }
}
</script>

<template>
  <div class="form-container">
    <h2>Create New Article</h2>
    <div class="form-group">
      <label for="article-title">Title:</label>
      <input 
        type="text" 
        id="article-title"
        v-model="title" 
        placeholder="Enter article title"
      />
    </div>
    
    <div class="form-group">
      <label for="article-content">Content:</label>
      <textarea 
        id="article-content"
        v-model="content" 
        placeholder="Enter article content"
        rows="6"
      ></textarea>
    </div>
    
    <button 
      type="button" 
      @click="createArticle"
      class="btn-create"
      :disabled="!title || !content"
    >
      Create Article
    </button>
    
    <div v-if="response" class="response-message" :class="{ 'error': response.startsWith('Error') }">
      {{ response }}
    </div>
  </div>
</template>

<style scoped>
.form-container {
  max-width: 600px;
  margin: 20px auto;
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  margin-bottom: 8px;
  color: #2c3e50;
  font-weight: 500;
}

input, textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1em;
}

textarea {
  resize: vertical;
  min-height: 120px;
}

.btn-create {
  background: #4CAF50;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  transition: background 0.3s;
}

.btn-create:hover {
  background: #388E3C;
}

.btn-create:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.response-message {
  margin-top: 20px;
  padding: 10px;
  border-radius: 4px;
  background: #e8f5e9;
  color: #2e7d32;
}

.response-message.error {
  background: #ffebee;
  color: #c62828;
}
</style>
