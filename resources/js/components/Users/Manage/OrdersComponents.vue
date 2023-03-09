<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <span>จัดการออเดอร์ </span>
                <span v-if="dataCurrent?.data" class=""><b class="text-primary"
                        v-if="dataCurrent?.data[0]?.is_delivery == 0">โต๊ะ {{ dataCurrent?.data[0]?.order_name }}</b><b
                        class="text-success" v-else>เดลิเวอรี่ {{ dataCurrent?.data[0]?.order_name }}</b></span>
            </div>


        </div>
    </div>
    <div class="container">
        <div class="row">

            <div class="col-12 my-2">
                <div class="card custom-card">
                    <div class="col-12">
                        <div class="d-flex">
                            <span class="d-block">รายการสินค้า </span>
                            <div class="ms-auto justify-content-between">
                                <!-- <button
                                    class="btn btn-secondary font-12" @click="disableAllInputs">แก้ไขรายการ</button>&nbsp; -->
                                <button class="btn btn-primary font-12" @click="openAdd = true">เพิ่มรายการสินค้า</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-floating my-2" v-if="openAdd">
                        <select class="form-select" id="floatingSelect" aria-label="เลือกสินค้า" v-model="newProduct">
                            <option selected disabled value="0">* เลือกสินค้า</option>
                            <option v-for="(dataProducts, key) in filteredProducts" :value="dataProducts.id"
                                :key="dataProducts.id">
                                {{ dataProducts.name }}
                            </option>
                        </select>
                        <label for="floatingSelect">เลือกสินค้า</label>

                        <button class="btn  btn-outline-primary my-2 w-100" @click="confirmAddProduct">เพิ่มสินค้า</button>
                    </div>

                    <hr class="my-2">
                    <!-- <div class="row" v-for="(datas,key) in dataProduct.data" :key="key">
                        <div class="col-12">
                            <div class="p-2 m-1 d-flex w-100 align-items-center">
                                สินค้า {{ datas.name }}
                            </div>
                            
                        </div>
                    </div> -->

                    <div class="py-2">สถานะออเดอร์
                        <span v-if="dataCurrent?.data[0]?.is_checkbill == 0"
                            class="fw-bold text-danger">ยังไม่เช็คบิล</span>
                        <span v-else class="fw-bold text-success">เช็คบิลแล้ว</span>

                    </div>
                    <table class="table table-bordered table-striped text-center align-middle">
                        <thead>
                            <tr>
                                <th width="15%">ลำดับ</th>
                                <th width="40%">ชื่อ</th>
                                <th width="20%">ราคา</th>
                                <th>จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(product, key_pro) in dataProduct.data" :key="key_pro">
                                <td :class="(product.price === 'ระบุจำนวนสินค้าก่อน') ? 'text-danger' : ''">
                                    {{ key_pro + 1 }}
                                </td>
                                <td :class="(product.price === 'ระบุจำนวนสินค้าก่อน') ? 'text-danger' : ''">{{ product.name
                                }}
                                </td>
                                <td :class="(product.price === 'ระบุจำนวนสินค้าก่อน') ? 'text-danger' : ''">{{ product.price
                                }}</td>
                                <td><input
                                        @change="changeForUpdate(product.id, dataCurrent?.data[0]?.order_id, product.amount)"
                                        :class="(product.price === 'ระบุจำนวนสินค้าก่อน') ? 'border-danger form-control text-center ' : 'form-control text-center '"
                                        type="num" v-model="product.amount">
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4">สินค้าทั้งหมด <span class="text-primary fw-bold">{{
                                    dataCurrent?.data[0]?.count_product }}</span> รายการ
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" class="fw-bold text-primary">สรุปยอด</td>
                            </tr>
                            <tr v-if="dataCurrent?.data[0]?.total_price_owner_1">
                                <td colspan="2">ส่วนกลาง</td>
                                <td colspan="2" class="">{{ dataCurrent?.data[0]?.total_price_owner_1 }} ฿</td>
                            </tr>
                            <tr v-if="dataCurrent?.data[0]?.total_price_owner_2">
                                <td colspan="2">หม่าล่า 99</td>
                                <td colspan="2" class="">{{ dataCurrent?.data[0]?.total_price_owner_2 }} ฿</td>
                            </tr>
                            <tr v-if="dataCurrent?.data[0]?.total_price_owner_3">
                                <td colspan="2">YakYen</td>
                                <td colspan="2" class="">{{ dataCurrent?.data[0]?.total_price_owner_3 }} ฿</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="fw-bold">ยอดสุทธิ</td>
                                <td colspan="2" class="text-success fw-bold">{{ dataCurrent?.data[0]?.total }} ฿</td>
                            </tr>
                        </tfoot>
                    </table>
                    <hr class="my-2">
                    <button v-if="dataCurrent?.data[0]?.is_checkbill == 0" class="btn btn-success"
                        @click="checkBillOrders(dataCurrent?.data[0]?.order_id)">เช็คบิล</button>
                    <button v-else class="btn btn-primary">
                        <i class="fas fa-print"></i>&nbsp;พิมพ์ใบเสร็จ
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
// const ordersId = ref(this.$route.params.ordersId)
const route = useRoute();
const dataProduct = reactive({})
const dataCurrent = reactive({})
const backupProduct = reactive([]);
const newProduct = ref(0);
const openAdd = ref(false)

const getOrderByID = async () => {
    axios.get(`/api/getOrdersByID?ordersId=${route.params.ordersId}`)
        .then(response => {
            dataProduct.data = response.data.product
            dataCurrent.data = response.data.dataCurrent
            backupProduct.data = response.data.backupProduct
        })
        .catch(error => {
            console.log(error);
        });
}

const filteredProducts = computed(() => {
    return backupProduct.data.filter((productzz) => {
        return !dataProduct.data.some(productss => productss.id === productzz.id);
    });
});

function getProductName(productId) {
    const product_name = backupProduct.data.find(p => p.id === productId);
    return product_name ? product_name.name : 'error';
}

async function confirmAddProduct() {
    if (getProductName(newProduct.value) === 'error') {
        alert('กรุณาเลือกสินค้าก่อน')
        return;
    }

    if (!checkDuplicate({ id: newProduct.value, amount: 0, name: getProductName(newProduct.value), price: 'ระบุจำนวนสินค้าก่อน' })) {
        dataProduct.data.push({ id: newProduct.value, amount: 0, name: getProductName(newProduct.value), price: 'ระบุจำนวนสินค้าก่อน' })
    } else {
        alert('สินค้าซ้ำ กรุณาระบุจำนวนสินค้า เพื่อให้ระบบอัพเดตข้อมูลใหม่')
        return;
    }

    newProduct.value = 0;
}

function checkDuplicate(product) {
    return dataProduct.data.some(p => p.id === product.id);
}

async function changeForUpdate(product_id, orders_id, amount) {
    console.log(product_id, orders_id, amount)
    if (amount.match(/^[0-9]+$/) == null) {
        alert('ระบุจำนวนเป็นตัวเลขเท่านั้น')
        window.location.reload()
        return;
    }
    Swal.fire({
        text: 'ยินยันการปรับจำนวนสินค้า?',
        //   text: "You won't be able to revert this!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1adc76',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            axios.post(`/api/updateProderByOrders`, {
                product_id: product_id,
                orders_id: orders_id,
                amount: parseInt(amount)
            })
                .then(response => {

                    if (response.data == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: 'เปลี่ยนแปลงจำนวนสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        getOrderByID()
                    }

                })
                .catch(error => {
                    alert(error);
                });
        } else {
            window.location.reload()
        }
    })

}

const checkBillOrders = async (orders_id) => {
    Swal.fire({
        text: 'ยืนยันการเช็คบิล?',
        //   text: "You won't be able to revert this!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1adc76',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            axios.post(`/api/checkBillOrders`, {
                orders_id: orders_id,
            })
                .then(response => {

                    if (response.data.msg == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: 'เช็คบิลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1250
                        }).then((resp) => {
                            window.location.reload()
                        })

                        // getOrderByID()
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            text: 'ไม่พบหมายเลขออเดอร์นี้ หรือ ออเดอร์ถูกเช็คบิลไปแล้ว',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }

                })
                .catch(error => {
                    alert(error);
                });
        } else {
            window.location.reload()
        }
    })
}
getOrderByID()
</script>