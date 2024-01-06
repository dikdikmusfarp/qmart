<template>
    <div class="row">
        <div class="col-xl-12">
            <form @submit.prevent="submitForm" @reset="onReset" class="form-horizontal" role="form"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-6 mt-2">
                        <label class="required">Jumlah Stok</label> :
                        <div>
                            <input id="rounded" autocomplete="off" :style="{ color: 'black' }" v-model="form.stock"
                                type="text" class="form-control" name="stock"
                                :class="{ 'is-invalid': $v.form.stock.$error }" placeholder="Masukkan jumlah stok" />
                            <div v-if="$v.form.stock.$error" class="invalid-feedback">
                                <span v-if="!$v.form.stock.required">Jumlah stok harus diisi.</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 mt-2">
                        <label class="required">Nama Barang</label> :
                        <b-form-group id="input-group-1" label-for="input-provinsi">
                            <multiselect v-model="form.item_id"
                                :options="barang.map((type) => type.id)" placeholder="Pilih Nama Barang" :custom-label="(opt) =>
                                    barang.find((x) => x.id == opt)
                                        ? barang.find((x) => x.id == opt).name
                                        : null
                                    ">
                            </multiselect>
                            <div v-if="$v.form.item_id.$error" class="invalid-feedback">
                                <span v-if="!$v.form.item_id.required">Nama barang harus diisi</span>
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
                item_id: this.items.item_id,
                stock: this.items.stock,
            },
            waktu: [],
            barang: [],
        };
    },
    validations: {
        form: {
            stock: {
                required
            },
            item_id: {
                required
            },
        }
    },
    watch: {
        items: {
            handler: function (val) {
                if (val) {
                    this.form.stock = val.stock
                    this.form.item_id = val.item_id
                }
            },
            deep: true,
            immediate: true,
        },
    },
    methods: {
        async getListItem() {
            this.$store.dispatch("item/getListItem", { })
                .then((resp) => {
                    this.barang = resp.data
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
            this.form.stock = null
            this.form.item_id = null
            this.$v.$reset();
        },
    },
    async created() {
        await this.getListItem();
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
  