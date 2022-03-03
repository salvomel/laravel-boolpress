<template>
    <section>
        <div class="container">
            <div class="my-4">
                <h2>Error 404</h2>
                <h3>Nothing found here</h3>
            </div>

            <router-link class="nav-link" :to="{ name: 'blog' }">Come back to Blog</router-link>
        </div>
    </section>
</template>

<script>
export default {
    name: 'NotFound'
}
</script>