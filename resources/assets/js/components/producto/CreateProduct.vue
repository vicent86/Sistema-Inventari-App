<template>
    <div class="wrap">
        <div class="modal fade" id="create-product" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Información del Producto</h4>
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
                                        <select id="mySelect2" class="form-control select2" v-model="producto.categoria">
                                            <option value="0">Selecciona una categoría</option>
                                            <option v-for="(value, index) in categorias" :value="value.id" v-bind:key="index">
                                                {{ value.nombre }}
                                            </option>
                                        </select>

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
                      <i class="material-icons">euro</i>
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
                        <button @click="createProduct" type="button" class="btn btn-success waves-effect">Guardar</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
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
    props: ["categorias"],
    mixins: [mixin],
    mounted() {
        $('#mySelect2').val('0').trigger('change'); // Establece la opción por defecto
    },
    data() {
        return {
            producto: {
                id:0,
                id_proveedor:0,
                categoria: "",
                nombre: "",
                descripcion: "",
                precio: 0.0,
                estado: true,
            },

            errors: null,
        };
    },

    methods: {
        createProduct() {
            axios
                .post(base_url + "producto", this.producto)

                .then((response) => {
                    $("#create-product").modal("hide");

                    this.producto = { id: 0, nombre: "", descripcion: "", precio: 0.0, categoria: "", id_proveedor: 0 , estado: true};
                    this.errors = null;
                    EventBus.$emit("product-created", response.data);

                    this.successALert(response.data);
                    $('#mySelect2').val('0').trigger('change');
                })
                .catch((err) => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },
    },

    // end of method section

    created() { },
};
</script>
