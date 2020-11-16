<template>
  <div>
    <div class="row">
      <div class="col-md-12">
        <p>لقد بحثت عن "{{ query }}"</p>
      </div>
    </div>
    <div class="row" v-if="loading">
      <i class="fa fa-refresh fa-spin" style="font-size: 24px"></i>
      <span class="mx-2"> جاري البحث</span>
    </div>
    <div class="row" v-else-if="students && students.length > 0">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">نتائج البحث</h3>
            <div class="card-tools"></div>
          </div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>اسم</th>
                  <th>دفعة</th>
                  <th>رقم الهاتف</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(student, i) in students" :key="student.id">
                  <td>{{ i + 1 }}</td>
                  <td class="student-info">
                    <img
                      :src="student.profile"
                      height="60"
                      class="img-circle"
                      alt=""
                    />
                    <span class="mx-3">{{ student.name }}</span>
                  </td>
                  <td>{{ student.batch }}</td>
                  <td>{{ student.phone }}</td>
                  <td>
                    <button
                      @click="view(student.id)"
                      class="btn btn-sm btn-primary"
                    >
                      عرض
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="row" v-else>
      <div class="col-md-12">
        <p>لاتوجد بيانات!</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SearchStudents",
  props: ["query"],
  data() {
    return {
      loading: true,
      students: [],
    };
  },
  methods: {
    search() {
      if (this.query) {
        this.loading = true;

        axios
          .post(
            `/api/students/search/${this.query}?api_token=${window.api_token}`
          )
          .then((resp) => {
            this.loading = false;
            this.students = resp.data.data;
          })
          .catch((err) => {
            this.loading = false;
            this.$toast.error("آسف، فقد فشل العمل");
          });
      }
    },
    view(id) {
      if (id) {
        this.$router.push(`/students/view/${id}`);
      }
    },
  },
  created() {
    this.search();
  },
};
</script>

<style>
</style>