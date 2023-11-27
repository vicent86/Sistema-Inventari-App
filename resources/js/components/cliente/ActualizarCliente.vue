<template>
    <div class="wrap">
        <div class="modal fade" id="update-customer" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar cliente</h4>
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
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="cliente.cliente_nombre">
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
                                                   v-model="cliente.email">
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
                      <i class="material-icons">map</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Dirección" v-model="cliente.direccion" />
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

export default {
    name: 'update-customer',
    mixins: [mixin],

    data() {
        return {
            cliente: {
                id: "",
                cliente_nombre: "",
                email: "",
                telefono: "",
                direccion: ""
            },

            errors: null
        };
    },


    created() {

        var _this = this;

        EventBus.$on('cliente-edit', function (id) {

            _this.cliente.id = id;

            _this.getEditData(id);

            $('#update-customer').modal('show');



        });

        $('#update-customer').on('hidden.bs.modal', function () {
            _this.resetForm();
        });

    },

    methods: {

        getEditData(id) {

            axios.get(base_url + 'clientes/' + id + '/edit')

                .then(response => {


                    this.cliente = {
                        id: response.data.id,
                        cliente_nombre: response.data.cliente_nombre,
                        email: response.data.email,
                        telefono: response.data.telefono,
                        direccion: response.data.direccion,
                    };

                })

        },

        updateCustomer() {
            axios.post(base_url + "clientes/update/" + this.customer.id, this.customer)

                .then(response => {
                    $("#update-customer").modal("hide");
                    this.resetForm();
                    EventBus.$emit("cliente-creado", 1);
                    this.successALert(response.data);
                })
                .catch(err => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },

        resetForm() {

            this.cliente = {
                id: '',
                cliente_nombre: '',
                email: '',
                telefono: '',
                direccion: '',
            };
            this.errors = null;

        },

    },



    // end of method section

};
</script>
