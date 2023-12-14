<template>
    <div class="col-md-12">
        <div class="modal fade" id="update-product" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar Información del Producto</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger" v-if="errors">
                            <ul>
                                <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                            </ul>
                        </div>
                        <form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">category</i>
                    </span>
                                        <div class="form-line">
                                            <select class="form-control select2" v-model="producto.categoria"
                                                    id="mySelect2Update">
                                                <option value>Selecciona una categoría</option>

                                                <option v-for="(value, index) in cat" :value="value.id" :key="index">{{ value.nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">inventory</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="producto.nombre" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">line_style</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Descripcion" v-model="producto.descripcion" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">Euro</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Precio" v-model="producto.precio" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <br />
                        <button @click="updateProduct(producto.id)" type="button"
                                class="btn btn-success waves-effect">Actualizar</button>
                        <button @click="closeModal()" type="button" class="btn btn-default waves-effect"
                                data-dismiss="modal">Cancelar</button>
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
    props: ["cat"],

    mixins: [mixin],
    name: "update-product",

    data() {
        return {
            producto: {
                id: 1,
                id_proveedor:1,
                categoria: "",
                nombre: "",
                descripcion: "",
                precio: 0.0,
                estado: true,
            },

            errors: null,
        };
    },

    created() {
        let vm = this;

        EventBus.$on("product-edit", function (id) {
            vm.product.id = id;

            //$("#update-product").modal("show");

            vm.editProduct(id);
        });

        // $("#update-product").on("hidden.bs.modal", function () {
        //     vm.closeModal();
        // });
    },



    methods: {
        editProduct(id) {
            axios
                .get(base_url + "producto/" + id + "/edit")

                .then((response) => {
                    this.producto = {
                        id: response.data.id,
                        id_proveedor: response.data.id_proveedor,
                        categoria_id: response.data.categoria_id,
                        producto_nombre: response.data.producto_nombre,
                        descripcion: response.data.descripcion,
                        precio: response.data.precio,
                        estado: response.data.estado,
                    };
                    //$('#mySelect2Update').val(response.data.category_id).trigger('change');
                });
        },
        updateProduct(id) {
            axios
                .post(base_url + "producto/update/" + id, this.producto)
                .then((res) => {
                    if (res.data.status === "success") {
                        this.successALert(res.data);
                        EventBus.$emit("product-created", 1);
                        this.closeModal();
                        //$("#update-product").modal("hide");
                    }
                })
                .catch((err) => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },

        closeModal() {
            this.errors = null;
            this.producto = { id: 0, id_proveedor: 0, nombre: "", detalles: "", precio: 0.0, categoria: "", estado: true };
            EventBus.$emit("product-created", 1);
        },
    },
};
</script>
