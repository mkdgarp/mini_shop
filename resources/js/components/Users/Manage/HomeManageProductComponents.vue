<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-6 my-2">
                <div class="card custom-card shadow">
                    <a href="/addnewproducts"><div class="show-detail-card-dash">สร้างสินค้าใหม่</div><small class="text-secondary text-center w-100 d-block">(คลิก)</small></a>
                </div>
            </div>
            <div class="col-6 my-2">
                <div class="card custom-card shadow">

                    <a href="/manageproduct"><div class="show-detail-card-dash">จัดการสินค้าทั้งหมดที่สร้าง</div><small class="text-secondary text-center w-100 d-block">(คลิก)</small></a>
                </div>
            </div>
        </div>

    </div>
</template>

<style scoped>
.show-detail-card-dash {
    display: flex;
    height: 150px;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 20px;
    color: #183153;
    line-height: 2;
}
</style>