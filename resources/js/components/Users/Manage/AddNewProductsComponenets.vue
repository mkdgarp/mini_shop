<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12 my-2">
                <div class="card custom-card">
                    <span><i class="far fa-layer-plus text-primary"></i> สร้างสินค้าใหม่ในระบบ</span>
                    <hr class="my-2">

                    <div class="row">
                        <div class="col-12 my-2">
                            <!-- <input class="form-control" type="text" placeholder="* เจ้าของสินค้า"> -->
                            <div class="form-floating">
                                <select v-model="owner_products" class="form-select" id="floatingSelect"
                                    aria-label="กลุ่มลูกค้า" required>
                                    <option disabled selected value="0">เลือกเจ้าของสินค้า</option>
                                    <option v-for="(dataOwnerss, key) in dataOwners.data" :key="key"
                                        :value="dataOwnerss.id">
                                        {{ dataOwnerss.name }}</option>
                                </select>

                                <label for="floatingSelect">* เจ้าของสินค้า</label>
                            </div>


                        </div>
                        <div class="col-12 my-2">
                            <input v-model="products_name" class="form-control" type="text" placeholder="* ชื่อสินค้า"
                                required>
                        </div>
                        <!-- <div class="col-12 my-2">
                            <input class="form-control" type="text" placeholder="* กลุ่มสินค้า">
                        </div> -->

                        <div class="col-6 my-2">
                            <label for="">ราคาทุน</label><small class="text-primary ps-2">(ถ้าไม่รู้ใส่ 0)</small>
                            <input v-model="cost" class="form-control" type="number" placeholder="ราคาทุน">

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-6 my-2">
                            <label for="">ราคาขายหน้าร้าน</label>
                            <input v-model="price" class="form-control" type="number" placeholder="* ราคาขายหน้าร้าน"
                                required>
                        </div>
                        <div class="col-6 my-2">
                            <label for="">ราคาเดลิเวอร์ลี่</label>
                            <input v-model="delivery_price" class="form-control" type="number"
                                placeholder="* ราคาเดลิเวอร์ลี่" required>
                        </div>
                    </div>
                    <hr class="my-2">
                    <button class="btn btn-success" @click="createNewProducts">สร้างสินค้าใหม่</button>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import axios from 'axios';

const owner_products = ref(0)
const products_name = ref('')
const cost = ref(0)
const price = ref(0)
const delivery_price = ref(0)

const dataOwners = reactive({})

const getOwnerAll = async () => {
    axios.get(`/api/getOwnerAll`, {
    })
        .then(response => {
            dataOwners.data = response.data
        })
        .catch(error => {
            alert(error);
        });
}

const createNewProducts = async () => {

    if (owner_products.value == 0 || products_name.value == '' || products_name.value == ' ' || price.value == 0 || delivery_price.value == 0) {
        Swal.fire({
            icon: 'error',
            text: 'ใส่ข้อมูลที่มีเครื่องหมาย * ให้ครบทุกช่อง',
            showConfirmButton: false,
            timer: 2500
        })
        return;
    }

    Swal.fire({
        text: 'ยืนยันการสร้างสินค้าใหม่?',
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
            axios.post(`/api/addNewProducts`, {
                owner_products: owner_products.value,
                products_name: products_name.value,
                cost: (cost.value == 0) ? price.value : cost.value,
                price: price.value,
                delivery_price: delivery_price.value,
            })
                .then(response => {

                    if (response.data.msg == 'success') {
                        Swal.fire({
                            icon: 'success',
                            text: 'สร้างสินค้า ' + products_name.value + ' สำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(resp => {
                            window.location.reload()
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
getOwnerAll()
</script>