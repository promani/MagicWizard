<template>
    <transition name="fade">
        <div v-show="loading" class="preloader-background">
            <div class="spinner"></div>
        </div>
    </transition>
</template>

<script>
export default {
    name: 'Loading',
    props: {
        loading: {
            type: Boolean,
            default: false,
        },
    },
};
</script>

<style>
    .spinner {
        width: 40px;
        height: 40px;
        margin: 100px auto;
        background-color: #333;

        border-radius: 100%;
        -webkit-animation: sk-scaleout 1.0s infinite ease-in-out;
        animation: sk-scaleout 1.0s infinite ease-in-out;
    }

    @-webkit-keyframes sk-scaleout {
        0% { -webkit-transform: scale(0) }
        100% {
            -webkit-transform: scale(1.0);
            opacity: 0;
        }
    }

    @keyframes sk-scaleout {
        0% {
            -webkit-transform: scale(0);
            transform: scale(0);
        } 100% {
              -webkit-transform: scale(1.0);
              transform: scale(1.0);
              opacity: 0;
          }
    }

    .preloader-background {
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #eee;
    opacity: 0.9;

    position: fixed;
    z-index: 100;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    }

    .fade-enter-active, .fade-leave-active {
    transition: opacity 1.5s;
    }

    .fade-enter, .fade-leave-to {
    opacity: 0;
    }
</style>
