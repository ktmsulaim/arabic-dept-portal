<template>
  <div>
    <div v-if="loading" class="row">
      <div class="col-12">
        <i class="fa fa-spin fa-spinner"></i> جار التحميل
      </div>
    </div>
    <div v-else-if="student" class="row">
      <div class="col-md-8">
        <div class="card card-primary card-outline">
          <ValidationObserver v-slot="{ invalid }">
            <form ref="form" id="create-student" @submit.prevent="save">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fa fa-fw fa-edit"></i>
                  تعديل الباحث
                </h3>
              </div>
              <div class="card-body">
                <ul
                  class="nav nav-tabs"
                  id="custom-content-below-tab"
                  role="tablist"
                >
                  <li class="nav-item">
                    <a
                      class="nav-link active"
                      id="custom-content-below-home-tab"
                      data-toggle="pill"
                      href="#custom-content-below-home"
                      role="tab"
                      aria-controls="custom-content-below-home"
                      aria-selected="false"
                      >شخصي</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      id="custom-content-below-profile-tab"
                      data-toggle="pill"
                      href="#custom-content-below-profile"
                      role="tab"
                      aria-controls="custom-content-below-profile"
                      aria-selected="false"
                      >أكاديمي</a
                    >
                  </li>
                </ul>
                <div class="tab-content" id="custom-content-below-tabContent">
                  <div
                    class="tab-pane fade active show"
                    id="custom-content-below-home"
                    role="tabpanel"
                    aria-labelledby="custom-content-below-home-tab"
                  >
                    <div class="form-group mt-4">
                      <label for="name">اسم الباحث</label>
                      <ValidationProvider rules="required" v-slot="{ errors }">
                        <input
                          type="text"
                          class="form-control"
                          v-model="student.name"
                          required
                        />
                        <span class="text-danger">{{ errors[0] }}</span>
                      </ValidationProvider>
                    </div>
                    <div class="form-group">
                      <label for="email">البريد الإلكتروني</label>
                      <input
                        type="email"
                        class="form-control"
                        name="email"
                        id="email"
                        v-model="student.email"
                        required
                      />
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="phone">رقم الهاتف</label>
                          <ValidationProvider
                            rules="required"
                            v-slot="{ errors }"
                          >
                            <input
                              type="tel"
                              class="form-control"
                              name="phone"
                              id="phone"
                              v-model="student.phone"
                              required
                            />
                            <span class="text-danger">{{ errors[0] }}</span>
                          </ValidationProvider>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="dob">تاريخ الولادة</label>
                          <datepicker
                            v-model="student.dob"
                            name="start"
                            input-class="form-control"
                            :format="'dd MMM yyyy'"
                            :bootstrap-styling="true"
                          ></datepicker>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="address">العنوان</label>
                      <textarea
                        name="address"
                        id="address"
                        class="form-control"
                        v-model="student.address"
                        cols="30"
                        rows="5"
                        style="resize: none"
                        required
                      ></textarea>
                    </div>
                  </div>
                  <div
                    class="tab-pane fade"
                    id="custom-content-below-profile"
                    role="tabpanel"
                    aria-labelledby="custom-content-below-profile-tab"
                  >
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group mt-4">
                          <label for="batch_id">الدفعة</label>
                          <ValidationProvider
                            rules="required"
                            v-slot="{ errors }"
                          >
                            <select
                              name="batch_id"
                              id="batch_id"
                              class="form-control"
                              v-model="student.batch_id"
                              required
                            >
                              <option value="">حدد دفعة</option>
                              <option
                                v-for="batch in batches"
                                :key="batch.id"
                                :value="batch.id"
                              >
                                {{ batch.name }}
                              </option>
                            </select>
                            <span class="text-danger">{{ errors[0] }}</span>
                          </ValidationProvider>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group mt-4">
                          <label for="batch_id">الحالة</label>
                          <ValidationProvider
                            rules="required"
                            v-slot="{ errors }"
                          >
                            <select
                              name="status"
                              id="status"
                              class="form-control"
                              v-model="student.status"
                              required
                            >
                              <option value="">حدد الحالة</option>
                              <option value="0">ترك الدراسة</option>
                              <option value="1">باحث</option>
                              <option value="2">تخرج</option>
                            </select>
                            <span class="text-danger">{{ errors[0] }}</span>
                          </ValidationProvider>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="enroll_no">رقم الإلتحاق</label>
                          <input
                            type="text"
                            name="enroll_no"
                            v-model="student.enroll_no"
                            id="enroll_no"
                            class="form-control"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="exam_no">رقم الامتحان</label>
                          <input
                            type="text"
                            name="exam_no"
                            v-model="student.exam_no"
                            id="exam_no"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="enrolled">سنة الإلتحاق</label>
                          <input
                            type="text"
                            name="enrolled"
                            v-model="student.enrolled_year"
                            id="enrolled"
                            class="form-control"
                            required
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="completed">سنة التخرج</label>
                          <input
                            type="text"
                            name="completed"
                            v-model="student.year_of_completion"
                            id="completed"
                            class="form-control"
                          />
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="ug_institute">اسم الكلية الملحقة</label>
                      <input
                        type="text"
                        name="ug_institute"
                        class="form-control"
                        id="ug_institute"
                        v-model="student.ug_institute"
                        required
                      />
                    </div>
                    <div class="form-group">
                      <label for="thesis_subject">موضوع الرسالة</label>
                      <input
                        type="text"
                        name="thesis_subject"
                        class="form-control"
                        id="thesis_subject"
                        v-model="student.thesis_subject"
                      />
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-footer">
                <button
                  type="submit"
                  :disabled="invalid || submit.disabled"
                  class="btn btn-primary"
                >
                  <span v-if="submit.loading">
                    <i class="fa fa-spinner fa-spin"></i> جاري الحفظ
                  </span>
                  <span v-else> حفظ التغييرات </span>
                </button>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>
    <div v-else class="row">
      <div class="col-md-12">
        <p>لم يتم العثور على باحث!</p>
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
  name: "EditStudent",
  components: {
    Datepicker,
  },
  data() {
    return {
      loading: true,
      submit: {
        disabled: false,
        loading: false,
      },
      batches: null,
      student: {
        batch_id: null,
        name: null,
        address: null,
        email: null,
        phone: null,
        dob: null,
        enroll_no: null,
        exam_no: null,
        enrolled_year: null,
        year_of_completion: null,
        ug_institute: null,
        thesis_subject: null,
        status: null,
      },
    };
  },
  methods: {
    getBatches() {
      axios
        .get(`/api/batches?api_token=${window.api_token}`)
        .then((resp) => {
          this.batches = resp.data.data;
        })
        .catch((error) => {
          console.log(error);
          this.$toast.error("آسف، فقد فشل العمل");
        });
    },
    getStudent(id) {
      if (id) {
        axios
          .get(`/api/students/${id}?api_token=${window.api_token}`)
          .then((resp) => {
            this.student = resp.data.data;
            this.loading = false;
          })
          .catch((error) => {
            console.error(error);
            this.loading = false;
            this.$toast.error("آسف، فقد فشل العمل");
            this.$router.push("/students");
          });
      } else {
        this.$router.push("/students");
      }
    },
    format(date) {
      return moment(date).format("MMM DD, YYYY");
    },
    save() {
      this.submit.loading = true;
      this.submit.disabled = true;

      axios
        .put(
          `/api/students/${this.student.id}?api_token=${window.api_token}`,
          this.student
        )
        .then((resp) => {
          this.submit.loading = false;
          this.submit.disabled = false;
          this.$toast.success("تم تعديل الباحث بنجاح!");
        })
        .catch((error) => {
          // console.log(error);
          this.submit.loading = false;
          this.submit.disabled = false;
          this.$toast.error("تعذر تعديل الباحث");
        });
    },
    reset() {
      this.student = {
        batch_id: null,
        name: null,
        address: null,
        email: null,
        phone: null,
        dob: null,
        enroll_no: null,
        exam_no: null,
        enrolled_year: null,
        year_of_completion: null,
        ug_institute: null,
        thesis_subject: null,
        status: null,
      };
    },
  },
  created() {
    this.getBatches();
    this.getStudent(this.$route.params.id);
  },
};
</script>

<style>
</style>