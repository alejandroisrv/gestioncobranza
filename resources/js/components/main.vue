<template>
  <div>
      <router-view></router-view>
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
</style>
