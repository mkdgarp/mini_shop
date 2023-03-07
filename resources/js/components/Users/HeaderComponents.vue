<template>
    <nav class="navbar bg-light">
        <div class="container">
            <a class="navbar-brand" href="/">
                <!-- <img src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24"> -->
                <span class="topic-name">หม่าล่า 99 x YakYen</span>
            </a>
            <!-- <b-icon-arrow-90deg-down /> -->
            <div class="option-icon" @click="ssss"><b-icon-gear-fill /></div>
        </div>
    </nav>
</template>
<script setup>
const ssss = () => {
    alert('ยังไม่ได้ทำ ใจเย็น')
}
</script>
<style scoped>
.option-icon {
    display: flex;
    background: white;
    width: 30px;
    height: 30px;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    box-shadow: 0px 0px 10px rgb(0 0 0 / 15%);
}

.navbar.bg-light {
    box-shadow: 0px 7px 9px rgb(0 0 0 / 2%);
    position: fixed;
    top: -1px;
    width: 100%;
    z-index: 9999999;
}

.topic-name {
    font-size: 18px;
    font-weight: bold;
    letter-spacing: 1.5px;
    color: #183153;
}
</style>