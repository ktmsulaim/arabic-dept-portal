<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">تاريخ العمل</h3>
        <div class="card-tools">
          <span class="btn btn-tool" @click="jobAdd(null)"
            ><i class="fa fa-fw fa-plus"></i> اضف جديد</span
          >
        </div>
      </div>
      <div class="card-body table-responsive">
        <div class="" v-if="loading">
          <i class="fa fa-spin fa-spinner"></i> جار التحميل
        </div>
        <table v-else-if="jobs.length > 0" class="table table-bordered">
          <thead>
            <tr>
              <th>#</th>
              <th>اسم</th>
              <th>مكان</th>
              <th>من</th>
              <th>إلى</th>
              <th>الحالة</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(jb, i) in jobs" :key="i">
              <td>{{ i + 1 }}</td>
              <td>{{ jb.name }}</td>
              <td>{{ jb.place }}</td>
              <td>{{ jb.start_date }}</td>
              <td>{{ jb.end_date }}</td>
              <td>{{ jb.status == 1 ? "عامل" : "غير عامل" }}</td>
              <td>
                <span class="btn btn-sm btn-info"
                  ><i @click="jobAdd(jb.id)" class="fa fa-edit fa-fw"></i
                ></span>
              </td>
            </tr>
          </tbody>
        </table>
        <p class="text-muted" v-else>لم يتم إضافة أي وظيفة</p>
      </div>
    </div>
    <div
      class="modal fade"
      id="job"
      tabindex="-1"
      role="dialog"
      aria-labelledby="job-label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <ValidationObserver v-slot="{ invalidJob }">
            <form @submit.prevent="addToJobList">
              <div class="modal-header">
                <h5 class="modal-title" id="jobTitle">تفاصيل الوظيفة</h5>
                <button
                  type="button"
                  class="close m-0 p-0"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="name">اسم</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="job.name"
                    required
                  />
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="place">مكان</label>
                      <ValidationProvider rules="required" v-slot="{ errors }">
                        <input
                          type="text"
                          id="place"
                          class="form-control"
                          v-model="job.place"
                          required
                        />
                        <span class="text-danger">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="start_date">من</label>
                      <datepicker
                        v-model="job.start_date"
                        name="start"
                        input-class="form-control"
                        valueType="format"
                        :format="format"
                        :bootstrap-styling="true"
                        :required="true"
                      ></datepicker>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="end_date">إلى</label>
                      <datepicker
                        v-model="job.end_date"
                        name="start"
                        input-class="form-control"
                        :format="format"
                        :clear-button="true"
                        :bootstrap-styling="true"
                      ></datepicker>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="statusJob">الحالة</label>
                      <select
                        id="statusJob"
                        v-model="job.status"
                        class="form-control"
                        required
                      >
                        <option value="1">عامل</option>
                        <option value="0">غير عامل</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button
                  :disabled="rem.disabled"
                  @click="remove"
                  class="btn btn-danger"
                  type="button"
                >
                  <span v-if="rem.loading">جار الحذف</span>
                  <span v-else> حذف </span>
                </button>
                <div>
                  <button
                    type="button"
                    class="btn btn-default"
                    data-dismiss="modal"
                    @click="clear"
                  >
                    أغلق
                  </button>
                  <button
                    @click="save"
                    :disabled="invalidJob || btnLoading"
                    type="submit"
                    class="btn btn-primary mr-2"
                  >
                    <span v-if="btnLoading">
                      <i class="fa fa-spinner fa-spin"></i> جار الحفظ
                    </span>
                    <span v-else> حفظ التغييرات </span>
                  </button>
                </div>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import { extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";

extend("required", {
  ...required,
  message: "هذه البيانات مطلوبة",
});

export default {
  name: "StudentJobs",
  props: ["student_id"],
  components: {
    Datepicker,
  },
  data() {
    return {
      loading: true,
      modal: false,
      jobs: [],
      job: {
        name: null,
        place: null,
        start_date: null,
        end_date: null,
        status: null,
      },
      jobEdit: false,
      btnLoading: false,
      rem: {
        loading: false,
        disabled: false,
      },
    };
  },
  methods: {
    getJobs() {
      if (this.student_id) {
        axios
          .get(
            `/api/students/${this.student_id}/jobs?api_token=${window.api_token}`
          )
          .then((resp) => {
            this.jobs = resp.data.data;
            this.loading = false;
          })
          .catch((err) => {
            console.error(err);
            this.loading = false;
            this.$toast.error("آسف! غير قادر على معالجة طلبك");
          });
      }
    },
    jobAdd(id = null) {
      if (id) {
        this.job = this.jobs.find((job) => job.id == id);
        this.jobEdit = id;
      }

      $("#job").modal("show");
    },
    format(date) {
      return moment(date).format("MMM DD, YYYY");
    },
    clear() {
      this.job = {
        name: null,
        place: null,
        start_date: null,
        end_date: null,
        status: null,
      };

      this.jobEdit = false;
    },
    save() {
      this.btnLoading = true;
      this.job.student_id = this.student_id;

      if (this.jobEdit) {
        axios
          .patch(
            `/api/jobs/${this.jobEdit}?api_token=${window.api_token}`,
            this.job
          )
          .then((resp) => {
            this.btnLoading = false;
            const job = this.jobs.find((jb) => jb.id == this.jobEdit);
            const index = this.jobs.indexOf(job);
            this.jobs.splice(index, 1, resp.data.data);
            $("#job").modal("hide");
            this.clear();
            this.$toast.success("نجاح");
          })
          .catch((err) => {
            console.log(err);
            this.btnLoading = false;
            this.$toast.error("آسف! العمل: فشل");
          });
      } else {
        axios
          .post(`/api/jobs?api_token=${window.api_token}`, this.job)
          .then((resp) => {
            this.btnLoading = false;
            this.jobs.push(resp.data.data);
            $("#job").modal("hide");
            this.clear();
            this.$toast.success("نجاح");
          })
          .catch((err) => {
            console.log(err);
            this.btnLoading = false;
            this.$toast.error("آسف! العمل: فشل");
          });
      }
    },
    remove() {
      this.rem.disabled = true;
      this.rem.loading = true;

      if (this.jobEdit) {
        axios
          .delete(`/api/jobs/${this.jobEdit}?api_token=${window.api_token}`)
          .then((resp) => {
            this.rem.disabled = false;
            this.rem.loading = false;
            const index = this.jobs.indexOf(
              this.jobs.find((jb) => jb.id == this.jobEdit)
            );
            this.jobs.splice(index, 1);
            $("#job").modal("hide");
            this.clear();
            this.$toast.success("نجاح");
          })
          .catch((err) => {
            console.error(err);
            this.rem.disabled = false;
            this.rem.loading = false;
            this.$toast.error("آسف! العمل: فشل");
          });
      }
    },
  },
  created() {
    this.getJobs();
  },
};
</script>

<style>
</style>