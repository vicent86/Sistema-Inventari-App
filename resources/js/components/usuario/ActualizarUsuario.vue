<template>
    <div class="wrap">
        <div class="modal fade" id="update-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="updateUser">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Actualizar usuario</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" v-if="errors">
                                <ul>
                                    <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">account_circle</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="usuario.nombre">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">email</i>
                    </span>
                                        <div class="form-line">
                                            <input type="email" class="form-control date" placeholder="Correo electrónico" v-model="usuario.email">
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-12">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">vpn_key</i>
                    </span>
                                        <div class="form-line">
                                            <select class="form-control" v-model="usuario.role">
                                                <option value>Selecciona un rol</option>
                                                <option v-for="value in role_list" :value="value.id" :key="value">{{ value.role_nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="submit" class="btn btn-success waves-effect">Actualizar</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
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

    data() {
        return {
            usuario: {
                id: '',
                nombre: "",
                email: "",
                role: ""
            },

            role_list: [],

            errors: null
        };
    },

    created() {
        var _this = this;
        EventBus.$on("usuario-edit", function (id) {
            _this.id = id;
            _this.findUser(id);
            $('#update-user').modal('show');
        });
    },

    mounted() {
        this.roleList();
    },

    methods: {
        findUser(id) {
            axios
                .get(base_url + "usuario/" + id + "/edit")

                .then(response => {
                    this.user = {
                        id: response.data.id,
                        nombre: response.data.nombre,
                        email: response.data.email,
                        role: response.data.role_id,
                    };
                });
        },

        updateUser() {
            axios
                .post(base_url + "usuario/update/" + this.user.id, this.user)

                .then(response => {
                    $("#update-user").modal("hide");

                    this.usuario = {
                        id: "",
                        nombre: "",
                        email: "",
                        role: ""
                    };

                    this.errors = null;
                    EventBus.$emit("usuario-creado", 1);
                    this.successALert(response.data);
                })
                .catch(err => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },

        roleList() {
            axios.get(base_url + "role-list").then(response => {
                this.role_list = response.data;
            });
        }
    },

    // end of method section

};
</script>
