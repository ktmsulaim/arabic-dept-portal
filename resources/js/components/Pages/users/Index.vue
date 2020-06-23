<template>
    <div class="users row">
        <div v-if="response.status" class="col-md-12">
            <div :class="response.type">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                {{ response.message }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">المستخدمون</h5>
                    <div class="card-tools">
                        <button @click="showForm" class="btn btn-tool">جديد <i class="fa fa-plus fa-fw"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" v-if="users">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الإلكتروني</th>
                                <th>وظيفة</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.username }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.is_admin == 0 ? 'اساسي' : 'مشرف' }}</td>
                                <td><i @click="editUser(user.id)" style="cursor:pointer" title="تعديل" class="fa fa-pencil"></i></td>
                                <td><i @click="deleteUser(user.id)" style="cursor:pointer" title="حذف" class="fa fa-trash text-danger"></i></td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="text-muted" v-else>آسف! لاتوجد بيانات</p>
                </div>
            </div>
        </div>

        <!-- Add modal -->
        <div class="modal fade" id="add" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">اعمل جديد</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <p v-if="feedback" class="text-danger">{{ feedback }}</p>
                    </div>
                    <form @submit.prevent="addUser" id="addUser">
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
                            <input type="password" class="form-control" name="password" id="password" v-model="user.password" required>
                        </div>
                        <div class="form-group">
                            <label for="is_admin"></label>
                            <select name="is_admin" id="is_admin" v-model="user.is_admin" class="form-control" required>
                                <option value="0">اساسي</option>
                                <option value="1">مشرف</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">أغلق</button>
                <button form="addUser" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- END -->

        <!-- Edit Modal -->
        <div class="modal fade" id="edit" style="display: none;" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title">تحرير العضو</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <p v-if="feedback" class="text-danger">{{ feedback }}</p>
                    </div>
                    <form @submit.prevent="updateUser" id="editUser">
                        <input type="hidden" name="_token" :value="csrf">
                        <input type="hidden" name="_method" value="PUT">

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
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">أغلق</button>
                <button form="editUser" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </div>
            <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- END -->
    </div>
</template>

<script>
import axios from 'axios'

export default {
    name: 'Users',
    data() {
        return {
            csrf: $('meta[name=csrf-token]').attr('content'),
            users: null,
            user:{
                id: null,
                name: null,
                username: null,
                email: null,
                password: null,
                is_admin: null
            },
            feedback: null,
            response: {
                status: false,
                type: null,
                message: null
            }
        }
    },
    methods: {
        getUser(id) {
            axios.get('/api/users/' + id)
            .then(resp => {
                const data = resp.data.data;
                this.user.id = data.id
                this.user.name = data.name
                this.user.username = data.username
                this.user.email = data.email
                this.user.password = data.password
            })
            .catch(error => console.log(error))
        },
        listUsers(){
            axios.get('/api/users')
            .then(resp => {
                this.users = resp.data.data
                
            })
            .catch(error => console.log(error))
        },
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
                        $('#add').modal('hide')
                        this.listUsers()
                        this.showResponse('success', true)
                    })
                    .catch(error => {
                        console.log(error)
                        this.showResponse('error', true)
                    })
                }
            } else {

                this.feedback = "جميع البيانات مطلوبة"
            }
        },
        editUser(id){
            $('#edit').modal('show')
            this.getUser(id)
            this.user.id = id
        },
        updateUser(){
            if (this.user.password) {
                axios.put('/api/users/' + this.user.id, this.user)
                .then(resp => {
                    this.clearUserData()
                    $('#edit').modal('hide')
                    this.listUsers()
                    this.showResponse('success', true)
                })
                .catch(error => {
                    console.log(error)
                    this.showResponse('error', true)
                })
            } else {
               axios.put('/api/users/' + this.user.id, {
                   id: this.user.id,
                   name: this.user.name,
                   username: this.user.username,
                   email: this.user.email,
                   is_admin: this.user.is_admin,
               })
                .then(resp => {
                    this.clearUserData()
                    $('#edit').modal('hide')
                    this.listUsers()
                    this.showResponse('success', true)
                })
                .catch(error => {
                    console.log(error)
                    this.showResponse('error', true)
                })
            }
        },
        clearUserData(){
            this.user.id = null
            this.user.name = null
            this.user.username = null
            this.user.email = null
            this.user.password = null
        },
        showForm(){
            $('#add').modal('show')
        },
        deleteUser(id){
            if(id){
                axios.delete('/api/users/' + id)
                .then(() => {                    
                    this.clearUserData()
                    this.listUsers()
                    this.showResponse('success', true)
                })
                .catch(error => {
                    console.log(error.data.message)
                    this.showResponse('error', true)
                })
            }
        },
        showResponse(type, status){
            this.response.status = status

            if(type == 'success'){
                this.response.type = 'alert alert-success alert-dismissible'
                this.response.message = 'تمت معالجة الطلب بنجاح'
            } else {
                this.response.type = 'alert alert-danger alert-dismissible'
                this.response.message = 'لم تتم معالجة الطلب بنجاح'
            }
        }
    },
    created() {    
        this.listUsers()
        this.response.status = false
    },
}
</script>

<style>

</style>