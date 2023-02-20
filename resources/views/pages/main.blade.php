<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <div class="card card-custom">
                <h5>ออเดอร์ยังไม่เช็คบิล</h5>
                <hr class="mt-1">

                <div id="mydiv"></div>
                <table class="table table-borderless w-100 table-striped table-hover">
                    <thead>
                        <tr>
                            <th>1</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-custom">
                <h5>ออเดอร์วันนี้</h5>
                <hr class="mt-1">

                <table class="table table-borderless w-100 table-striped table-hover">
                    <thead>
                        <tr>
                            <th>1</th>
                        </tr>
                    </thead>
                    <tbody class="tbody_today_orders">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(async function() {
        geOrderCurrent();
        getTodayOrders();
        console.log("ready!");



    });

    const geOrderCurrent = async () => {
        await axios.get('/api/getTodayOrders', {})
            .then(function(response) {
                console.log(response.data.data_orders);
                let x;
                let j;
                for (x = 0; x < response.data.data_orders.length; x++) {
                    for (j in response.data.data_orders[x].orders_detail) {
                        $('.tbody_today_orders').append(
                            `<tr >
                                <td>
                                    ${j.customers_name}
                            </td>
                            <td class="text-primary fw-bold">
        </td>
        <td class="fw-bold">
        </td>
        </tr>`
                        )
                    }

                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }

    const getTodayOrders = async () => {
        await axios.get('/api/getTodayOrders', {})
            .then(function(response) {
                console.log(response.data.data_orders);
                let x;
                let j;
                for (x = 0; x < response.data.data_orders.length; x++) {
                    for (j in response.data.data_orders[x].orders_detail) {
                        $('.tbody_today_orders').append(
                            `<tr >
                                <td>
                                    ${j.customers_name}
                            </td>
                            <td class="text-primary fw-bold">
        </td>
        <td class="fw-bold">
        </td>
        </tr>`
                        )
                    }

                }
            })
            .catch(function(error) {
                console.log(error);
            });
    }
</script>
