<template>
  <section class="app-main">
    <transition name="fade" mode="out-in">
      <router-view :key="key"></router-view>
    </transition>
  </section>
</template>

<script>
export default {
  name: 'AppMain',
  computed: {
    key() {
      return this.$route.name !== undefined ? this.$route.name + +new Date() : this.$route + +new Date()
    }
  }
}
</script>

<style>
.app-main{
  height: 1000px;
  margin:10px;
  margin-top: 20px;
  /* background-color: blue;
  background-image: url("../../assets/images/fuck.png"); */
 }
</style>

