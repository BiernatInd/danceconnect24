<template>
  <MainHeader />
  <div class="home">
    <div class="home-content">
      <MainPlugin />
    </div>
  </div>
  <MainFooter />
</template>

<script>
import MainHeader from "@main-components/main-header.vue";
import MainPlugin from "@main-components/main-plugin.vue";
import MainFooter from "@main-components/main-footer.vue";

export default {
  components: {
    MainHeader,
    MainPlugin,
    MainFooter,
  },
};
</script>

<style lang="scss" scoped>
.home {
  width: 100%;
  padding-top: 100px;
  background: url("@bg/bg-1.png");
  background-repeat: no-repeat;
  background-position-x: 100%;
  .home-content {
    width: 100%;
    margin-left: auto;
    margin-right: auto;
  }
}

@media screen and (max-width: 1500px) {
  .home {
    height: 100%;
    .home-content {
      .home-right {
        margin-bottom: 2rem;
      }
    }
  }
}
</style>
