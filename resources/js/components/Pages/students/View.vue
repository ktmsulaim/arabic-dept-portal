<template>
  <div class="" v-if="loading">
    <i class="fa fa-spin fa-spinner"></i> جار التحميل
  </div>
  <div v-else-if="student">
    <div class="row" id="student-view">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="image">
              <img
                :src="student.profile"
                width="150"
                class="img-circle"
                :alt="student.name"
              />
            </div>
            <div class="name">
              <h5>{{ student.name }}</h5>
            </div>
            <div class="contact-details">
              <div class="phone">
                <i class="fa fa-phone fa-fw"></i>
                <span>{{ student.phone }}</span>
              </div>
              <div class="email">
                <i class="fa fa-envelope fa-fw"></i>
                <span>{{ student.email }}</span>
              </div>
            </div>
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-6">
                <button class="btn btn-block btn-primary">تعديل</button>
              </div>
              <div class="col-6">
                <button class="btn btn-block btn-danger">حذف</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
              <li class="nav-item">
                <a
                  class="nav-link active"
                  id="personal-tab"
                  data-toggle="tab"
                  href="#personal"
                  role="tab"
                  aria-controls="personal"
                  aria-selected="true"
                >
                  شخصي
                </a>
              </li>
              <li class="nav-item">
                <a
                  class="nav-link"
                  id="academic-tab"
                  data-toggle="tab"
                  href="#academic"
                  role="tab"
                  aria-controls="academic"
                  aria-selected="false"
                >
                  أكاديمي
                </a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div
                class="tab-pane fade show active"
                id="personal"
                role="tabpanel"
                aria-labelledby="personal-tab"
              >
                <div class="mt-4 table-responsive">
                  <table class="table table-bordered">
                    <tr>
                      <th width="150px">تاريخ الولادة</th>
                      <td>{{ student.dob }}</td>
                    </tr>
                    <tr>
                      <th width="150px">العنوان</th>
                      <td>{{ student.address }}</td>
                    </tr>
                  </table>
                </div>
              </div>
              <div
                class="tab-pane fade"
                id="academic"
                role="tabpanel"
                aria-labelledby="academic-tab"
              >
                <div class="mt-4 table-responsive">
                  <table class="table table-bordered">
                    <tr>
                      <th width="150px">الدفعة</th>
                      <td>{{ student.batch }}</td>
                      <th width="150px">الحالة</th>
                      <td>
                        <span
                          class="badge badge-danger"
                          v-if="student.status == 0"
                          >ترك الدراسة</span
                        >
                        <span
                          class="badge badge-info"
                          v-else-if="student.status == 1"
                          >باحث</span
                        >
                        <span
                          class="badge badge-success"
                          v-else-if="student.status == 2"
                          >تخرج</span
                        >
                      </td>
                    </tr>
                    <tr>
                      <th width="150px">رقم الإلتحاق</th>
                      <td>{{ student.enroll_no }}</td>
                      <th width="150px">رقم الامتحان</th>
                      <td>{{ student.exam_no }}</td>
                    </tr>
                    <tr>
                      <th width="150px">سنة الإلتحاق</th>
                      <td>{{ student.enrolled_year }}</td>
                      <th width="150px">سنة التخرج</th>
                      <td>{{ student.year_of_completion }}</td>
                    </tr>
                    <tr>
                      <th width="150px">اسم الكلية الملحقة</th>
                      <td colspan="3">{{ student.ug_institute }}</td>
                    </tr>
                    <tr>
                      <th width="150px">موضوع الرسالة</th>
                      <td colspan="3">{{ student.thesis_subject }}</td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <Photos />
      </div>
      <div class="col-md-6">
        <Jobs :student_id="student.id" />
      </div>
    </div>
  </div>
  <div v-else class="row">
    <div class="col-md-12">
      <p>No student found!</p>
    </div>
  </div>
</template>

<script>
import Photos from "./Photos";
import Jobs from "./Jobs";

export default {
  name: "StudentView",
  components: {
    Photos,
    Jobs,
  },
  data() {
    return {
      loading: true,
      student: null,
    };
  },
  methods: {
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
          });
      } else {
        this.$router.push("/students");
      }
    },
  },
  created() {
    this.getStudent(this.$route.params.id);
  },
};
</script>

<style>
</style>