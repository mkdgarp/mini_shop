<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <span class="d-flex w-100 justify-content-end topic-refresh align-items-baseline"><span><i
                            class="fas fa-sync-alt fa-spin"></i>&nbsp;</span>อัพเดตข้อมูลหน้านี้ในอีก
                    {{ timeCountdownRefresh }} วินาที</span>
            </div>
            <div class="col-6 col-md-4 my-2">
                <div class="card custom-card">
                    ออเดอร์วันนี้ (ทั้งหมด)
                    <hr class="my-0">
                    <div class="show-detail-card-dash">{{ orderToday }}</div>
                </div>
            </div>
            <div class="col-6 col-md-4 my-2">
                <div class="card custom-card">
                    รายรับวันนี้
                    <hr class="my-0" />
                    <div class="show-detail-card-dash">{{ incomeCal }} ฿</div>
                </div>
            </div>
            <div class="col-6 col-md-4 my-2">
                <div class="card custom-card">
                    สินค้าทั้งหมด
                    <hr class="my-0" />
                    <div class="show-detail-card-dash">{{ productAll }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="d-flex">
                        <div class="blobs-container">
                            <div class="blob green"></div>
                        </div> ออเดอร์ที่เปิดอยู่
                        <span class="ms-auto "><span class="topic-all-current-count">{{ orderCurrentNow }}</span>
                            รายการ</span>
                    </div>
                    <hr class="my-1">
                    <div class="scroll-current-orders">
                        <div class="row" v-for="(datas, key) in dataCurrent.data" :key="key">
                            <div class="col-12">
                                <div class="p-2 m-1 d-flex w-100 align-items-center active-current-orders">
                                    <div>
                                        <div v-if="datas.is_delivery == 0"><i
                                                class="fas fa-users text-primary"></i>&nbsp;โต๊ะ <span>{{ datas.order_name
                                                }}</span>
                                        </div>
                                        <div v-else><i class="fas fa-car text-success"></i>&nbsp;เดลิเวอรี่
                                            <span>{{ datas.order_name }}</span>
                                        </div>
                                        <div class="d-flex">
                                            <span class="detail-current-show">สินค้า {{ datas.count_product }} รายการ</span>
                                            &nbsp;
                                            <span class="detail-current-show">จำนวนเงิน {{ datas.total }} ฿</span>
                                        </div>
                                    </div>
                                    <a class=" ms-auto" :href="'/orders/' + datas.order_id"><button
                                            class="btn btn-primary ">จัดการ</button></a>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="p-2 m-1 d-flex w-100 align-items-center active-current-orders-lineman">
                                    <div>
                                        <i class="fas fa-car text-success"></i>&nbsp;เดลิเวอรี่ <span>ไลน์แมน</span>
                                        <div class="d-flex">
                                            <span class="detail-current-show">สินค้า 8 รายการ</span>
                                            &nbsp;
                                            <span class="detail-current-show">จำนวนเงิน 250฿</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-success ms-auto ">จัดการ</button>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="p-2 m-1 d-flex w-100 align-items-center active-current-orders-lineman">
                                    <div>
                                        <i class="fas fa-car text-success"></i>&nbsp;เดลิเวอรี่ <span>แกรปฟู๊ด</span>
                                        <div class="d-flex">
                                            <span class="detail-current-show">สินค้า 4 รายการ</span>
                                            &nbsp;
                                            <span class="detail-current-show">จำนวนเงิน 75฿</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-success ms-auto ">จัดการ</button>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="row" v-for="data in 3">
                            <div class="col-12">
                                <div class="p-2 m-1 d-flex w-100 align-items-center active-current-orders">
                                    <div>
                                        <i class="fas fa-users text-primary"></i>&nbsp;โต๊ะ <span>ทดสอบระบบ {{ data
                                        }}</span>
                                        <div class="d-flex">
                                            <span class="detail-current-show">สินค้า {{ 2 + data }} รายการ</span>
                                            &nbsp;
                                            <span class="detail-current-show">จำนวนเงิน 415฿</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary ms-auto ">จัดการ</button>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
const timeCountdownRefresh = ref(15)
let intervalId

const orderToday = ref(0)
const incomeCal = ref(0)
const productAll = ref(0)
const orderCurrentNow = ref(0)
const dataCurrent = reactive({});
const fncCountdown = async () => {
    intervalId = setInterval(() => {
        timeCountdownRefresh.value--
        if (timeCountdownRefresh.value < 0) {
            getDataDashboard()
            clearInterval(intervalId)
            timeCountdownRefresh.value = 15
            fncCountdown()
        }
    }, 1000)
}
const getDataDashboard = async () => {
    const response = await fetch('/api/getDataDashboard');
    if (response.ok) {
        const data = await response.json();
        // console.log(data)
        orderToday.value = data.orderToday;
        productAll.value = data.productAll;
        incomeCal.value = data.incomeCal;
        dataCurrent.data = data.dataCurrent
        orderCurrentNow.value = data.orderCurrentNow
    } else {
        console.error(`Failed to fetch products: ${response.status} ${response.statusText}`);
    }
}

getDataDashboard()
fncCountdown()

</script>

<style scoped>
.topic-refresh {
    font-size: 12px;
    color: #183153;
}

.topic-all-current-count {
    color: #183153;
}

.show-detail-card-dash {
    display: flex;
    height: 90px;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 35px;
    line-height: 1;
    color: #183153;
}

.active-current-orders {
    background: #0000000d;
    border-radius: 5px;
}

.active-current-orders-lineman {
    background: #89ffc37a;
    border-radius: 5px;
}

.detail-current-show {
    font-size: 12px;
    font-weight: 400;
}

.scroll-current-orders {
    /*max-height: 360px;
    overflow-y: auto;*/
}

.blobs-container {
    display: flex;
}

.blob {
    background: black;
    border-radius: 50%;
    box-shadow: 0 0 0 0 rgba(0, 0, 0, 1);
    margin: 7px;
    height: 10px;
    width: 10px;
    transform: scale(1);
    animation: pulse-black 2s infinite;
}

.blob.green {
    background: #1caf27;
    box-shadow: 0 0 0 0 #1caf27;
    animation: pulse-green 1.5s infinite;
}

@keyframes pulse-green {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 #1caf26a4;
    }

    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px hsla(124, 72%, 40%, 0);
    }

    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 #1caf2600;
    }
}
</style>