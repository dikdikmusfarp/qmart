<template>
  <footer class="footer">
    <div class="container-fluid">
      <ul class="nav">
        <li class="nav-item">
          <a
            href="https://www.instagram.com/dikdikmusfar"
            target="_blank"
            rel="noopener"
            class="nav-link"
          >
            Dikdik Musfar
          </a>
        </li>
      </ul>
      <div class="copyright">
        &copy; {{ year }}, edited with <i class="tim-icons icon-heart-2"></i> by
        
        <a
          href="https://www.instagram.com/dikdikmusfar"
          target="_blank"
          rel="noopener"
          >Dikdik Musfar</a
        >
        for a task.
      </div>
    </div>
  </footer>
</template>
<script>
export default {
  data() {
    return {
      year: new Date().getFullYear()
    };
  }
};
</script>
<style></style>
