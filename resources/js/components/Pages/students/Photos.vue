<template>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">الصور</h3>
      <div class="card-tools">
        <span class="btn btn-tool" @click="photoAdd"
          ><i class="fa fa-fw fa-plus"></i> اضف جديد</span
        >
      </div>
      <div class="card-body">
        <div v-if="loading">
          <i class="fa fa-spin fa-spinner"></i> جار التحميل
        </div>
        <div v-else-if="photos && photos.length > 0">
          <div class="row" id="student-photos">
            <div v-for="photo in photos" :key="photo.id" class="col-md-4">
              <div class="image">
                <img :src="photo.path" class="img-fluid" />
                <div class="info">
                  <div class="date small">
                    <i class="fa fa-calendar fa-fw"></i>
                    <span class="mx-2">{{ photo.date }}</span>
                  </div>
                  <div class="time small">
                    <i class="fa fa-clock-o fa-fw"></i>
                    <span class="mx-2">{{ photo.time }}</span>
                  </div>
                  <div class="text-center mt-3">
                    <button
                      type="button"
                      class="btn btn-sm btn-block btn-primary"
                      @click="viewPhoto(photo.id)"
                    >
                      عرض
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <p class="text-muted">لم يتم إضافة أي وظيفة</p>
        </div>
      </div>
    </div>

    <!-- View modal -->
    <div
      v-if="view.photo"
      ref="view"
      class="modal fade"
      id="viewPhotos"
      tabindex="-1"
      role="dialog"
      aria-labelledby="viewPhotos-label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
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
            <div class="image text-center">
              <img
                :src="view.photo.path"
                :alt="view.photo.filename"
                class="img-fluid"
              />
            </div>
            <div class="photo-info mt-3">
              <div class="date">
                <i class="fa fa-calendar fa-fw"></i>
                <span class="mx-2">{{ view.photo.date }}</span>
              </div>
              <div class="time">
                <i class="fa fa-clock-o fa-fw"></i>
                <span class="mx-2">{{ view.photo.time }}</span>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-between">
            <button
              @click="deletePhoto"
              :disabled="deleteBtn.disabled"
              class="btn btn-danger"
            >
              <span v-if="deleteBtn.loading">جار الحذف</span>
              <span v-else> حذف </span>
            </button>
            <div>
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                أغلق
              </button>
              <button
                v-if="view.photo.status == 0"
                :disabled="profile.disabled"
                type="button"
                class="btn btn-primary"
                @click="makeProfile"
              >
                <span v-if="profile.loading">جاري الحفظ</span>
                <span v-else>جعل الصورة الشخصية</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add modal -->
    <div
      class="modal fade"
      id="addPhoto"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addPhoto-label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addPhotoTitle">أضف صورة جديدة</h5>
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
            <div class="row">
              <div class="col-md-6">
                <vue-cropper
                  v-if="add.image"
                  ref="cropper"
                  :src="add.image"
                  :aspect-ratio="1 / 1"
                  @crop="showCropped"
                  alt="Image to crop"
                >
                </vue-cropper>
                <span v-else> لم يتم اختيار ملف </span>
              </div>
              <div class="col-md-6">
                <div>معاينة:</div>
                <div v-if="add.preview" class="text-center">
                  <img :src="add.preview" class="img-fluid" />
                </div>
              </div>
            </div>
            <hr />
            <div class="row mt-3">
              <div class="col-12">
                <!-- <p class="card-text">الرجاء اختيار ملف للتحميل</p> -->
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
                <div class="form-group">
                  <div class="form-check">
                    <input
                      type="checkbox"
                      v-model="add.profile"
                      class="form-check-input"
                      id="makeProfile"
                    />
                    <label class="form-check-label" for="makeProfile"
                      >الصوره الشخصيه</label
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary mx-2"
              data-dismiss="modal"
            >
              أغلق
            </button>
            <button
              :disabled="add.disabled"
              type="button"
              class="btn btn-primary"
              @click="save"
            >
              <span v-if="add.loading">جاري الحفظ</span>
              <span v-else>حفظ التغييرات</span>
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueCropper from "vue-cropperjs";
import "cropperjs/dist/cropper.css";

export default {
  name: "StudentPhotos",
  props: ["student_id"],
  components: {
    VueCropper,
  },
  data() {
    return {
      modal: false,
      loading: true,
      photos: [],
      image: null,
      cropped: null,
      view: {
        modal: false,
        photo: null,
      },
      deleteBtn: {
        loading: false,
        disabled: false,
      },
      add: {
        image: null,
        cropped: null,
        preview: null,
        profile: null,
        loading: false,
        disabled: false,
      },
      profile: {
        loading: false,
        disabled: false,
      },
    };
  },
  methods: {
    getPhotos() {
      this.loading = true;
      if (this.student_id) {
        axios
          .get(
            `/api/students/${this.student_id}/photos?api_token=${window.api_token}`
          )
          .then((resp) => {
            this.photos = resp.data.data;
            this.loading = false;
          })
          .catch((err) => {
            this.photos = [];
            this.loading = false;
          });
      }
    },
    viewPhoto(id) {
      if (id) {
        this.view.photo = this.photos.find((ph) => ph.id == id);
        $("#viewPhotos").modal("show");
      }
    },
    clear() {
      this.view.modal = false;
      this.view.photo = null;
      $("#viewPhotos").modal("hide");
    },
    clearAdd() {
      this.add = {
        image: null,
        cropped: null,
        preview: null,
        profile: null,
        loading: false,
        disabled: false,
      };
    },
    deletePhoto() {
      if (this.view.photo.id) {
        this.deleteBtn.loading = true;
        this.deleteBtn.disabled = true;
        axios
          .delete(
            `/api/photos/${this.view.photo.id}?api_token=${window.api_token}`
          )
          .then((resp) => {
            this.deleteBtn.loading = false;
            this.deleteBtn.disabled = false;
            this.clear();
            this.$toast.success("نجاح");

            // Update photos array
            const index = this.photos.indexOf(this.view.photo);
            this.photos.splice(index, 1);
            // Update student info
            this.$emit("updateProfile", resp.data.data.profile);
          })
          .catch((err) => {
            this.deleteBtn.loading = false;
            this.deleteBtn.disabled = false;
            console.error(err);
            this.$toast.error("آسف! العمل: فشل");
          });
      }
    },
    photoAdd() {
      this.clearAdd();
      $("#addPhoto").modal("show");
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
          this.add.image = event.target.result;
          // rebuild cropperjs with the updated source
          this.$refs.cropper.replace(this.add.image);
        };
        reader.readAsDataURL(file);
      } else {
        this.$toast.error("آسف، فقد فشل العمل");
      }
    },
    showCropped() {
      this.add.preview = this.$refs.cropper.getCroppedCanvas().toDataURL();
      this.add.cropped = this.$refs.cropper.getCroppedCanvas().toDataURL();
    },
    save() {
      if (this.add.cropped) {
        this.add.loading = true;
        this.add.disabled = true;

        const data = {
          filename: this.add.cropped,
          student_id: this.student_id,
          status: this.add.profile ? 1 : 0,
        };

        axios
          .post(`/api/photos?api_token=${window.api_token}`, data)
          .then((resp) => {
            this.add.loading = false;
            this.add.disabled = false;
            this.$emit("updateProfile", resp.data.data.path);
            this.photos.push(resp.data.data);
            $("#addPhoto").modal("hide");
            this.$toast.success("نجاح");
          })
          .catch((err) => {
            this.add.loading = false;
            this.add.disabled = false;
            this.$toast.error("آسف، فقد فشل العمل");
          });
      }
    },
    makeProfile() {
      if (this.view.photo) {
        this.profile.loading = true;
        this.profile.disabled = true;

        axios
          .post(
            `/api/photos/${this.view.photo.id}/makeProfile?api_token=${window.api_token}`
          )
          .then((resp) => {
            const photo = this.photos.find((ph) => ph.id == this.view.photo.id);
            const index = this.photos.indexOf(photo);
            const newPhoto = resp.data.data;
            this.photos.splice(index, 1, newPhoto);

            this.$emit("updateProfile", newPhoto.path);

            this.profile.loading = false;
            this.profile.disabled = false;

            this.clearProfilePic(newPhoto.id);

            this.clear();
            this.$toast.success("نجاح");
          })
          .catch((err) => {
            console.error(err);
            this.profile.loading = false;
            this.profile.disabled = false;
            this.$toast.error("آسف، فقد فشل العمل");
          });
      }
    },
    clearProfilePic(exceptID) {
      if (this.photos && this.photos.length > 0) {
        this.photos.forEach((photo) => {
          if (exceptID) {
            if (photo.id != exceptID) {
              photo.status = 0;
            }
          } else {
            photo.status = 0;
          }
        });
      }
    },
  },
  created() {
    this.getPhotos();
  },
};
</script>

<style>
</style>