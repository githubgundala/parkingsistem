<template>
  <div class="wrapper">
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container">
          <div class="row mb-2">
            <div class="col-sm-6"></div>
            <!-- /.col -->
            <div class="col-sm-6"></div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content mt-5">
        <div class="container">
          <div class="col-lg-12 d-flex">
            <div class="col-lg-6">
              <form @submit.prevent="submit">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Form Masuk Kendaraan</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="noPolisi">No Polisi</label>
                      <input
                        type="text"
                        class="form-control"
                        id="noPolisi"
                        v-model="form.no_pol"
                        require
                      />
                    </div>
                    <div class="form-group">
                      <label>Tipe Kendaraan</label>
                      <select
                        class="custom-select rounded-0"
                        id="exampleSelectRounded0"
                        v-model="form.type_vehicle"
                        require
                      >
                        <option value="motor">Motor</option>
                        <option value="mobil">Mobil</option>
                      </select>
                    </div>
                    <button
                      id="btnCari"
                      type="submit"
                      class="btn btn-block btn-primary"
                      :disabled="form.processing"
                    >
                      <i
                        class="fa fa-refresh fa-spin"
                        v-if="form.processing"
                      ></i>
                      <div v-else>Simpan</div>
                    </button>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>
              <!-- /.card -->
            </div>
            <div class="col-lg-6">
              <form @submit.prevent="inquery">
                <!-- general form elements -->
                <div class="card card-primary">
                  <div class="card-header">
                    <h3 class="card-title">Form Keluar Kendaraan</h3>
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <label for="noPolisi">No Polisi</label>
                      <input
                        type="text"
                        class="form-control"
                        id="noPolisi"
                        v-model="post.no_pol"
                        require
                      />
                    </div>
                    <button
                      id="btnCari"
                      type="submit"
                      class="btn btn-block btn-primary"
                      :disabled="inqueryLoading"
                    >
                      <i
                        class="fa fa-refresh fa-spin"
                        v-if="inqueryLoading"
                      ></i>
                      <div v-else>Cari</div>
                    </button>
                  </div>
                  <!-- /.card-body -->
                </div>
              </form>
              <!-- /.card -->
            </div>
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">Anything you want</div>
      <!-- Default to the left -->
      <strong
        >Copyright &copy; 2014-2021
        <a href="https://adminlte.io">AdminLTE.io</a>.</strong
      >
      All rights reserved.
    </footer>
  </div>
</template>

<script>
import { reactive } from "vue";
import { Inertia } from "@inertiajs/inertia";

export default {
  props: {
    inqueryLoading: false,
    post: Object,
  },
  //define Composition Api
  setup(props) {
    //state posts
    const post = reactive({
      no_pol: props.post.no_pol,
    });

    //function updatePost
    function inquery() {
      //define variable
      let no_pol = post.no_pol;

      //send data
      Inertia.get(`/ticket/${props.post.no_pol}`, {
        no_pol: no_pol,
      });
    }

    return {
      post,
      inquery,
    };
  },
  methods: {},
  mounted() {},
  data() {
    return {
      form: this.$inertia.form({
        no_pol: "",
        no_pol1: "",
        type_vehicle: "motor",
      }),
    };
  },

  methods: {
    submit() {
      if (this.form.no_pol) {
        this.form.post(this.route("ticket.store"), {
          onFinish: () => {
            this.form.no_pol = "";
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Berhasil disimpan!",
              showConfirmButton: false,
              timer: 1500,
            });
          },
          onError: (errors) => {
            console.log(errors);
          },
        });
      } else {
        alert("Harap isi nomor polisi!");
      }
    },
    inquery() {
      if (this.form.no_pol1) {
        this.form.get(this.route("ticket.show", this.form.no_pol1), {
          onFinish: () => {
            Swal.fire({
              position: "center",
              icon: "success",
              title: "Berhasil disimpan!",
              showConfirmButton: false,
              timer: 1500,
            });
          },
          onError: (errors) => {
            console.log(errors);
          },
        });
      } else {
        alert("Harap isi nomor polisi!");
      }
    },
  },
};
</script>

<style scoped></style>
