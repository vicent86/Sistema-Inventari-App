<template>
    <div class="wrap">
        <div class="modal fade" id="create-vendor" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Informacion del Proveedor</h4>
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
                      <i class="material-icons">person</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="proveedor.nombre" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">email</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Correo electrónico"
                                                   v-model="proveedor.email" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Direccion" v-model="proveedor.direccion" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">gavel</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="CIF" v-model="proveedor.cif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <br />
                        <button @click="createVendor" type="button" class="btn btn-success waves-effect">Guardar</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import axios from "axios";
import mixin from "../../mixin.mjs";
import {base_url} from "../panel/config";

export default {
    mixins: [mixin],

    data() {
        return {
            proveedor: {
                nombre: "",
                email: "",
                direccion: "",
                cif: "",
            },

            errors: null,
        };
    },

    methods: {
        createVendor() {
            axios
                .post(base_url + "proveedor", this.proveedor)

                .then((response) => {
                   // $("#create-vendor").modal("hide");

                    this.vendor = { nombre: "", email: "", direccion: "", cif: "" };
                    this.errors = null;
                    EventBus.$emit("vendor-created", response.data);

                    // this.showMessage(response.data);

                    this.successALert(response.data);
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
