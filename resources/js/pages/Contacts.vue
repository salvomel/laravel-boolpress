<template>
    <section>
        <div class="container">
            <h1 class="my-4">Contact us</h1>

            <div v-if="success" class="mb-4 alert alert-success">EMAIL SENT!</div>

            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input v-model="email" type="email" class="form-control" id="email">
                </div>

                <!-- Se c'è errore (-> array) stampo messaggio errore -->
                <div v-if="errors.email">
                    <p class="alert alert-danger" v-for="(error, index) in errors.email" :key="index">{{ error }}</p>
                </div>

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input v-model="name" type="text" class="form-control" id="name">
                </div>

                <div v-if="errors.name">
                    <p class="alert alert-danger" v-for="(error, index) in errors.name" :key="index">{{ error }}</p>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea v-model="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                </div>

                <div v-if="errors.message">
                    <p class="alert alert-danger" v-for="(error, index) in errors.message" :key="index">{{ error }}</p>
                </div>

                <!-- @click.prevent evita il refresh della pagina al click -->
                <button :disabled="disabled" type="submit" @click.prevent="sendMessage()" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </section>
</template>

<script>
export default {
    name: 'Contacts',
    data: function() {
        return {
            email: '',
            name: '',
            message: '',
            success: false,
            errors: {},
            disabled: false
        };
    },
    methods: {
        sendMessage: function() {
            // Disabilito pulsante submit prima della fine fine della chiamata axios
            this.disabled = true;

            axios.post('/api/leads/store', {
                // Non li metto dentro params perchè uso 'post'
                email: this.email,
                name: this.name,
                message: this.message
            })
            .then((response) => {
                // Se true tutto ok svuoto i campi 
                if(response.data.success) {
                    this.name = '';
                    this.email = '';
                    this.message = '';
                    this.success = true;
                    this.error = {};
                } else {
                    // Altrimenti ci sono errori di validazione
                    this.success = false;
                    this.errors = response.data.errors
                }

                this.disabled = false;
            });
        }
    }
}
</script>