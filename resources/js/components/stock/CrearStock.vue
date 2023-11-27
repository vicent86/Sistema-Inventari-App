<template>
    <div class="wrap">
        <div class="modal fade" id="create-stock" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Agregar al inventario</h4>
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
                                                <option value="">Selecciona un producto</option>

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
                                            <select class="form-control select2" v-model="stock.proveedor" v-select="stock.proveedor">
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
                                                   v-model="localDate" disabled />
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
                                            <input type="number" class="form-control" placeholder="Cantidad" v-model="stock.cantidad" />
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
                        <button @click="createStock()" type="button" class="btn btn-success waves-effect">Agregar</button>
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
    mixins:[mixin],

    data() {
        return {
            stock: {
                producto: "",
                categoria: "",
                proveedor: "",
                cantidad: "",
                precio_compra: "",
                precio_venta: "",
                nota: "",
                localDate: this.localDate,
            },

            productos: [],

            errors: null,
        };
    },

    methods: {
        findProduct() {
            if (this.stock.categoria === "") {
                this.productos = [];
            } else {
                this.productos = [];
                axios
                    .get(base_url + "categoria/producto/" + this.stock.categoria)
                    .then((response) => {
                        this.productos = response.data;
                    });
            }
        },

        createStock() {
            axios
                .post(base_url + "stock", this.stock)

                .then((response) => {
                    $("#create-stock").modal("hide");

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

    // end of method section

    created() {
        this.localDate = new Date();
    },
};
</script>
