<template>
    <section>
        <div class="container">
            <h1 class="my-4">Posts</h1>

            <div class="row row-cols-3">
                <div v-for="post in posts" :key="post.id" class="col">
                    <div class="card mb-4">
                        
                        <div class="card-body">
                            <h4 class="card-title">{{ post.title }}</h4>
                            <p class="card-text">{{ truncate(post.content, 70) }}</p>
                        </div>
                        <div class="card-body">
                            <router-link class="btn btn-outline-primary" :to="{ name: 'post-details', params: { slug: post.slug} }">Read article</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        // Funzione per troncare testo a dato numero di carartteri
        truncate: function(text, maxTextNumber) {
            if(text.length > maxTextNumber) {
                return text.substr(0, maxTextNumber) + '...';
            }
            return text;
        }
    },
    created: function() {
        this.getPosts();
    }
}
</script>
