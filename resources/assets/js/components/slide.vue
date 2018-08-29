<template>
   <div class="slide">
   	<img v-bind:src="slide.src" alt="">
   </div>
</template>

<script>

 export default {
    data () {
       return {

       }
    },
 
    props:  ['slide']
      

  }

</script>

<style scoped>

 img {

 	max-width: 100px;
 }
 .slide {
 	display: inline-block;
 }

</style>