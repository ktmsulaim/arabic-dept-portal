<template>
  <div class="row">
    <div class="col-md-8">
      <div class="card card-primary card-outline">
        <ValidationObserver v-slot="{ invalid }">
          <form ref="form" id="create-student" @submit.prevent="doAdd">
            <div class="card-header">
              <h3 class="card-title">
                <i class="fa fa-fw fa-edit"></i>
                إضافة باحث جديد
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
                <li class="nav-item">
                  <a
                    class="nav-link"
                    id="custom-content-below-jobs-tab"
                    data-toggle="pill"
                    href="#custom-content-below-jobs"
                    role="tab"
                    aria-controls="custom-content-below-jobs"
                    aria-selected="false"
                    >تاريخ العمل</a
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
                <div
                  class="tab-pane fade"
                  id="custom-content-below-jobs"
                  role="tabpanel"
                  aria-labelledby="custom-content-below-jobs-tab"
                >
                  <div class="mt-4">
                    <span @click="jobAdd()" class="btn btn-link">
                      اضف جديد</span
                    >
                    <table
                      v-if="student.job.length > 0"
                      class="table table-bordered"
                    >
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
                        <tr v-for="(jb, i) in student.job" :key="i">
                          <td>{{ i + 1 }}</td>
                          <td>{{ jb.name }}</td>
                          <td>{{ jb.place }}</td>
                          <td>{{ jb.start_date }}</td>
                          <td>{{ jb.end_date }}</td>
                          <td>{{ jb.status == 1 ? "عامل" : "غير عامل" }}</td>
                          <td>
                            <span class="btn btn-sm btn-info"
                              ><i
                                @click="jobAdd(i.toString())"
                                class="fa fa-edit fa-fw"
                              ></i
                            ></span>
                            <span class="btn btn-sm btn-danger"
                              ><i
                                @click="jobDelete(i.toString())"
                                class="fa fa-trash fa-fw"
                              ></i
                            ></span>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <p class="text-muted" v-else>لم يتم إضافة أي وظيفة</p>
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
                  <i class="fa fa-spinner fa-spin"></i> Saving
                </span>
                <span v-else> حفظ التغييرات </span>
              </button>
              <button
                type="button"
                class="btn btn-secondary mx-2"
                @click="reset"
              >
                Reset
              </button>
            </div>
          </form>
        </ValidationObserver>
        <!-- /.card -->
      </div>
    </div>
    <div class="col-md-4">
      <div class="card" style="width: 18rem">
        <div class="card-body">
          <h5 class="card-title">صورة الملف الشخصي</h5>
          <div class="text-center mt-3 mb-3" id="user-image">
            <img
              :src="image.cropped ? image.cropped : '/img/user.png'"
              class="img-circle"
              width="150"
              alt="User"
            />

            <div class="crop-icon" v-if="image.cropped" @click="recrop">
              <i class="fa fa-crop fa-fw"></i>
            </div>
          </div>
          <p class="card-text">الرجاء اختيار ملف للتحميل</p>
          <div class="form-group">
            <div class="custom-file">
              <input
                type="file"
                value="تصفح"
                class="custom-file-input"
                id="customFile"
                @change="setImage"
              />
              <label class="custom-file-label" for="customFile"
                >اختيار ملف</label
              >
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Job Add / Edit modal -->
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
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-default"
                  data-dismiss="modal"
                  @click="clear"
                >
                  أغلق
                </button>
                <button
                  :disabled="invalidJob"
                  type="submit"
                  class="btn btn-primary mr-2"
                >
                  <span v-if="submit.loading">
                    <i class="fa fa-spinner fa-spin"></i> Saving
                  </span>
                  <span v-else> حفظ التغييرات </span>
                </button>
              </div>
            </form>
          </ValidationObserver>
        </div>
      </div>
    </div>

    <!-- Crop image modal -->
    <div
      class="modal fade"
      id="crop"
      tabindex="-1"
      role="dialog"
      aria-labelledby="crop-label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="cropTitle">قص الصوره</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!--Modal content-->
            <vue-cropper
              ref="cropper"
              :src="image.original"
              :aspect-ratio="1 / 1"
              alt="Image to crop"
            >
            </vue-cropper>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              أغلق
            </button>
            <button type="button" @click="crop" class="btn btn-primary mx-2">
              حفظ التغييرات
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Datepicker from "vuejs-datepicker";
import { extend } from "vee-validate";
import { required } from "vee-validate/dist/rules";
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";

extend("required", {
  ...required,
  message: "هذه البيانات مطلوبة",
});

export default {
  name: "StudentAdd",
  components: {
    Datepicker,
    VueCropper,
  },
  data() {
    return {
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
        filename: null,
        job: [],
      },
      job: {
        name: null,
        place: null,
        start_date: null,
        end_date: null,
        status: null,
      },
      jobEdit: false,
      image: {
        original: null,
        cropped: null,
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
        });
    },
    format(date) {
      return moment(date).format("YYYY");
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
        filename: null,
        job: [],
      };

      this.job = {
        name: null,
        place: null,
        start_date: null,
        end_date: null,
        status: null,
      };

      this.image = {
        original: null,
        cropped: null,
      };
    },
    jobAdd(id = null) {
      if (id) {
        this.job = this.student.job[id];
        this.jobEdit = id;
      }

      $("#job").modal("show");
    },
    addToJobList(id = null) {
      if (this.job) {
        if (this.jobEdit) {
          this.student.job[this.jobEdit] = this.job;
        } else {
          this.student.job.push({
            name: this.job.name,
            place: this.job.place,
            start_date: this.job.start_date,
            end_date: this.job.end_date,
            status: this.job.status,
          });
        }
      }
      this.clear();
      $("#job").modal("hide");
      this.$toast.success("نجاح");
    },
    jobDelete(index) {
      this.student.job.splice(index, 1);
      this.$toast.success("نجاح");
    },
    setImage(e) {
      const file = e.target.files[0];
      if (file.type.indexOf("image/") === -1) {
        alert("الرجاء تحديد ملف صورة");
        return;
      }
      if (typeof FileReader === "function") {
        const reader = new FileReader();
        reader.onload = (event) => {
          this.image.original = event.target.result;
          // rebuild cropperjs with the updated source
          this.$refs.cropper.replace(this.image.original);
        };
        reader.readAsDataURL(file);
        $("#crop").modal("show");
      } else {
        this.$toast.error("آسف ، فقد فشل العمل");
      }
    },
    crop() {
      this.image.cropped = this.$refs.cropper.getCroppedCanvas().toDataURL();
      $("#crop").modal("hide");
    },
    recrop() {
      $("#crop").modal("show");
    },
    doAdd() {
      this.submit.loading = true;
      this.submit.disabled = true;
      // alert("Form submitted!");
      if (this.image.cropped) {
        this.student.image = this.image.cropped;
      }

      axios
        .post(`/api/students?api_token=${window.api_token}`, this.student)
        .then((resp) => {
          this.reset();
          this.submit.loading = false;
          this.submit.disabled = false;
          this.$toast.success("تمت إضافة الباحث بنجاح!");
        })
        .catch((error) => {
          // console.log(error);
          this.submit.loading = false;
          this.submit.disabled = false;
          this.$toast.error("تعذر إضافة الباحث");
        });
    },
    format(date) {
      if (date) {
        return moment(date).format("MMM DD, YYYY");
      } else {
        return null;
      }
    },
    formatDate(model) {
      if (model) {
        this.model = moment(this.model).format("MMM DD, YYYY");
      }
    },
  },
  created() {
    this.getBatches();
  },
};
</script>

<style>
</style>