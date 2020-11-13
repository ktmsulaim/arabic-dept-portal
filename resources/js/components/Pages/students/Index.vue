<template>
  <div class="row">
    <div class="col-md-4" v-if="batches">
      <div class="form-group">
        <select
          v-model="currentBatch"
          @change="getStudents(currentBatch)"
          class="custom-select"
          id="batch_id"
        >
          <option value="">اختر دفعة</option>
          <option
            v-for="(batch, i) in batches"
            :key="batch.id"
            :selected="i == 0 ? 'true' : 'false'"
            :value="batch.id"
          >
            {{ batch.name }}
          </option>
        </select>
      </div>
    </div>
    <div class="col-md-12">
      <div class="row" v-if="students && students.length > 0">
        <div class="col-md-3" v-for="student in students" :key="student.id">
          <div class="card text-center">
            <div class="card-body">
              <div class="image">
                <img
                  :src="student.profile"
                  width="150"
                  class="img-circle"
                  :alt="student.name"
                />
              </div>
              <h3 class="card-title mt-3">
                {{ trimString(student.name, 12) }}
              </h3>
              <p class="text-muted m-0">
                <small>{{ student.phone }}</small>
              </p>
            </div>
            <div class="card-footer">
              <button @click="view(student.id)" class="btn btn-sm btn-primary">
                عرض
              </button>
              <button @click="edit(student.id)" class="btn btn-sm btn-info">
                تعديل
              </button>
              <button
                @click="confirm_delete(student.id)"
                class="btn btn-sm btn-danger"
              >
                حذف
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="row" v-else-if="!currentBatch">
        <div class="col-md-12">الرجاء تحديد دفعة لسرد الباحثين</div>
      </div>
      <div class="row" v-else>
        <div class="col-md-12">لايوجد بيانات</div>
      </div>
    </div>

    <!-- Delete confirm -->
    <div
      class="modal fade"
      id="delete_confirm"
      tabindex="-1"
      role="dialog"
      aria-labelledby="delete_confirm-label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="delete_confirmTitle">حذف الباحث</h5>
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
            <p>هل انت متاكد من ذلك؟ لا يمكن التراجع عنه</p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-dismiss="modal"
            >
              أغلق
            </button>
            <button
              type="button"
              @click="deleteStudent"
              class="btn btn-primary mx-2"
            >
              حفظ التغييرات
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "StudentsIndex",
  data() {
    return {
      currentBatch: null,
      batches: [],
      students: [],
      delete: {
        selected: null,
        loading: false,
      },
    };
  },
  methods: {
    getBatches() {
      axios
        .get("/api/batches?api_token=" + window.api_token)
        .then((resp) => {
          this.batches = resp.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    getStudents(batch_id) {
      if (batch_id) {
        axios
          .get(
            `/api/batches/${batch_id}/students?api_token=${window.api_token}`
          )
          .then((resp) => {
            this.students = resp.data.data;
          })
          .catch((error) => {
            console.log(errro);
          });
      } else {
        this.students = [];
      }
    },
    confirm_delete(id) {
      if (id) {
        this.delete.selected = id;
        $("#delete_confirm").modal("show");
      }
    },
    deleteStudent() {
      if (this.delete.selected) {
        axios
          .delete(
            `/api/students/${this.delete.selected}?api_token=${window.api_token}`
          )
          .then((resp) => {
            this.getStudents(this.currentBatch);
            $("#delete_confirm").modal("hide");
          })
          .catch((error) => {
            console.log(error);
          });
      }
    },
    trimString(str, length) {
      if (str) {
        if (str.length <= length) {
          return str;
        } else {
          return str.substring(0, length) + "...";
        }
      }
    },

    view(student_id) {
      if (student_id) {
        this.$router.push(`/students/view/${student_id}`);
      }
    },
    edit(student_id) {
      this.$router.push(`/students/edit/${student_id}`);
    },
  },
  created() {
    this.getBatches();

    if (this.currentBatch) {
      this.getStudents(this.currentBatch);
    }
  },
};
</script>

<style>
</style>