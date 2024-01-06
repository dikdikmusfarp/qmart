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
                            class="form-control" name="name" placeholder="Cari barang" />
                    </div>
                </div>
                <b-table responsive="sm" class="myTablePTK" :fields="table.fields" :items="table.items"
                    :current-page="table.currentPage" :busy.sync="table.loading" :sort-by.sync="table.sortBy"
                    :sort-desc.sync="table.sortDesc" empty-filtered-text="Data barang tidak ditemukan"
                    empty-text="Tidak ada data barang" :show-empty="true">
                    <template v-slot:cell(nomor)="{ index }">
                        {{ (index + 1 + number) }}
                    </template>
                    <template v-slot:cell(harga)="{ item }">
                        Rp. {{ item.harga }}
                    </template>
                    <template v-slot:cell(total_stock)="{ item }">
                        {{ item.total_stock ?  item.total_stock : 0 }}
                    </template>
                    <template v-slot:cell(actions)="{ item }">
                        <b-button v-on:click="perbaharui(item.id)" size="sm" style="margin-top: 0.2rem;">
                            <i class="tim-icons icon-pencil"></i>
                        </b-button>

                        <b-button v-on:click="stock(item.id)" size="sm" style="margin-top: 0.2rem;">
                            <i class="tim-icons icon-simple-add"></i>
                        </b-button>
                    </template>
                </b-table>
                <b-modal id="modal-create-form" centered size="lg" title="Membuat data jenis barang" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <item-form ref="revisi" :items="form" @input="submitCreate"></item-form>
                        </div>
                    </div>
                </b-modal>
                <b-modal id="modal-update-form" centered size="lg" title="Mengubah data jenis barang" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <item-form ref="revisi" :items="form" @input="submitUpdate"></item-form>
                        </div>
                    </div>
                </b-modal>
                <b-modal id="modal-stock-form" centered size="lg" title="Menambah data stok barang" title-class="font-27"
                    hide-footer no-close-on-backdrop>
                    <div class="row">
                        <div class="col-12">
                            <stock-form ref="revisi" :items="form" @input="submitStock"></stock-form>
                        </div>
                    </div>
                </b-modal>
            </card>
        </div>
    </div>
</template>

<script>
import ItemForm from '~/components/item/form'
import stockForm from '~/components/stock/form'


export default {
    // name: 'Jenis Barang',
    components: {
        ItemForm,
        stockForm
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
                        key: 'nama',
                        label: 'Nama Barang',
                        sortable: true,
                    },
                    {
                        key: 'jenis',
                        label: 'Jenis Barang',
                        sortable: true,
                    },
                    {
                        key: 'harga',
                        label: 'Harga Satuan',
                        sortable: true,
                    },
                    {
                        key: 'total_stock',
                        label: 'Total Stok',
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
                price: null,
                type_id: null,
                item_id: null,
                stock: null,
            }
        };
    },
    methods: {
        async getListItem() {
            this.table.loading = true
            let param = {
                page: this.table.currentPage,
                search: this.table.search,
                perPage: this.table.perPage,
                order_direction: this.table.sortDesc,
                order_column: this.table.sortBy,
            }
            this.$store.dispatch("item/index", { params: param })
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
        getItem(id) {
            this.$store.dispatch("item/getItem", { id: id })
                .then((resp) => {
                    this.form.name = resp.data.name
                    this.form.price = resp.data.price
                    this.form.type_id = resp.data.type_id
                })
                .catch((error) => {
                });
        },
        buatData() {
            this.$bvModal.show('modal-create-form')
        },
        perbaharui(id) {
            this.form.id = id
            this.getItem(id)
            this.$bvModal.show('modal-update-form')
        },
        stock(id) {
            this.form.item_id = id
            this.$bvModal.show('modal-stock-form')
        },
        submitUpdate(ItemForm) {
            let form = ItemForm;
            this.$store
                .dispatch("item/update", { id: this.form.id, form })
                .then((resp) => {
                    console.log(resp);
                    this.getListItem();
                    this.form.id = null;
                    this.form.name = null;
                    this.form.price = null;
                    this.form.type_id = null;
                    this.$bvModal.hide('modal-update-form')
                })
                .catch((error) => {
                });
        },
        submitCreate(ItemForm) {
            let form = ItemForm;
            this.$store
                .dispatch("item/store", { form })
                .then((resp) => {
                    console.log(resp);
                    this.getListItem();
                    this.form.id = null;
                    this.form.name = null;
                    this.form.price = null;
                    this.form.type_id = null;
                    this.$bvModal.hide('modal-create-form')
                })
                .catch((error) => {
                });
        },
        submitStock(stockForm) {
            let form = stockForm;
            this.$store
                .dispatch("stock/store", { form })
                .then((resp) => {
                    console.log(resp);
                    this.getListItem();
                    this.form.id = null;
                    this.form.stock = null;
                    this.form.item_id = null;
                    this.$bvModal.hide('modal-stock-form')
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
                    this.getListItem()
                }
            }, 600)
        },
    },
    async created() {
        await this.getListItem();
    },
}
</script>