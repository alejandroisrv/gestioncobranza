<template>
  <p>
    <small>{{ usuario.name }}</small>
    {{ usuario.email }}
  </p>
</template>
<script>
export default {
  props: ["usuario"]
};
</script>
