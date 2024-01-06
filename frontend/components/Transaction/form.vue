<template>
    <div class="row">
        <div class="col-xl-12">
            <form @submit.prevent="submitForm" @reset="onReset" class="form-horizontal" role="form"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-xl-6 mt-2">
                        <div>
                            <label for="example-datepicker">Choose a date</label>
                            <b-form-datepicker id="example-datepicker" v-model="form.transaction_time" class="mb-2" :style="{ color: 'black' }"></b-form-datepicker>
                        </div>
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
                transaction_time: this.items.transaction_time,
            },
            jenis: []
        };
    },
    validations: {
        form: {
            transaction_time: {
                required
            },
        }
    },
    watch: {
        items: {
            handler: function (val) {
                if (val) {
                    this.form.transaction_time = val.transaction_time
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
            this.form.transaction_time = null
            this.$v.$reset();
        },
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
  