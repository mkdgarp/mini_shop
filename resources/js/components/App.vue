<template>
    <!-- <HeaderComponents /> -->
    <section class="main-section">
        <router-view></router-view>
    </section >
    <!-- <FooterComponents /> -->
</template>

<script setup>
import FooterComponents from './Users/FooterComponents.vue';
import HeaderComponents from './Users/HeaderComponents.vue';
</script>

<style scoped>
.main-section {
    margin-top: 60px;
    margin-bottom: 70px;
}
</style>