<template>
  <div>
    <transition name="moveInUp">
      <router-view></router-view>
    </transition>
  </div>
</template>
<script>


export default {
  data() {
    return {
      title: ""
    };
  }
};
</script>
<style>
.vs--searchable .vs__dropdown-toggle{
  border-radius: 0px !important;
  height: 34px !important;
  line-height: 34px !important;
}
.moveInUp-enter-active{
  opacity: 0;
  transition: opacity 1s ease-in;
}
</style>
