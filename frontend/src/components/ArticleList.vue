<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const articles = ref([])
const error = ref(null)

const getAllArticles = async () => {
  try {
    const response = await axios.get('http://localhost:8000/learningApi.php/articles')
    articles.value = response.data
  } catch (err) {
    error.value = "Error fetching data: " + err.message
  }
}

onMounted(() => {
  getAllArticles()
})
</script>

<template>
  <div class="articles-container">
    <h2>Articles</h2>
    <div v-if="error" class="error-message">
      {{ error }}
    </div>
    <div v-else-if="articles.length === 0" class="no-articles">
      No articles found. Create your first article!
    </div>
    <div v-else class="articles-list">
      <div v-for="article in articles" :key="article.id" class="article-card">
        <router-link :to="`/article/${article.id}`" class="article-link">
          <h3>{{ article.title }}</h3>
          <p class="article-preview">{{ article.content.substring(0, 150) }}...</p>
          <span class="article-date">{{ new Date(article.created_at).toLocaleDateString() }}</span>
        </router-link>
      </div>
    </div>
  </div>
</template>

<style scoped>
.articles-container {
  padding: 20px;
}

.error-message {
  color: #dc3545;
  padding: 10px;
  background: #f8d7da;
  border-radius: 4px;
  margin: 10px 0;
}

.no-articles {
  text-align: center;
  color: #666;
  padding: 20px;
}

.articles-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
  margin-top: 20px;
}

.article-card {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  transition: transform 0.2s;
}

.article-card:hover {
  transform: translateY(-2px);
}

.article-link {
  display: block;
  padding: 20px;
  text-decoration: none;
  color: inherit;
}

.article-link h3 {
  margin: 0 0 10px 0;
  color: #2c3e50;
}

.article-preview {
  color: #666;
  margin: 10px 0;
  line-height: 1.4;
}

.article-date {
  display: block;
  color: #999;
  font-size: 0.9em;
  margin-top: 10px;
}
</style>