<script setup>
defineProps({
  msg: String,
})
</script>

<template>
  <div class="container">
    <h1>{{ msg }}</h1>
    
    <!-- Navigation -->
    <nav class="nav-menu">
      <router-link to="/articles" class="nav-link">Home</router-link>
      <router-link to="/create" class="nav-link">Create Article</router-link>
      <router-link to="/update/:id" class="nav-link">Update Article</router-link>
      <router-link to="/delete/:id" class="nav-link">Delete Article</router-link>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
      <router-view></router-view>
    </main>
  </div>
</template>

<style scoped>
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.nav-menu {
  margin: 20px 0;
  padding: 10px;
  background: #f5f5f5;
  border-radius: 8px;
}

.nav-link {
  margin-right: 20px;
  text-decoration: none;
  color: #2c3e50;
  font-weight: bold;
  padding: 5px 10px;
  border-radius: 4px;
}

.nav-link:hover {
  background: #e0e0e0;
}

.router-link-active {
  background: #42b883;
  color: white;
}

.main-content {
  margin-top: 20px;
}
</style>
