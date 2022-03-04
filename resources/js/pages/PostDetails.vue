<template>
    <section>
        <div class="container">
            <h1 class="my-4">{{ post.title }}</h1>
            <p>{{ post.content }}</p>
        </div>
    </section>
</template>

<script>
export default {
    name: 'PostDetails',
    data: function() {
        return {
            post: false
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