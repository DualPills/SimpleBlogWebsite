<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import { getArticleById, article, response } from './GetArticleById.vue';

const route = useRoute();
const articleId = ref(route.params.id);

onMounted(() => {
  getArticleById(articleId.value);
});
</script>

<template>
  <div class="article-detail">
    <div v-if="response && response.startsWith('Error')" class="error-message">
      {{ response }}
    </div>
    <div v-else-if="!article" class="loading">
      Loading article...
    </div>
    <article v-else class="article-content">
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
</template>

<style scoped>
.article-detail {
  max-width: 800px;
  margin: 0 auto;
  padding: 40px 20px;
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

.loading {
  text-align: center;
  color: #666;
  padding: 40px;
  font-size: 1.2em;
}

@media (max-width: 768px) {
  .article-detail {
    padding: 20px 15px;
  }
  
  .article-content {
    padding: 20px;
  }
  
  .article-title {
    font-size: 2em;
  }
}
</style>
