<template>
    <section>
        <div class="container">
            <div class="my-4">
                <h2>Error 404</h2>
                <h3>Nothing found here</h3>
            </div>

            <router-link class="btn btn-outline-success" :to="{ name: 'blog' }">Come back to Blog Page</router-link>
        </div>
    </section>
</template>

<script>
export default {
    name: 'NotFound'
}
</script>