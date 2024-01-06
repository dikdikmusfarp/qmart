<template>
    <div class="row">
        <div class="col-xl-12">
            <form @submit.prevent="submitForm" @reset="onReset" class="form-horizontal" role="form"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-6 mt-2">
                        <label class="required">Nama Barang</label> :
                        <div>
                            <input id="rounded" autocomplete="off" :style="{ color: 'black' }" v-model="form.name"
                                type="text" class="form-control" name="name" :class="{ 'is-invalid': $v.form.name.$error }"
                                placeholder="Masukkan nama barang" />
                            <div v-if="$v.form.name.$error" class="invalid-feedback">
                                <span v-if="!$v.form.name.required">Nama barang harus diisi.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 mt-2">
                        <label class="required">Harga</label> :
                        <div>
                            <input id="rounded" autocomplete="off" :style="{ color: 'black' }" v-model="form.price"
                                type="text" class="form-control" name="price"
                                :class="{ 'is-invalid': $v.form.price.$error }" placeholder="Masukkan harga barang" />
                            <div v-if="$v.form.price.$error" class="invalid-feedback">
                                <span v-if="!$v.form.price.required">Harga barang harus diisi.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 mt-2">
                        <label class="required">Jenis Barang</label> :
                        <b-form-group id="input-group-1" label-for="input-provinsi">
                            <multiselect v-model="form.type_id"
                                :options="jenis.map((type) => type.id)" placeholder="Pilih jenis barang" :custom-label="(opt) =>
                                    jenis.find((x) => x.id == opt)
                                        ? jenis.find((x) => x.id == opt).name
                                        : null
                                    ">
                            </multiselect>
                            <div v-if="$v.form.type_id.$error" class="invalid-feedback">
                                <span v-if="!$v.form.type_id.required">Jenis kelamin harus diisi</span>
                            </div>
                        </b-form-group>
                    </div>
                </div>
                <div class="row text-center pt-4 pb-4">
                    <b-button variant="primary" class="w-md" type="submit"><i
                            class="uil uil-save mx-1"></i>Simpan</b-button>
                </div>
            </form>
        </div>
    </div>
</template>
  
<script>
import { required } from "vuelidate/lib/validators";
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

export default {
    components: {
        Multiselect
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
                price: this.items.price,
                type_id: this.items.type_id,
            },
            jenis: []
        };
    },
    validations: {
        form: {
            name: {
                required
            },
            price: {
                required
            },
            type_id: {
                required
            },
        }
    },
    watch: {
        items: {
            handler: function (val) {
                if (val) {
                    this.form.name = val.name
                    this.form.price = val.price
                    this.form.type_id = val.type_id
                }
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        async getListJenis() {
            this.$store.dispatch("type/getListType", { })
                .then((resp) => {
                    this.jenis = resp.data
                })
                .catch((error) => {
                });
        },
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
            this.form.price = null
            this.form.type_id = null
            this.$v.$reset();
        },
    },
    async created() {
        await this.getListJenis();
    },
    mounted() {
        this.getListJenis();
    }
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
  