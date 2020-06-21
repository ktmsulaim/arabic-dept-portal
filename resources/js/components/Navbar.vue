<template>
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
    <li class="nav-item">
        <router-link :to="{name: 'Home'}" class="nav-link">
        <i class="nav-icon fa fa-home"></i>
        <p>الصفحة الرئيسية</p>
        </router-link>
    </li>
    <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
        <i class="nav-icon fa fa-dashboard"></i>
        <p>
            المستخدمون
            <i class="right fa fa-angle-left"></i>
        </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <router-link :to="{name: 'NewUser'}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>اعمل جديد</p>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{name: 'Users'}" class="nav-link">
                    <i class="fa fa-circle-o nav-icon"></i>
                    <p>عرض الكل</p>
                </router-link>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a href="javascript:void(0)" class="nav-link">
        <form action="/logout" method="post">
            <input type="hidden" name="_token" :value="csrf">
            <button class="btn-simple btn-logout" type="submit">
            <i class="nav-icon fa fa-sign-out"></i>
            <span>تسجيل خروج</span>
            </button>
        </form>
        </a>
    </li>
    </ul>
</nav>
</template>

<script>
export default {
    data() {
        return {
            csrf: $('meta[name=_token]').attr('content'),
            base: window.BASE_URL
        }
    },
    methods: {
       
    },
}
</script>

<style>

</style>