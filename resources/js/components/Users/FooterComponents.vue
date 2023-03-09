<template>
    <div class="demo-version">ระบบเวอร์ชั่นเบต้า 1.3.3</div>
    <footer class="footer-setting ">
        <div class="d-block w-100 text-center">
            <ul class="d-flex w-100 justify-content-around h-100 align-items-center fw-normal">
                <a href="/">
                    <li class="li_menu" @click="activeItemMenu('home')"><i
                            class="fas fa-home-lg-alt fa-2x-custom"></i><br>หน้าแรก</li>
                </a>
                <a href="/create_orders">
                    <li class="li_menu"><i class="fas fa-plus-square fa-2x-custom"></i><br>สร้างออเดอร์</li>
                </a>
                <!-- <a href="/addnewproducts"><li>สร้าง<br>สินค้าใหม่ในระบบ</li></a> -->
                <a href="/home_manageproduct">
                    <li class="li_menu"><i class="fas fa-tasks fa-2x-custom"></i><br>จัดการสินค้า</li>
                </a>
                <a href="/history">
                    <li class="li_menu"><i class="fas fa-history fa-2x-custom"></i><br>ประวัติการขาย</li>
                </a>

            </ul>
        </div>
    </footer>
</template>

<script setup>
import { ref } from 'vue';
const activeItem = ref('')
const activeItemMenu = async (namemenu) => {
    localStorage.setItem('activeItemMenu', namemenu)
    activeItem.vlue = localStorage.getItem('activeItemMenu')
}
const check_menu = async () => {
    activeItem.val = localStorage.getItem('activeItemMenu')
}
check_menu()
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

.li_menu {
    font-size: 12px;
}

.fa-2x-custom {
    font-size: 18px;
}

.li_menu.active {
    color: #2b568f;
    font-weight: 500;
}
</style>