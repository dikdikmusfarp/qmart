<template>
    <div class="row">
      <div class="col-xl-12">
        <form @submit.prevent="submitForm" @reset="onReset" class="form-horizontal" role="form"
          enctype="multipart/form-data">
          <div class="row">
            <div class="col-xl-6 mt-2">
              <label class="required">Jenis Barang</label> :
              <div>
                <input id="rounded" autocomplete="off" :style="{ color: 'black' }" v-model="form.name" type="text" class="form-control" name="name"
                  :class="{ 'is-invalid': $v.form.name.$error }" placeholder="Masukkan jenis barang" />
                <div v-if="$v.form.name.$error" class="invalid-feedback">
                  <span v-if="!$v.form.name.required">Jenis barang harus diisi.</span>
                </div>
              </div>
            </div>
          </div>
          <div class=" ow text-center pt-4 pb-4">
              <b-button variant="primary" class="w-md" type="submit"><i class="uil uil-save mx-1"></i>Simpan</b-button>
            </div>
        </form>
      </div>
    </div>
  </template>
  
  <script>
  import { required } from "vuelidate/lib/validators";
  
  export default {
    components: {
    },
    props: {
      items: {
        type: Object,
        default: () => {
          return {}
        },
      },
    },
    data() {
      return {
        form: {
          name: this.items.name,
        },
      };
    },
    validations: {
      form: {
        name: {
          required
        },
      }
    },
    watch: {
      items: {
        handler: function (val) {
          if (val) {
            this.form.name = val.name
          }
        },
        deep: true,
        immediate: true,
      },
    },
    methods: {
      submitForm() {
        this.$v.$touch()
        if (!this.$v.$invalid) {
          this.submit = true;
          this.$emit('input', this.form)
        }
      },
      onReset(event) {
        event.preventDefault();
        // Reset our form values
        this.form.name = null
        this.$v.$reset();
      },
    },
    mounted() {
      // this.getListJabatan();
    },
  };
  </script>
  
  <style scoped>
  
  #rounded {
    border-radius: 10px;
  }
  
  .rounded {
    border-radius: 10px;
  }
  
  .required:after {
    content: " *";
    color: red;
  }
  </style>
  