<template>
    <div class="wrap">
        <div class="modal fade" id="create-customer" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Cliente nuevo</h4>
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
                      <i class="material-icons">account_circle</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="cliente.nombre_cliente">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Direccion"
                                                   v-model="cliente.direccion">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">phone</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Teléfono" v-model="cliente.telefono">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">gavel</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="CIF" v-model="cliente.cif" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <br>
                        <button @click="createCustomer" type="button" class="btn btn-success waves-effect">Guardar</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import  EventBus  from "../../vue-asset";
import mixin from "../../mixin.mjs";
import axios from "axios";
import {base_url} from "../panel/config";

export default {
    mixins: [mixin],

    data() {
        return {
            cliente: {
                nombre_cliente: "",
                direccion: "",
                telefono: "",
                cif: "",
                estado: true,
            },

            errors: null
        };
    },

    methods: {
        createCustomer() {
            axios
                .post(base_url + "cliente", this.cliente)

                .then(response => {
                    //$("#create-customer").modal("hide");

                    this.cliente = {
                        nombre_cliente: "",
                        direccion: "",
                        telefono: "",
                        cif: "",
                        estado: true,
                    };
                    this.errors = null;
                    EventBus.$emit("customer-created", response.data);

                    // this.showMessage(response.data);

                    this.successALert(response.data);
                })
                .catch(err => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        }
    },

    // end of method section

    created() { }
};
</script>
