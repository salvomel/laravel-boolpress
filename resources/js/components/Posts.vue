<template>
    <div class="container">
        <h1>Posts</h1>

        <div class="row row-cols-3">
            <div v-for="post in posts" :key="post.id" class="col">
                    <div class="card my-2">
                        
                        <div class="card-body">
                            <h4 class="card-title">{{ post.title }}</h4>
                            <p class="card-text">{{ post.content }}</p>
                        </div>
                        
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Posts',
    data: function() {
        return {
            posts: []
        };
    },
    methods: {
        getPosts: function() {
            axios.get('api/posts')
            .then((response) => {
                this.posts = response.data.results;
            });
        },
    },
    created: function() {
        this.getPosts();
    }
}
</script>
