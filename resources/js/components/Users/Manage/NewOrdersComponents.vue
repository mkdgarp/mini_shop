<template>
    <!-- <div class="container mt-2">
        <div class="row">
            <div class="col-12">
                <span>สร้างออเดอร์ใหม่ </span>
            </div>


        </div>
    </div> -->
    <div class="container mt-2">
        <div class="row">
            <div class="col-12 my-2">
                <div class="card custom-card">
                    <span><i class="fas fa-cart-plus text-primary"></i> สร้างออเดอร์ใหม่</span>
                    <hr class="my-1">
                    <div class="row">
                        <div class="col-12 my-2">
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="* ใส่ชื่อโต๊ะ" v-model="tableName">

                        </div>
                        <div class="col-12 my-2">
                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="กลุ่มลูกค้า"
                                    v-model="tableCategory">
                                    <option selected disabled value="0">* ประเภทออเดอร์</option>
                                    <option value="1">
                                        ออเดอร์ทั่วไป
                                    </option>
                                    <option value="2">
                                        ออเดอร์เดลิเวอรี่
                                    </option>

                                </select>
                                <label for="floatingSelect">กลุ่มลูกค้า</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 my-2 text-end">
                            <!-- <button class="btn btn-primary" @click="addingProduct = true">เลือกรายการสินค้า</button>&nbsp; -->
                            <button class="btn btn-success" @click="createNewOrders"
                                v-bind:disabled="btnLock">สร้างออเดอร์</button>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 my-2">

                            <div class="form-floating">
                                <select class="form-select" id="floatingSelect" aria-label="เลือกสินค้า"
                                    v-model="newProduct">
                                    <option selected disabled value="0">* เลือกสินค้า</option>
                                    <option v-for="(dataProducts, key) in filteredProducts" :value="dataProducts.id"
                                        :key="dataProducts.id">
                                        {{ dataProducts.name }}
                                    </option>
                                </select>
                                <label for="floatingSelect">เลือกสินค้า</label>

                                <button class="btn  btn-outline-primary my-2 w-100"
                                    @click="confirmAddProduct">เพิ่มสินค้า</button>
                            </div>
                        </div>

                        <!-- <button @click="addingProduct = false">ยกเลิก</button> -->
                    </div>

                    <div class="row" v-if="products.length > 0">
                        <div class="col-12">

                            <!-- {{ product.name }} - {{ product.price }} -->

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
                                    <tr v-for="(product, key_pro) in products" :key="key_pro">
                                        <td>
                                            {{ key_pro + 1 }}
                                        </td>
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.price }}</td>
                                        <td><input class="form-control text-center" type="num" v-model="product.amount">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue';
const preProduct = ref([]);
const products = reactive([]);
const dataProduct = reactive({});
let nextProductId = 1;
const addingProduct = ref(false);
const newProduct = ref(0);
const tableName = ref('')
const tableCategory = ref(0)
const btnLock = ref(false)
async function addProduct() {
    addingProduct.value = true;
}

async function confirmAddProduct() {
    // getProductPrice(newProduct.value)
    if (getProductName(newProduct.value) === 'error') {
        alert('กรุณาเลือกสินค้าก่อน')
        return;
    }
    products.push({ product_id: newProduct.value, name: getProductName(newProduct.value), price: getProductPrice(newProduct.value), amount: 1 })
    // addingProduct.value = false;
    newProduct.value = 0;
}

async function fetchProducts() {
    const response = await fetch('/api/fetch_product');
    if (response.ok) {
        const data = await response.json();
        // console.log(data)
        dataProduct.data = data;
    } else {
        console.error(`Failed to fetch products: ${response.status} ${response.statusText}`);
    }
}

function getProductPrice(productId) {
    const product_price = dataProduct.data.find(p => p.id === productId);
    // console.log(product_price)
    return product_price ? product_price.price : 'error';
}

function getProductName(productId) {
    const product_name = dataProduct.data.find(p => p.id === productId);
    return product_name ? product_name.name : 'error';
}

const filteredProducts = computed(() => {
    return dataProduct.data.filter(productzz => {
        return !products.some(productss => productss.product_id === productzz.id);
    });
});


async function createNewOrders() {
    if (tableName.value == '' || tableCategory.value == 0 || tableCategory.value == '0' || products.length <= 0) {
        alert('กรุณาใส่ข้อมูลที่จำเป็นให้ครบทุกช่อง')
        return;
    }
    btnLock.value = true

    Swal.fire({
        title: 'ยืนยันการสร้างออเดอร์ใหม่?',
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
            const response = await fetch('/api/createNewOrders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ 'tableName': tableName.value, 'tableCategory': tableCategory.value, 'product': products }),
            });
            if (response.ok) {

                // const savedOrder = await response.json();
                // order.value = savedOrder;
                window.location.replace('/orders/' + response.data);
            } else {

                alert(`ติดต่อ DEV ด่วน 0864331121 \n Failed to add product to order: ${response.status} ${response.statusText}`);
                btnLock.value = false
            }
        }
    })



}
fetchProducts()


</script>