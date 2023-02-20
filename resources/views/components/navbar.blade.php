<nav class="navbar bg-navbar-home p-3 py-4">
    <div class="container">

        <a class="navbar-brand" href="/home" tabindex="-1">
            {{-- <img src="../../img/logo.jpg" width="40px" class="d-inline-block align-text-top" /> --}}
            {{-- <span class="namesv">Eden Craft<br><small>my shop</small></span> --}}
            myshop
        </a>
        <?php
        $data_tooltip = '<b>EdenCraft</b><br>เซิฟเวอร์มายคราฟ ที่เน้น สังคม คอมมูนิตี้สำหรับทุกเพศทุกวัย!<br> ';
        ?>
        <div class="float-end" id="question-svg" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-html="true"
            title="<?php echo $data_tooltip; ?>">
            {{-- <a href="#" class="text-333 h6">เข้าสู่ระบบ</a> --}}
            {{-- {!! file_get_contents('svg/question-svgrepo-com.svg') !!} --}}
        </div>
    </div>

</nav>
