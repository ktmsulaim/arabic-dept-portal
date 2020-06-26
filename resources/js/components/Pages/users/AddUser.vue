<template>
  <div class="row">
      <div class="col-md-6">
          <div class="card">
              <div class="card-header">
                    <h5 class="card-title">اعمل جديد</h5>
                    <div class="card-tools">
                        <router-link class="btn btn-tool" :to="{name: 'Users'}">المستخدمون</router-link>
                    </div>
                </div>
                <div class="card-body">                    
                    <div class="mb-2" v-if="feedback">
                        <p class="text-danger" v-if="feedback">{{ feedback }}</p>
                    </div>
                    <div class="errors" v-if="errors.length > 0">
                        <div class="text-danger"  v-for="(error, index) in errors" :key="index">
                            <p v-for="(err, i) in error" :key="i"> {{ err }} </p>
                        </div>
                    </div>
                    <form @submit.prevent="addUser" id="editUser">
                        <input type="hidden" name="_token" :value="csrf">

                        <div class="form-group">
                            <label for="name">اسم</label>
                            <input type="text" class="form-control" name="name" id="name" v-model="user.name" required>
                        </div>
                        <div class="form-group">
                            <label for="username">اسم المستخدم</label>
                            <input type="text" class="form-control" name="username" id="username" v-model="user.username" required>
                        </div>
                        <div class="form-group">
                            <label for="email">البريد الإلكتروني</label>
                            <input type="email" class="form-control" name="email" id="email" v-model="user.email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">كلمة المرور</label>
                            <input type="password" class="form-control" name="password" id="password" v-model="user.password">
                        </div>
                        <div class="form-group">
                            <label for="is_admin"></label>
                            <select name="is_admin" id="is_admin" v-model="user.is_admin" class="form-control" required>
                                <option value="0" selected>اساسي</option>
                                <option value="1">مشرف</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
          </div>
      </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'AddUser',
    data() {
        return {
            csrf: $('meta[name=csrf-token]').attr('content'),
            user:{
                id: null,
                name: null,
                username: null,
                email: null,
                password: null,
                is_admin: null,
                api_token: window.api_token
            },
            feedback: null,
            errors: []
        }
    },
    methods: {
        addUser(){
            if (this.user.name && this.user.username && this.user.email 
            && this.user.password && this.user.is_admin) {

                // Validate password is atleast 3 
                if(this.user.password.length < 3) {
                    this.feedback = 'مطلوب 3 أحرف على الأقل في كلمة المرور'
                    $('#password').focus()
                } else {
                    axios.post('/api/users', this.user)
                    .then(resp => {
                        this.clearUserData()
                        this.$router.push({name: 'Users'})
                    })
                    .catch(error => {
                        console.log(error.response.data.errors)
                        this.errors.push(error.response.data.errors)
                    })
                }
            } else {
                this.feedback = "جميع البيانات مطلوبة"
            }
        },
        clearUserData(){
            this.user.id = null
            this.user.name = null
            this.user.username = null
            this.user.email = null
            this.user.password = null
            this.user.is_admin = null
        }
    },
}
</script>

<style>

</style>