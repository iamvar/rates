<template>
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon" />
      </button>
      <div
          id="navbarNav"
          class="collapse navbar-collapse"
      >
        <ul class="navbar-nav">
          <router-link
              class="nav-item"
              tag="li"
              to="/admin"
              active-class="active"
          >
            <a class="nav-link">Admin</a>
          </router-link>
          <router-link
            class="nav-item"
            tag="li"
            to="/convertor"
            active-class="active"
          >
            <a class="nav-link">Convertor</a>
          </router-link>
        </ul>
      </div>
    </nav>

    <router-view />
  </div>
</template>

<script>
export default {
  name: "ConvertorApp"
}
</script>