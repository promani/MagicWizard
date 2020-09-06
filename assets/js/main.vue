<template>
    <div>
        <loading :loading="loading" />
        <span v-html="html" @submit.prevent="handleSubmit" />
    </div>
</template>

<script>
import axios from 'axios';
import Loading from './loading';

export default {
    name: 'Main',
    components: {
        Loading,
    },
    data() {
        return {
            html: null,
            loading: true,
        };
    },
    mounted() {
        axios
            .get(window.location.pathname + '/form')
            .then((response) => {
                this.html = response.data;
                this.loading = false;
            });
    },
    methods: {
        handleBack() {
            this.loading = true;
            axios
                .post(window.location.pathname + '/back')
                .then((response) => {
                    this.html = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
        },
        handleSubmit(submitEvent) {
            this.loading = true;
            axios
                .post(window.location.pathname + '/form', new FormData(submitEvent.target))
                .then((response) => {
                    this.html = response.data;
                    this.loading = false;
                })
                .catch((error) => {
                    console.log(error);
                    this.loading = false;
                });
        },
    },
};
</script>
