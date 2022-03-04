<template>
    <section>
        <div class="container">
            <h2 class="my-4">Tag: {{ tag.name }}</h2>

            <h3>Ricette correlate</h3>
            <div class="list-group">
                <router-link 
                    v-for="post in tag.posts" :key="post.id" 
                    class="list-group-item list-group-item-action" 
                    :to="{ name: 'post-details', params: { slug: post.slug } }"
                >
                    {{ post.title }}
                </router-link>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    name: 'TagDetails',
    data: function() {
        return {
            tag: false
        };
    },
    methods: {
        getTag() {
            axios.get('/api/tags/' + this.$route.params.slug)
            .then((response) => {
                this.tag = response.data.results;
            });
        }
    },
    created: function() {
        this.getTag();
    }
}
</script>