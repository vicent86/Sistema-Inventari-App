<template>
    <div class="wrap">
        <div class="modal fade" id="create-stock" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Agregar al Inventario</h4>
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
                      <i class="material-icons">shopping_bag</i>
                    </span>
                                        <div class="form-line">
                                            <select class="form-control select2" v-model="stock.producto" >
                                                <option value="">Selecciona un Producto</option>

                                                <option v-for="(value, index) in productos" :value="value.id" :key="index">{{ value.producto_nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control" placeholder="Localizacion" title="Localizacion:"
                                                   v-model="stock.localizacion"  />
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
                      <i class="material-icons">Event Upcoming</i>
                    </span>
                                        <div class="form-line">
                                            <input type="datetime-local" class="form-control" placeholder="Ultima_actualizacion" title="Ultima_actualizacion" v-model="stock.ultima_actualizacion" />
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
import {base_url} from "../panel/config";

export default {
    mixins:[mixin],

    data() {
        return {
            stock: {
                producto: "",
                cantidad: "",
                localizacion: "",
                ultima_actualizacion: this.localDate,
            },

            productos: [],

            errors: null,
        };
    },

    methods: {
        findProduct() {
            if (this.stock.producto === "") {
                this.productos = [];
            } else {
                this.productos = [];
                axios
                    .get(base_url + "stock/producto/" + this.stock.producto)
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
                    EventBus.$emit("stock-created", response.data);

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
                cantidad: "",
                localizacion: "",
                ultima_actualizacion: "",
            };
        },
    },

    // end of method section

    created() {
        this.localDate = new Date();
    },
};
</script>
