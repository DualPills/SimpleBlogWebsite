<script setup>
import { ref, watch } from 'vue'
import axios from 'axios'
import { getArticleById, article, response as getResponse } from './GetArticleById.vue'

const response = ref("")
const articleId = ref("")

// Watch for changes in articleId to fetch article details
watch(articleId, (newId) => {
  if (newId) {
    getArticleById(newId)
  }
})

const deleteArticle = async(id) => {
  if (!confirm('Are you sure you want to delete this article?')) {
    return;
  }
  try {
    const request = await axios.delete('http://localhost:8000/learningApi.php/articles/' + id)
    response.value = JSON.stringify(request.data)
    articleId.value = "" // Clear the input after successful deletion
  }
  catch(error) {
    response.value = "Error deleting article " + error.message
  }
}
</script>

<template>
  <div class="form-container">
    <h2>Delete Article</h2>
    <div class="form-group">
      <label for="article-id">Article ID:</label>
      <input 
        type="number" 
        id="article-id"
        v-model="articleId" 
        placeholder="Enter article ID to delete"
      />
    </div>

    <!-- Show article preview using ArticleDetail styling -->
    <div v-if="getResponse && getResponse.startsWith('Error')" class="error-message">
      {{ getResponse }}
    </div>
    <div v-else-if="article" class="article-preview">
      <h3>Article to be deleted:</h3>
      <article class="article-content">
        <header class="article-header">
          <h1 class="article-title">{{ article.title }}</h1>
          <div class="article-meta">
            <time :datetime="article.created_at">
              {{ new Date(article.created_at).toLocaleDateString() }}
            </time>
          </div>
        </header>
        <div class="article-body">
          {{ article.content }}
        </div>
      </article>
    </div>
    
    <button 
      type="button" 
      @click="deleteArticle(articleId)"
      class="btn-delete"
      :disabled="!articleId || !article"
    >
      Delete Article
    </button>
    
    <div v-if="response" class="response-message" :class="{ 'error': response.startsWith('Error') }">
      {{ response }}
    </div>
  </div>
</template>

<style scoped>
.form-container {
  max-width: 800px;
  margin: 20px auto;
  padding: 20px;
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

input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1em;
}

.article-preview {
  margin: 20px 0;
}

.article-preview h3 {
  color: #dc3545;
  margin-bottom: 15px;
}

.article-content {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  padding: 40px;
}

.article-header {
  margin-bottom: 30px;
  border-bottom: 1px solid #eee;
  padding-bottom: 20px;
}

.article-title {
  font-size: 2.5em;
  color: #2c3e50;
  margin: 0 0 15px 0;
  line-height: 1.2;
}

.article-meta {
  color: #666;
  font-size: 0.9em;
}

.article-body {
  font-size: 1.1em;
  line-height: 1.8;
  color: #333;
  white-space: pre-wrap;
}

.error-message {
  color: #dc3545;
  padding: 20px;
  background: #f8d7da;
  border-radius: 8px;
  margin: 20px 0;
}

.btn-delete {
  background: #f44336;
  color: white;
  border: none;
  padding: 12px 24px;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  transition: background 0.3s;
  margin-top: 20px;
}

.btn-delete:hover {
  background: #d32f2f;
}

.btn-delete:disabled {
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

@media (max-width: 768px) {
  .article-content {
    padding: 20px;
  }
  
  .article-title {
    font-size: 2em;
  }
}
</style>