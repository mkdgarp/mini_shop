<template>
    
    Hello! Champ
    ------------------------
    <div>
        <h4> frontend (Vue) > backend (Laravel) > return base64 </h4>
        <img :src="dataResp.data" >
        <h5 class="text-primary">ใช้งานได้ตามปกติทุกครั้ง</h5>
    </div>
    <hr>
    <div>
        <h4> frontend (Vue) > backend (Laravel) > return raw </h4>
        <img :src="dataResp.data_2" >
        <h5 class="text-warning">บางครั้งถูก Google Block ก่อนจะได้ Response</h5>
        <h5 class="text-success">มองเห็นรูปภาพจาก response แต่ถ้าจะโชว์ต้องแปลงเป็น image/uri หรือ base64</h5>
    </div>
    <hr>
    <div>
        <h4> frontend (Vue) > แนบ Url GDrive > backend (Laravel) > return base64 </h4>
        <img :src="dataResp.data_3" >
        <h5 class="text-primary">ใช้งานได้ตามปกติทุกครั้ง</h5>
    </div>
    <hr>
    <div>
        <h4> frontend (Vue) > แนบ Url GDrive > backend (Laravel) > return raw </h4>
        <img :src="dataResp.data_4" >
        <h5 class="text-warning">บางครั้งถูก Google Block ก่อนจะได้ Response</h5>
        <h5 class="text-success">มองเห็นรูปภาพจาก response แต่ถ้าจะโชว์ต้องแปลงเป็น image/uri หรือ base64</h5>
    </div>
    <hr>
    <div>
        <h4> frontend (Vue) > convert to base 64</h4>
        <img :src="dataResp.data_5" >
        <h5 class="text-danger">ถูก block ด้วย CORS policy *ไม่สามารถใช้ Frontend เรียกรูปภาพโดยตรง</h5>
    </div>
    <!-- http://localhost:8000/api/getImages?req=base64 -->
</template>

<script setup>

import { ref, reactive, computed } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';
const route = useRoute();
const dataResp = reactive({})

const getImages_1 = async () => {
    axios.get(`/api/getImages?req=base64 `)
        .then(response => {
            dataResp.data = response.data.image_uri
        })
        .catch(error => {
            console.log(error);
        });
}

const getImages_2 = async () => {
    axios.get(`/api/getImages?req=raw`)
        .then(response => {
            dataResp.data_2 = response.data
        })
        .catch(error => {
            console.log(error);
        });
}

const getImages_3 = async () => {
    axios.get(`/api/getImages?req=base64&imageUrl=https://drive.google.com/uc?id=1v-PdE4P_Xufr1wvMewxrblYxoXvBJCSa`)
        .then(response => {
            dataResp.data_3 = response.data.image_uri
        })
        .catch(error => {
            console.log(error);
        });
}
const getImages_4 = async () => {
    axios.get(`/api/getImages?req=raw&imageUrl=https://drive.google.com/uc?id=1v-PdE4P_Xufr1wvMewxrblYxoXvBJCSa`)
        .then(response => {
            dataResp.data_4 = response.data
        })
        .catch(error => {
            console.log(error);
        });
}

const getImages_5 = async () => {
    function toDataURL(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.onload = function() {
    var reader = new FileReader();
    reader.onloadend = function() {
      callback(reader.result);
    }
    reader.readAsDataURL(xhr.response);
  };
  xhr.open('GET', url);
  xhr.responseType = 'blob';
  xhr.send();
}

toDataURL('https://drive.google.com/uc?id=1v-PdE4P_Xufr1wvMewxrblYxoXvBJCSa', function(dataUrl) {
  console.log('RESULT:', dataUrl)
  dataResp.data_5 = dataUrl
})
}

getImages_1()
getImages_2()
getImages_3()
getImages_4()
getImages_5()
</script>