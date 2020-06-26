<template>
  <div class="batches">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                    <h5 class="card-title">دفعات</h5>
                    <div class="card-tools">
                        <button @click="showForm" class="btn btn-tool">جديد <i class="fa fa-plus fa-fw"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" v-if="batches">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم</th>
                                <th>بداية</th>
                                <th>نهاية</th>
                                <th>عدد الباحثين</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        </tbody>
                    </table>
                    <p class="text-muted" v-else>آسف! لاتوجد بيانات</p>
                </div>
            </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
  name: 'Batches',
  data() {
    return {
      batches: null
    }
  },
}
</script>

<style>

</style>