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
                    <div class="scroll-current-orders" v-if="dataCurrent.data">
                        <div class="row" v-for="(datas, key) in dataCurrent.data" :key="key">
                            <div class="col-12">
                                <div
                                    :class="(datas.is_delivery == 0) ? 'p-2 m-1 d-flex w-100 align-items-center active-current-orders' : 'p-2 m-1 d-flex w-100 align-items-center active-current-orders-lineman'">
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
                                        <div class="detail-create-at">
                                            สร้างเมื่อ : {{ datas.create_at }}
                                        </div>
                                    </div>
                                    <a class=" ms-auto" :href="'/orders/' + datas.order_id">
                                        <button v-if="datas.is_delivery == 0" class="btn btn-primary ">จัดการ</button>
                                        <button v-else class="btn btn-success ">จัดการ</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div v-else>
                        <h5 class="text-center d-block text-primary py-2">ไม่มีออเดอร์ที่เปิดอยู่</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue';
const timeCountdownRefresh = ref(60)
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
            timeCountdownRefresh.value = 60
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
        // productAll.value = data.productAll;
        incomeCal.value = data.incomeCal;
        dataCurrent.data = data.dataCurrent
        orderCurrentNow.value = data.orderCurrentNow
    } else {
        console.error(`Failed to fetch products: ${response.status} ${response.statusText}`);
    }
}

const getproductallCount = async() => {
    const response = await fetch('/api/getproductallCount')
    if(response.ok) {
        const data = await response.json()

        productAll.value = data.productAll
    }
}

function formatThaiDateTime(date) {
  const options = { weekday: "long", year: "numeric", month: "long", day: "numeric" };
  const dateString = date.toLocaleDateString("th-TH", options);
  const timeString = date.toLocaleTimeString("th-TH");
  return `${dateString} ${timeString}`;
}

getDataDashboard()
getproductallCount()
fncCountdown()

</script>

<style scoped>

</style>