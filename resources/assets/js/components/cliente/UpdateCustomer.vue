<template>
    <div class="wrap">
        <div class="modal fade" id="update-customer" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar Cliente</h4>
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
                        <button @click="updateCustomer" type="button" class="btn btn-success waves-effect">Actualizar</button>
                        <button @click="resetForm()" type="button" class="btn btn-default waves-effect"
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
    name: 'update-customer',
    mixins: [mixin],

    data() {
        return {
            cliente: {
                id: "",
                nombre_cliente: "",
                direccion: "",
                telefono: "",
                cif: "",
                estado: true,
            },

            errors: null
        };
    },


    created() {

        var _this = this;

        EventBus.$on('customer-edit', function (id) {

            _this.cliente.id = id;

            _this.getEditData(id);

            //$('#update-customer').modal('show');



        });

        // $('#update-customer').on('hidden.bs.modal', function () {
        //     _this.resetForm();
        // });

    },

    methods: {

        getEditData(id) {

            axios.get(base_url + 'cliente/' + id + '/edit')

                .then(response => {


                    this.customer = {
                        id: response.data.id,
                        nombre_cliente: response.data.nombre_cliente,
                        direccion: response.data.direccion,
                        telefono: response.data.telefono,
                        cif: response.data.cif,
                        estado: response.data.estado,
                    };

                })

        },

        updateCustomer() {
            axios.post(base_url + "cliente/update/" + this.cliente.id, this.cliente)

                .then(response => {
                    //$("#update-customer").modal("hide");
                    this.resetForm();
                    EventBus.$emit("customer-created", 1);
                    this.successALert(response.data);
                })
                .catch(err => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },

        resetForm() {

            this.clienter = {
                id: '',
                nombre_cliente: '',
                direccion: '',
                telefono: '',
                cif: '',
                estado: true,
            };
            this.errors = null;

        },

    },



    // end of method section

};
</script>
