<template>
    <div class="wrap">
        <div class="body">
            <div class="row">
                <edit-stock :productos="productos" ></edit-stock>
                <update-stock></update-stock>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <select class="form-control select2" data-live-serach="true" @change="getProduct()" v-model="producto">
                        <option value>Todos los Productos</option>

                        <option v-for="(prod, index) in productos" :value="prod.id" :key="index">{{ prod.nombre }}</option>
                    </select>
                </div>

            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.......</h2>
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-condensed table-hover table-bordered">
                    <thead>
                    <tr>

                        <th>Producto</th>
                        <th>Localizacion</th>
                        <th>Existencia inicial</th>
                        <th>Existencia actual</th>
                        <th>Precio de compra</th>
                        <th>Precio de venta</th>
                        <th>Entrada por</th>
                        <th>Fecha de entrada</th>
                        <th>Agregar</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in stocks.data" :key="index">
                        <td>{{ value.producto.nombre }}</td>
                        <td>{{ value.producto.producto_nombre }}</td>
                        <td>{{ value.stock.cantidad }}</td>
                        <td>{{ value.stock.ultima_actualizacion }}</td>
                        <td>{{ value.user.nombre }}</td>
                        <td>{{ selllDateFormatted(value.created_at) }}</td>
                        <td>
                            <button @click="editQty(value.id, value.producto_id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">add</i>
                            </button>
                        </td>
                        <td>
                            <button @click="editStock(value.id, value.producto_id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>
                        <td>
                            <button @click="deleteStock(value.id)" type="button"
                                    class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <pagination :pageData="stocks"></pagination>
        </div>
    </div>
    </div>
</template>
<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";
import MomentMixin from "../../moment_mixin.mjs";
import axios from "axios";
import editStock from "./editStock";
import UpdateQuantity from "./UpdateStock.vue";
import Pagination from "../pagination/pagination.vue";

export default {
    props: ["productos"],

    mixins: [mixin, MomentMixin],

    components: {
        "edit-stock": editStock,
        "update-stock": UpdateQuantity,
        pagination: Pagination,
    },

    data() {
        return {
            stocks: [],
            nombre: "",
            producto: "",
            productos: [],
            isLoading: true,
        };
    },
    created() {
        const _this = this;
        this.getData();

        EventBus.$on("stock-created", function () {
            window.history.pushState({}, null, location.pathname);
            _this.getData();
        });
    },

    methods: {
        getData(page = 1) {
            this.isLoading = true;
            axios
                .get(
                    base_url +
                    "stock-lista?page=" +
                    page +
                    "&producto=" +
                    this.producto

                )
                .then((response) => {
                    this.stocks = response.data;
                    this.isLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getProduct() {
            if (this.producto=== "") {
                this.productos = [];

                this.producto = "";
            } else {
                this.productos = [];
                axios
                    .get(base_url + "stock/producto/" + this.producto)
                    .then((response) => {
                        this.productos = response.data;
                    });
            }

            this.getData(1);
        },

        // edit vendor

        editStock(id, producto_id) {
            EventBus.$emit("edit-stock", id, producto_id);
        },

        editQty(id) {
            EventBus.$emit("edit-qty", id);
        },

        // delete vendor

        deleteStock(id) {
            Swal(
                {
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "¡Sí, eliminar!",
                },
                () => { }
            ).then((result) => {
                if (result.value) {
                    axios.get(base_url + "stock/delete/" + id).then((res) => {
                        EventBus.$emit("stock-created", 1);

                        this.successALert(res.data);
                    });
                }
            });
        },

        pageClicked(pageNo) {
            let vm = this;
            vm.getData(pageNo);
        },
    },

    computed: {},
};
</script>
