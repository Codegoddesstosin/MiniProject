<template>
   <div class="slides">
   	 <div v-bind:style="{width: innerWidth + 'px', marginLeft: '-' +slidesInnerMargin }" class="slides-inner">
   	    	
   	    	
  <slide v-for="slide in slides" v-bind:style="{width: singleWidth + 'px'}" v-bind:slide="slide"></slide>
   	    		

 
   	</div>
   	<div class="navigation">
   	<span v-on:click="GotoPrev">prev</span>
   	<span class="nav-number" v-for="slide in slides"></span>
   	<span v-on:click="GotoNext">next</span>
   	</div>
   </div> 
</template>

<script>
import slide from './slide';
export default {
   data () {
   	return {
   		slides: [
             {src: 'static/img/slides1.png'},
             {src: 'static/img/slides2.png'},
             {src: 'static/img/slides3.png'},
             {src: 'static/img/slides4.png'},
             {src: 'static/img/slides5.png'}
             

   		],
   		innerWidth: 0,
   		singleWidth: 0
   	}

   },
   methods: {
   	GotoPrev () {

   	},
   	GotoNext () {

   	}

   },

   props: {
   	itemsPerslide: {
   		type: null,
   		default: 1
   	}
   },
   components: {

   	slide

   }, 

   attached() { 
   	let singleWidth = this.$el.clientwidth/this.itemsPerSlide
   	this.$set('singleWidth', singleWidth)
   	this.$set('innerWidth', singleWidth * this.slides.length)

   	 }

}*/
</script>

<style scoped>

</style>