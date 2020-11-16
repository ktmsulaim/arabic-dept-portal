<template>
  <div class="home">
    <div class="row">
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"
            ><i class="fa fa-tasks"></i
          ></span>

          <div class="info-box-content">
            <span class="info-box-text">دفعات</span>
            <span class="info-box-number" v-text="batches"></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"
            ><i class="fa fa-users"></i
          ></span>

          <div class="info-box-content">
            <span class="info-box-text">مجموع الباحثين</span>
            <span class="info-box-number" v-text="total_students"></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->

      <!-- fix for small devices only -->
      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"
            ><i class="fa fa-child"></i
          ></span>

          <div class="info-box-content">
            <span class="info-box-text">الباحثون</span>
            <span class="info-box-number" v-text="students"></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"
            ><i class="fa fa-graduation-cap"></i
          ></span>

          <div class="info-box-content">
            <span class="info-box-text">المتخرجون</span>
            <span class="info-box-number" v-text="graduated"></span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <!-- /.col -->
    </div>
    <div class="row" v-if="batch_stat && batch_stat.length > 0">
      <div v-for="(batch, i) in batch_stat" :key="i" class="col-md-4">
        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <h3 class="profile-username text-center">{{ batch.name }}</h3>

            <p class="text-muted text-center">
              {{ batch.start }} - {{ batch.end }}
            </p>

            <ul class="list-group list-group-unbordered mb-3">
              <li class="list-group-item">
                <b>الباحثون</b>
                <a class="float-left"
                  >{{ batch.studying }}
                  <span class="badge badge-primary"
                    >{{ batch.studying_perc }}%</span
                  ></a
                >
              </li>
              <li class="list-group-item">
                <b>المتخرجون</b>
                <a class="float-left"
                  >{{ batch.graduated }}
                  <span class="badge badge-success"
                    >{{ batch.graduated_perc }}%</span
                  ></a
                >
              </li>
              <li class="list-group-item">
                <b>ترك الدراسة</b>
                <a class="float-left">
                  {{ batch.dropped }}
                  <span class="badge badge-danger"
                    >{{ batch.dropped_perc }}%</span
                  ></a
                >
              </li>
              <li class="list-group-item">
                <b>مجموع الباحثين</b>
                <a class="float-left">{{ batch.total_students }}</a>
              </li>
            </ul>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Dashboard",
  data() {
    return {
      batches: 0,
      total_students: 0,
      students: 0,
      graduated: 0,
      batch_stat: [],
    };
  },
  methods: {
    getCounts() {
      axios
        .get(`/api/home/counts?api_token=${window.api_token}`)
        .then((resp) => {
          const data = resp.data;
          this.batches = data.batches;
          this.total_students = data.total_students;
          this.students = data.students;
          this.graduated = data.graduated;
        })
        .catch((err) => {
          this.$toast.error("آسف، فقد فشل العمل");
        });
    },
    getBathCounts() {
      axios
        .get(`/api/home/counts/batches?api_token=${window.api_token}`)
        .then((resp) => {
          this.batch_stat = resp.data;
        })
        .catch((err) => {
          this.$toast.error("آسف، فقد فشل العمل");
        });
    },
  },
  created() {
    this.getCounts();
    this.getBathCounts();
  },
};
</script>

<style>
</style>