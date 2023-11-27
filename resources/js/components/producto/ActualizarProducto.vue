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
                                            <select class="form-control select2" v-model="producto.categoria" v-select="producto.categoria"
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
                                            <input type="text" class="form-control date" placeholder="Detalles" v-model="producto.detalles" />
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

export default {
    props: ["cat"],

    mixins: [mixin],
    name: "actulizar-producto",

    data() {
        return {
            producto: {
                id: 1,
                categoria: "",
                nombre: "",
                detalles: "",
            },

            errors: null,
        };
    },

    created() {
        let vm = this;

        EventBus.$on("producto-edit", function (id) {
            vm.product.id = id;

            $("#update-product").modal("show");

            vm.editProduct(id);
        });

        $("#update-product").on("hidden.bs.modal", function () {
            vm.closeModal();
        });
    },



    methods: {
        editProduct(id) {
            axios
                .get(base_url + "producto/" + id + "/edit")

                .then((response) => {
                    this.producto = {
                        id: response.data.id,
                        categoria: response.data.categoria_id,
                        nombre: response.data.producto_nombre,
                        detalles: response.data.detalles,
                    };
                    $('#mySelect2Update').val(response.data.categoria_id).trigger('change');
                });
        },
        updateProduct(id) {
            axios
                .post(base_url + "producto/update/" + id, this.producto)
                .then((res) => {
                    if (res.data.status === "success") {
                        this.successALert(res.data);
                        EventBus.$emit("producto-creado", 1);
                        this.closeModal();
                        $("#update-product").modal("hide");
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
            this.producto = { id: 0, nombre: "", detalles: "" };
            EventBus.$emit("producto-creado", 1);
        },
    },
};
</script>
