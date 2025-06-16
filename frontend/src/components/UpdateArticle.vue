<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'
import { getArticleById, article, response as getResponse } from './GetArticleById.vue'

const response = ref("")
const title = ref("")
const content = ref("")
const id = ref("")

const updateArticle = async(id) => {
  try {
    const request = await axios.put('http://localhost:8000/learningApi.php/articles/' + id, {
      title: title.value,
      content: content.value
    })
    response.value = JSON.stringify(request.data)
  }
  catch(error) {
    response.value = "Error updating article " + error.message
  }
}

// Watch for changes in the article data from GetArticleById
watch(article, (newArticle) => {
  if (newArticle) {
    title.value = newArticle.title
    content.value = newArticle.content
  }
}, { immediate: true })

onMounted(() => {
  if (id.value) {
    getArticleById(id.value)
  }
})
</script>

<template>
  <div class="form-container">
    <h2>Update Article</h2>
    <div class="form-group">
      <label for="article-id">Article ID:</label>
      <input 
        type="number" 
        id="article-id"
        v-model="id" 
        placeholder="Enter article ID"
        @change="getArticleById(id)"
      />
    </div>
    
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
      @click="updateArticle(id)"
      class="btn-update"
      :disabled="!id || !title || !content"
    >
      Update Article
    </button>
    
    <div v-if="response || getResponse" class="response-message" :class="{ 'error': (response || getResponse).startsWith('Error') }">
      {{ response || getResponse }}
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

.btn-update {
  background: #2196F3;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  transition: background 0.3s;
}

.btn-update:hover {
  background: #1976D2;
}

.btn-update:disabled {
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
    