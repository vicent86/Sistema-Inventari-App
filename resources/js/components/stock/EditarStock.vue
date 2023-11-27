<template>
    <div class="wrap">
        <div class="modal fade" id="edit-stock" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar inventario</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors">
                            <ul>
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">palette</i>
                    </span>
                                        <div class="form-line">
                                            <select class="form-control select2" v-model="stock.categoria" v-select="stock.categoria"
                                                    @change="findProduct()">
                                                <option value>Selecciona una categoría</option>

                                                <option v-for="(value, index) in categorias" :value="value.id" :key="index">{{ value.nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">shopping_bag</i>
                    </span>
                                        <div class="form-line">
                                            <select class="form-control select2" v-model="stock.producto" v-select="stock.producto">
                                                <option value>Selecciona un producto</option>

                                                <option v-for="(value, index) in productos" :value="value.id" :key="index">{{ value.producto_nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">supervisor_account</i>
                    </span>
                                        <div class="form-line">
                                            <select class="form-control select2" data-live-serach="true" v-model="stock.proveedor"
                                                    v-select="stock.proveedor">
                                                <option value>Selecciona un proveedor</option>

                                                <option v-for="(vd, index) in proveedores" :value="vd.id" :key="index">{{ vd.nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">playlist_add_check</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Comprobante No:" title="Comprobante No:"
                                                   v-model="stock.lista_no" disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">attach_money</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Precio de compra"
                                                   v-model="stock.precio_compra" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">attach_money</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Precio de venta"
                                                   v-model="stock.precio_venta" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">add</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Cantidad " v-model="stock.cantidad_actual"
                                                   disabled />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">assignment</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Nota" title="Nota" v-model="stock.nota" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <br />
                        <button @click="updateStock(stock.id)" type="button" class="btn btn-success waves-effect">Actualizar</button>
                        <button @click="resetForm()" type="button" class="btn btn-default waves-effect"
                                data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";
import axios from "axios";

export default {
    props: ["proveedores", "categorias"],
    mixins: [mixin],

    data() {
        return {
            stock: {
                id: "",
                producto: "",
                categoria: "",
                proveedor: "",
                cantidad: "",
                cantidad_actual: "",
                precio_compra: "",
                precio_venta: "",
                nota: "",
                lista_no: "",
            },

            products: [],

            errors: null,
        };
    },

    created() {
        let vm = this;

        EventBus.$on("edit-stock", function (id, categoria_id) {
            vm.stock.id = id;
            vm.stock.categoria = categoria_id;
            vm.editStock(id);
            vm.findProduct();
            $("#edit-stock").modal("show");
        });

        $("#edit-stock").on("hidden.bs.modal", function () {
            vm.resetForm();
        });
    },

    methods: {
        editStock(id) {
            axios.get(base_url + "stock/" + id + "/edit").then((response) => {
                this.stock = {
                    id: response.data.id,
                    producto: response.data.producto_id,
                    categoria: response.data.categoria_id,
                    proveedor: response.data.proveedor_id,
                    cantidad: response.data.cantidad_stock,
                    cantidad_actual: response.data.cantidad_actual,
                    precio_compra: response.data.precio_compra,
                    precio_venta: response.data.precio_venta,
                    nota: response.data.nota,
                    lista_no: response.data.lista_no,
                };
            });
        },

        findProduct() {
            if (this.stock.categoria === "") {
                this.productos = [];
            } else {
                this.productos = [];
                axios
                    .get(base_url + "categoria/producto/" + this.stock.category)
                    .then((response) => {
                        this.productos = response.data;
                    });
            }
        },

        updateStock(id, e) {
            if (this.stock.estado === "yes") {
                if (this.stock.cantidad <= 0) {
                    alert("Por favor ingrese la cantidad de cambio");
                    e.preventDefault();
                }
            }

            axios
                .post(base_url + "stock/update/" + id, this.stock)

                .then((response) => {
                    $("#edit-stock").modal("hide");

                    this.resetForm();

                    this.errors = null;
                    EventBus.$emit("stock-creado", response.data);

                    this.successALert(response.data);
                })
                .catch((err) => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },
        resetForm() {
            this.stock = {
                producto: "",
                proveedor: "",
                cantidad: "",
                precio_compra: "",
                precio_venta: "",
                nota: "",
                categoria: "",
            };
        },
    },
};
</script>
