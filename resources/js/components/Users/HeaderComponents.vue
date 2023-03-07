<template>
    <nav class="navbar bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <!-- <img src="/docs/5.2/assets/brand/bootstrap-logo.svg" alt="Bootstrap" width="30" height="24"> -->
                <span>name shop</span>
            </a>
            <!-- <b-icon-arrow-90deg-down /> -->
            <div class="option-icon"><b-icon-gear-fill /></div>
        </div>
    </nav>
</template>

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
}
</style>