<template>
    <div class="row">
        <div class="col-lg-3">
            <b-button v-on:click="buatData()" size="xl">
                <i class="tim-icons icon-simple-add"></i>
            </b-button>
        </div>
        <div class="col-lg-12">
            <card card-body-classes="table-full-width">
                <div class="row">
                    <div class="col-lg-4">
                        <input id="rounded" autocomplete="off" @input="debounceSearch" v-model="table.search" type="search"
                            class="form-control" name="name" placeholder="Cari jenis barang" />
                    </div>
                </div>
                <b-table responsive="sm" class="myTablePTK" :fields="table.fields" :items="table.items"
                    :current-page="table.currentPage" :busy.sync="table.loading" :sort-by.sync="table.sortBy"
                    :sort-desc.sync="table.sortDesc" empty-filtered-text="Data jenis barang tidak ditemukan"
                    empty-text="Tidak ada data jenis barang" :show-empty="true">
                    <template v-slot:cell(nomor)="{ index }">
                        {{ (index + 1 + number) }}
                    </template>
                    <template v-slot:cell(actions)="{ item }">
                        <b-button v-on:click="perbaharui(item.id)" size="sm" style="margin-top: 0.2rem;">
                            <i class="tim-icons icon-pencil"></i>
                        </b-button>
                        <b-button v-on:click="deleteType(item.id)" size="sm" style="margin-top: 0.2rem;">
                            <i class="tim-icons icon-trash-simple"></i>
                        </b-button>
                    </template>
                </b-table>
                <b-modal id="modal-create-form" centered size="lg" title="Membuat data jenis barang" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <type-form ref="revisi" :items="form" @input="submitCreate"></type-form>
                        </div>
                    </div>
                </b-modal>
                <b-modal id="modal-update-form" centered size="lg" title="Mengubah data jenis barang" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <type-form ref="revisi" :items="form" @input="submitUpdate"></type-form>
                        </div>
                    </div>
                </b-modal>
            </card>
        </div>
    </div>
</template>

<script>
import typeForm from '~/components/type/form'

export default {
    // name: 'Jenis Barang',
    components: {
        typeForm
    },
    data() {
        return {
            number: 0,
            table: {
                fields: [
                    {
                        key: 'nomor',
                        label: 'NO.',
                        sortable: false,
                    },
                    {
                        key: 'name',
                        label: 'name',
                        sortable: true,
                    },
                    {
                        key: 'actions',
                        label: 'AKSI',
                        sortable: false,
                    },
                ],
                items: [],
                totalRows: null,
                currentPage: 1,
                perPage: 100,
                pageOptions: [5, 10, 15, 100],
                sortBy: 'id',
                sortDesc: false,
                search: null,
                loading: false,
            },
            form: {
                id: null,
                name: null,
            }
        };
    },
    methods: {
        async getListJenis() {
            this.table.loading = true
            let param = {
                page: this.table.currentPage,
                search: this.table.search,
                perPage: this.table.perPage,
                order_direction: this.table.sortDesc,
                order_column: this.table.sortBy,
            }
            this.$store.dispatch("type/index", { params: param })
                .then((resp) => {
                    this.table.items = resp.data.data
                    this.table.totalRows = resp.data.total
                    this.table.currentPage = resp.data.current_page
                    this.table.perPage = resp.data.per_page
                    this.table.loading = false
                })
                .catch((error) => {
                    this.table.loading = false
                });
        },
        getType(id) {
            this.$store.dispatch("type/getType", { id: id })
                .then((resp) => {
                    console.log(resp.data.name);
                    this.form.name = resp.data.name
                    console.log(this.form.name);
                })
                .catch((error) => {
                });
        },
        buatData() {
            this.$bvModal.show('modal-create-form')
        },
        perbaharui(id) {
            this.form.id = id
            this.getType(id)
            this.$bvModal.show('modal-update-form')
        },
        submitUpdate(typeForm) {
            let form = typeForm;
            this.$store
                .dispatch("type/update", { id: this.form.id, form })
                .then((resp) => {
                    console.log(resp);
                    this.getListJenis();
                    this.form.id = null;
                    this.form.name = null;
                    this.$bvModal.hide('modal-update-form')
                })
                .catch((error) => {
                });
        },
        submitCreate(typeForm) {
            console.log("masuk");
            let form = typeForm;
            this.$store
                .dispatch("type/store", { form })
                .then((resp) => {
                    console.log(resp);
                    this.getListJenis();
                    this.form.id = null;
                    this.form.name = null;
                    this.$bvModal.hide('modal-create-form')
                })
                .catch((error) => {
                });
        },
        debounceSearch(val) {
            clearTimeout(this.debounce)
            this.debounce = setTimeout(() => {
                if (this.table.currentPage !== 1) {
                    this.table.currentPage = 1
                } else {
                    this.getListJenis()
                }
            }, 600)
        },
        deleteType(id) {
            this.$store.dispatch("type/delete", { id: id })
                .then((resp) => {
                    this.getListJenis()
                })
                .catch((error) => {
                });
        },
    },
    async created() {
        await this.getListJenis();
    },
}
</script>