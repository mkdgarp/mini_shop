<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="d-flex">
                        <div class="blobs-container">
                            <div class="blob red"></div>
                        </div> ออเดอร์ที่เช็คบิลแล้วทั้งหมด
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
                                        <button v-if="datas.is_delivery == 0" class="btn btn-primary ">ดูออเดอร์</button>
                                        <button v-else class="btn btn-success ">ดูออเดอร์</button>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div v-else>
                        <h5 class="text-center d-block text-primary py-2">ไม่พบรายการออเดอร์</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';

const dataCurrent = reactive({})
const orderCurrentNow = ref(0)

const getHistory = async () => {
    axios.get(`/api/getHistory`, {
    })
        .then(response => {
            dataCurrent.data = response.data.dataCurrent
            orderCurrentNow.value = response.data.orderCurrentNow
        })
        .catch(error => {
            alert(error);
        });
}
getHistory()
</script>