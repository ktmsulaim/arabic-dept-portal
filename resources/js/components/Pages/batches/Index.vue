<template>
  <div class="batches">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title">دفعات</h5>
            <div class="card-tools">
              <button @click="showForm('new')" class="btn btn-tool">
                جديد <i class="fa fa-plus fa-fw"></i>
              </button>
            </div>
          </div>
          <div class="card-body table-responsive">
            <table class="table table-bordered" v-if="batches">
              <thead>
                <tr>
                  <th>#</th>
                  <th>اسم</th>
                  <th>بداية</th>
                  <th>نهاية</th>
                  <th>عدد الباحثين</th>
                  <th>تاريخ</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="batch in batches" :key="batch.id">
                  <td>{{ batch.id }}</td>
                  <td>{{ batch.name }}</td>
                  <td>{{ batch.start }}</td>
                  <td>{{ batch.end }}</td>
                  <td>{{ batch.students }}</td>
                  <td dir="ltr">{{ batch.created_at }}</td>
                  <td>
                    <span
                      @click="showForm('edit', batch.id)"
                      class="btn btn-info btn-sm"
                      ><input type="hidden" /><i class="fa fa-edit"></i
                    ></span>
                  </td>
                  <td>
                    <span @click="del(batch.id)" class="btn btn-danger btn-sm"
                      ><i class="fa fa-trash"></i
                    ></span>
                  </td>
                </tr>
              </tbody>
            </table>
            <p class="text-muted" v-else>آسف! لاتوجد بيانات</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Add or edit modal -->
    <div class="modal fade" id="modal" style="display: none" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header justify-content-between">
            <h4 class="modal-title">{{ title }}</h4>
            <button
              type="button"
              class="close m-0 p-0"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="save(type)" method="post">
              <div class="mb-2">
                <p v-if="feedback" class="text-danger">{{ feedback }}</p>
              </div>
              <input type="hidden" name="_token" :value="csrf" />
              <input type="hidden" name="_method" value="PUT" />

              <div class="form-group">
                <label for="name">اسم</label>
                <input
                  type="text"
                  class="form-control"
                  name="name"
                  id="name"
                  v-model="batch.name"
                  required
                />
              </div>
              <div class="form-group">
                <label for="start">بداية</label>
                <datepicker
                  v-model="batch.start"
                  name="start"
                  input-class="form-control"
                  :format="format"
                  :bootstrap-styling="true"
                ></datepicker>
              </div>
              <div class="form-group">
                <label for="end">نهاية</label>
                <datepicker
                  v-model="batch.end"
                  name="end"
                  input-class="form-control"
                  :format="format"
                  :bootstrap-styling="true"
                ></datepicker>
              </div>
              <div class="form-group">
                <button
                  type="button"
                  class="btn btn-default"
                  data-dismiss="modal"
                  @click="clear"
                >
                  أغلق
                </button>
                <button class="btn btn-primary">حفظ التغييرات</button>
              </div>
            </form>
          </div>
          <!-- <div class="modal-footer justify-content-between">
                </div> -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- END -->
  </div>
</template>

<script>
import axios from "axios";
import Datepicker from "vuejs-datepicker";

export default {
  name: "Batches",
  components: {
    Datepicker,
  },
  data() {
    return {
      csrf: $("meta[name=csrf-token]").attr("content"),
      batches: null,
      api_token: window.api_token,
      batch: {
        id: null,
        name: null,
        start: null,
        end: null,
      },
      title: "اضف جديد",
      feedback: null,
      type: null,
    };
  },
  methods: {
    listAll() {
      axios.get("api/batches?api_token=" + this.api_token).then((resp) => {
        // console.log(resp.data.data);
        this.batches = resp.data.data;
      });
    },
    showForm(type, id = null) {
      if (type == "new") {
        this.title = "اضف جديد";
        this.type = "new";
      } else {
        this.title = "تعديل";
        this.type = "edit";
        this.batch.id = id;

        if (this.batch.id) {
          // get batch and set to batch
          axios
            .get(
              "/api/batches/" + this.batch.id + "?api_token=" + this.api_token
            )
            .then((resp) => {
              console.log(resp.data.data);
              let data = resp.data.data;

              this.batch.name = data.name;
              this.batch.start = data.start;
              this.batch.end = data.end;
            })
            .catch((error) => console.log(error));
        }
      }
      $("#modal").modal("show");
    },
    save(type) {
      if (this.batch.name && this.batch.start && this.batch.end) {
        if (type == "new") {
          axios
            .post("/api/batches?api_token=" + this.api_token, this.batch)
            .then((resp) => {
              $("#modal").modal("hide");
              this.listAll();
              this.clear();
            })
            .catch((error) => console.log(error));
        } else {
          if (this.batch.id) {
            axios
              .put(
                "/api/batches/" +
                  this.batch.id +
                  "?api_token=" +
                  this.api_token,
                this.batch
              )
              .then((resp) => {
                this.clear();
                $("#modal").modal("hide");
                this.listAll();
              })
              .catch((error) => console.log(error));
          }
        }
      } else {
        this.feedback = "جميع البيانات المطلوبة";
      }
    },
    del(id) {
      if (id) {
        axios
          .delete("/api/batches/" + id + "?api_token=" + this.api_token)
          .then((resp) => {
            this.clear();
            this.listAll();
          })
          .catch((error) => console.log(error));
      }
    },
    clear() {
      this.batch.id = null;
      this.batch.name = null;
      this.batch.start = null;
      this.batch.end = null;
      this.type = null;
      this.feedback = null;
      this.title = null;
    },
    format(date) {
      return moment(date).format("MMM DD, YYYY");
    },
  },
  created() {
    this.listAll();
  },
};
</script>

<style>
</style>