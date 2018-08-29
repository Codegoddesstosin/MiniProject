<template>
	<div>
		<h2>Home</h2>
<form @submit.prevent="addpost" class="mb-3">

  <div class="form-group">
   <textarea class="form-control" placeholder ="Whats on your mind?" v-model="post.contents"></textarea>
  </div>

  <button type="submit" class="btn btn-primary btn-block">Spill</button>

</form>

<nav aria-label="Page navigation example">
  <ul class="pagination">
    <li v-bind:class="[{disabled: !pagination.prev_page_url }]"
    class="page-item"><a class="page-link" href="#"
    @click="fetchPosts(pagination.prev_page_url)">Previous</a></li>
    

     <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page }} of {{pagination.last_page }}</a></li>



    <li v-bind:class="[{disabled: !pagination.next_page_url}]"
    class="page-item"><a class="page-link" href="#"
    @click="fetchPosts(pagination.next_page_url)">Next</a></li>
  </ul>
</nav>

		<div class="card card-body mb-2" v-for="post in posts" v-bind:key="post.id"> 
			<h3> {{ post.id}}</h3>
			<p>{{ post.contents }}</p>

       
       <button @click="editpost(post)" class="btn btn-warning mb-2 btn-sm">Edit</button>

       <button @click="deletepost(post.id)" class="btn btn-danger">Delete</button>
		</div>

	</div> 
</template>

<script>
  export default {
  	data() {
  		return {
  			posts: [],
  			post: {
  				id: '',

  				contents: ''
  				

  			}, 

  			post_id: '',
  			pagination: {},
  			edit: false
           };
  		},

  		created() {
  			this.fetchPosts(); 
  		},
  		/*methods: {
  			fetchPosts () {
  				fetch('http://localhost:8002/posts')
  				.then(res=> res.json ())
  				.then(res => {
                    this.posts = res.data;
                    
  				});
  			}
  		}*/
      methods: {
        fetchPosts(page_url) {

          let vm = this;

           page_url = page_url || 'http://localhost:8002/posts'
           fetch(page_url)
            .then(res=> res.json ())
             .then(res => {
              this.posts = res.data
              vm.makePagination(res.meta, res.links);
             })
             .catch(err => console.log(err)); 
        },
        makePagination(meta, links) {
          let pagination = {
            current_page: meta.current_page,
            last_page: meta.last_page,
            next_page_url: links.next,
            prev_page_url: links.prev
          }

          this.pagination = pagination;
        },

        deletepost(id) {
          if(confirm('Are you sure?')) {
             fetch(`http://localhost:8002/api/post/${id}`, {
               method: 'Delete'
             })
             .then (res => res.json ())
             .then(data => {
                alert('Post removed');
                this.fetchPosts ();
             })
             .catch (err=> console.log(err));
         
          }
        },
        addpost() {
          if(this.edit === false) {
            //add
            fetch(`http://localhost:8002/api/post`, {
              method: 'Post',
              body: JSON.stringify(this.post),
              headers: {
                'Content-type': 'application/json'
              }
            })
              .then (res => res.json ())
              .then(data => {
            
                 this.post.contents = '';
                 alert('Post added');
                 this.fetchPosts();

              })
              .catch (err => console.log(err));
          } else {

            //update
             fetch(`http://localhost:8002/api/post/{id}`, {
              method: 'put',
              body: JSON.stringify(this.post),
              headers: {
                'Content-type': 'application/json'
              }
            })
              .then (res => res.json ())
              .then(data => {
            
                 this.post.contents = '';
                 alert('updated');
                 this.fetchPosts();

              })
              .catch (err => console.log(err));

          } 

        },
          editpost(post) {
            this.edit = true;
            this.post.id = post.id;
            this.post.post_id = post.id;
            this.post.contents = post.contents;

          } 
      }
  	};
  
</script>