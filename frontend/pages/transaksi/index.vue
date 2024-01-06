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
                            class="form-control" name="name" placeholder="Cari waktu transaksi" />
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
                    </template>
                </b-table>
                <b-modal id="modal-create-form" centered size="lg" title="Membuat data transaksi" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <transaction-form ref="revisi" :items="form" @input="submitCreate"></transaction-form>
                        </div>
                    </div>
                </b-modal>
                <b-modal id="modal-update-form" centered size="lg" title="Mengubah data transaksi" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <transaction-form ref="revisi" :items="form" @input="submitUpdate"></transaction-form>
                        </div>
                    </div>
                </b-modal>
            </card>
        </div>
    </div>
</template>

<script>
import transactionForm from '~/components/transaction/form'

export default {
    // name: 'Jenis Barang',
    components: {
        transactionForm
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
                        key: 'waktu',
                        label: 'Waktu Pembelian',
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
                transaction_time: null,
            }
        };
    },
    methods: {
        async getListTransaksi() {
            this.table.loading = true
            let param = {
                page: this.table.currentPage,
                search: this.table.search,
                perPage: this.table.perPage,
                order_direction: this.table.sortDesc,
                order_column: this.table.sortBy,
            }
            this.$store.dispatch("transaction/index", { params: param })
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
        getTransaction(id) {
            this.$store.dispatch("transaction/getTransaction", { id: id })
                .then((resp) => {
                    this.form.transaction_time = resp.data.transaction_time
                })
                .catch((error) => {
                });
        },
        buatData() {
            this.$bvModal.show('modal-create-form')
        },
        perbaharui(id) {
            this.form.id = id
            this.getTransaction(id)
            this.$bvModal.show('modal-update-form')
        },
        submitUpdate(typeForm) {
            let form = typeForm;
            this.$store
                .dispatch("transaction/update", { id: this.form.id, form })
                .then((resp) => {
                    this.getListTransaksi();
                    this.form.id = null;
                    this.form.transaction_time = null;
                    this.$bvModal.hide('modal-update-form')
                })
                .catch((error) => {
                });
        },
        submitCreate(typeForm) {
            console.log("masuk");
            let form = typeForm;
            this.$store
                .dispatch("transaction/store", { form })
                .then((resp) => {
                    this.getListTransaksi();
                    this.form.id = null;
                    this.form.transaction_time = null;
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
                    this.getListTransaksi()
                }
            }, 600)
        },
    },
    async created() {
        await this.getListTransaksi();
    },
}
</script>