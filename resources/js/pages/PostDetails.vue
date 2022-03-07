<template>
    <section>
        <div class="container">
            <h1 class="my-4">{{ post.title }}</h1>

            <h6 v-if="post.category">Category: {{ post.category.name }}</h6>
            
            <!-- TAGS -->
            <div v-if="post.tags && post.tags.length > 0">
                <router-link 
                    v-for="tag in post.tags" :key="tag.id"
                    class="badge bg-success text-dark mr-1"
                    :to="{ name: 'tag-details', params: { slug: tag.slug } }"
                >
                    {{ tag.name }}
                </router-link>
            </div>

            <p class="mt-4">{{ post.content }}</p>
        </div>
    </section>
</template>

<script>
export default {
    name: 'PostDetails',
    data: function() {
        return {
            post: {}
        };
    },
    methods: {
        getPost() {
            // this.$route.params.slug sintassi per prendere lo slug dalla route :slug
            axios.get('/api/posts/' + this.$route.params.slug)
            .then((response) => {
                if(response.data.success) {
                    this.post = response.data.results
                } else {
                    this.$router.push ({ name: 'not-found' });
                    // altrimenti rotta alla pagina not found
                }
            });
        }
    },
    created: function() {
        this.getPost();
    }
}
</script>