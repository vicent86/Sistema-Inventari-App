<template>
    <div class="wrap">
        <div class="body">
            <div class="row">
                <editar-stock :categorias="categorias" :proveedores="proveedores"></editar-stock>
                <actualizar-cantidad></actualizar-cantidad>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <select class="form-control select2" data-live-serach="true" @change="getProduct()" v-model="categoria"
                            v-select="categoria">
                        <option value>Todas la categorías</option>

                        <option v-for="(cat, index) in categorias" :value="cat.id" :key="index">{{ cat.nombre }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control select2" data-live-serach="true" @change="getData(1)" v-model="producto"
                            v-select="producto">
                        <option value>Todos los productos</option>

                        <option v-for="(pd, index) in productos" :value="pd.id" :key="index">{{ pd.producto_nombre }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control select2" data-live-serach="true" @change="getData(1)" v-model="proveedor"
                            v-select="proveedor">
                        <option value>Todos los proveedores</option>

                        <option v-for="(vd, index) in proveedores" :value="vd.id" :key="index">{{ vd.nombre }}</option>
                    </select>
                </div>
            </div>

            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.......</h2>
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-condensed table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Producto</th>
                        <th>Proveedor</th>
                        <th>Comprobante</th>
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
                        <td>{{ value.categoria.nombre }}</td>
                        <td>{{ value.producto.producto_nombre }}</td>
                        <td>{{ value.proveedor.nombre }}</td>
                        <td>{{ value.lista_no }}</td>
                        <td>{{ value.cantidad_stock }}</td>
                        <td>{{ value.cantidad_actual }}</td>
                        <td>{{ value.precio_compra }}</td>
                        <td>{{ value.precio_venta }}</td>
                        <td>{{ value.usuario.nombre }}</td>
                        <td>{{ selllDateFormatted(value.created_at) }}</td>
                        <td>
                            <button @click="editQty(value.id, value.categoria_id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">add</i>
                            </button>
                        </td>
                        <td>
                            <button @click="editStock(value.id, value.categoria_id)" type="button"
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
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";
import MomentMixin from "../../moment_mixin.mjs";
import axios from "axios";
import editStock from "./EditarStock";
import UpdateQuantity from "./ActualizarCantidad";
import Pagination from "../pagination/pagination.vue";


export default {
    props: ["categorias", "proveedores"],

    mixins: [mixin, MomentMixin],

    components: {
        "edit-stock": editStock,
        "actualizar-cantidad": UpdateQuantity,
        pagination: Pagination,
    },

    data() {
        return {
            stocks: [],
            nombre: "",
            producto: "",
            categoria: "",
            proveedor: "",
            productos: [],
            isLoading: true,
        };
    },
    created() {
        var _this = this;
        this.getData();

        EventBus.$on("stock-creado", function () {
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
                    "stock-list?page=" +
                    page +
                    "&producto=" +
                    this.producto +
                    "&categoria=" +
                    this.categoria +
                    "&proveedor=" +
                    this.proveedor
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
            if (this.categoria === "") {
                this.productos = [];

                this.producto = "";
            } else {
                this.productos = [];
                axios
                    .get(base_url + "categoria/producto/" + this.categoria)
                    .then((response) => {
                        this.productos = response.data;
                    });
            }

            this.getData(1);
        },

        // edit vendor

        editStock(id, categoria_id) {
            EventBus.$emit("edit-stock", id, categoria_id);
        },

        editQty(id) {
            EventBus.$emit("editar-cantidad", id);
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
                        EventBus.$emit("stock-creado", 1);

                        this.successALert(res.data);
                    });
                }
            });
        },

        pageClicked(pageNo) {
            var vm = this;
            vm.getData(pageNo);
        },
    },

    computed: {},
};
</script>
