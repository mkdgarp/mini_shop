<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-12 my-2">
                <div class="card custom-card">
                    <span><i class="fas fa-cart-plus text-primary"></i> จัดการสินค้า</span>
                    <hr class="my-1">
                    <div class="row">
                        <div class="col-12 my-2">
                            <table class="table table-bordered table-striped text-center align-middle">
                                <thead>
                                    <tr>
                                        <th width="10%">รหัส</th>
                                        <th width="25%">ชื่อสินค้า</th>
                                        <th width="15%">ราคา<br>ทุน</th>
                                        <th width="15%">ราคา<br>ขายหน้าร้าน</th>
                                        <th width="15%">ราคา<br>เดลิเวอร์ลี่</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(product, key_pro) in dataProduct.data" :key="key_pro">
                                        <td>
                                            {{ product.id }}
                                        </td>
                                        <td class="text-primary fw-bold">{{ product.name }}</td>
                                        <td>{{ product.cost }}</td>
                                        <td>{{ product.price }}</td>
                                        <td>{{ product.delivery_price }}</td>
                                        <td><button class="btn btn-danger px-1"
                                                @click="disableProduct(product.id,product.name)">ลบสินค้า</button></td>

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
import { ref, reactive } from 'vue';
import axios from 'axios';
const dataProduct = reactive({})
const getProductAll = async () => {
    axios.get(`/api/getAllProduct_Manage`, {
    })
        .then(response => {
            dataProduct.data = response.data
        })
        .catch(error => {
            // alert(error);
        });
}

const disableProduct = async (product_id,p_name) => {

    Swal.fire({
        html: `ยืนยันการลบสินค้า <span class='fw-bold text-primary'>${p_name}</span> ?`,
        //   text: "You won't be able to revert this!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1adc76',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก'
    }).then(async (result) => {
        if (result.isConfirmed) {
            axios.post(`/api/disableProduct`, {
                product_id: product_id
            })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        html: `ลบสินค้า <span class='fw-bold text-primary'${p_name}</span> สำเร็จ `,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(resp => {
                        window.location.reload()
                    })
                })
                .catch(error => {
                    // alert(error);
                });
        }
    })

}
getProductAll()
</script>

<style scoped>
tbody,
td,
tfoot,
th,
thead,
tr {
    font-size: 12px !important;
    vertical-align: middle;
}

.btn-danger {
    font-size: 10px !important;
}
</style>