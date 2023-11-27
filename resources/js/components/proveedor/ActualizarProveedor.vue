<template>
    <div class="col-md-12">
        <div class="modal fade" id="update-vendor" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar Informacion del proveedor</h4>
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
                      <i class="material-icons">phone</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Telefono" v-model="proveedor.telefono" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">map</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Dirección" v-model="proveedor.direccion" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <br />
                        <button @click="updateVendor(proveedor.id)" type="button"
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
    mixins: [mixin],

    name: "actualizar-proveedor",

    data() {
        return {
            proveedor: {
                id: 0,
                nombre: "",
                email: "",
                telefono: "",
                direccion: "",
            },

            errors: null,
        };
    },

    created() {
        let vm = this;

        EventBus.$on("proveedor-edit", function (id) {
            vm.proveedor.id = id;

            vm.editVendor(id);

            $("#update-vendor").modal("show");
        });

        $("#update-vendor").on("hidden.bs.modal", function () {
            vm.closeModal();
        });
    },

    methods: {
        editVendor(id) {
            axios
                .get(base_url + "proveedor/" + id + "/edit")

                .then((response) => {
                    this.vendor = {
                        id: response.data.id,
                        nombre: response.data.nombre,
                        email: response.data.email,
                        telefono: response.data.telefono,
                        direccion: response.data.direccion,
                    };
                });
        },
        updateVendor(id) {
            axios
                .post(base_url + "proveedor/update/" + id, this.proveedor)
                .then((res) => {
                    if (res.data.status === "success") {
                        this.successALert(res.data);
                        EventBus.$emit("vendor-created", 1);
                        this.closeModal();
                        $("#update-vendor").modal("hide");
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
            this.proveedor = { id: 0, nombre: "", email: "", telefono: "", direccion: "" };
            EventBus.$emit("vendor-created", 1);
        },
    },
};
</script>
