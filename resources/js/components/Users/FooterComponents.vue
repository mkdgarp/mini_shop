<template>
    <div class="demo-version">ระบบเวอร์ชั่นเบต้า 1.0.5</div>
    <footer class="footer-setting ">
        <div class="d-block w-100 text-center">
            <ul class="d-flex w-100 justify-content-around h-100 align-items-center fw-normal">
                <a href="/"><li>หน้าแรก</li></a>
                <a href="/create_orders"><li>สร้าง<br>ออเดอร์ใหม่</li></a>
                <a href="/"><li>ออเดอร์วันนี้</li></a>

                <!-- <li></li> -->
                <!-- <li>asdasda</li> -->
            </ul>
        </div>
    </footer>
</template>

<script setup>

</script>

<style scoped>
footer.footer-setting {
    background: white;
    position: fixed;
    z-index: 999999;
    bottom: -1px;
    width: 100%;
    display: flex;
    height: 60px;
    padding: 8px 5px;
    box-shadow: 0px -5px 20px rgb(0 0 0 / 5%);
    border-radius: 10px 10px 0 0;
}

ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.demo-version {
    position: fixed;
    bottom: 65px;
    color: #00000026;
    right: 10px;
}
</style>