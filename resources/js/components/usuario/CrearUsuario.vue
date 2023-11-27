<template>
    <div class="wrap">

        <div class="modal fade" id="create-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="createuser">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Usuario nuevo</h4>
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

                                <div class="col-md-6">
                                    <div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">lock</i>
										</span>
                                        <div class="form-line">
                                            <input type="password" class="form-control date" placeholder="Ingresá tu contraseña"
                                                   v-model="usuario.password">
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">lock_open</i>
										</span>
                                        <div class="form-line">
                                            <input type="password" class="form-control date" placeholder="Reingresá tu contraseña"
                                                   v-model="usuario.password_confirmation">
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
                                                <option value="">Selecciona un rol</option>
                                                <option v-for="value in role_lista" :value="value.id" :key="value">{{ value.role_nombre }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>


                            </div>



                        </div>
                        <div class="modal-footer">
                            <br>
                            <button type="submit" class="btn btn-success waves-effect">Guardar</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<script>

import { EventBus } from '../../vue-asset';
import mixin from '../../mixin.mjs';
import axios from 'axios';

export default {

    mixins: [mixin],

    data() {

        return {

            usuario: {

                nombre: '',
                email: '',
                password: '',
                password_confirmation: '',
                role: '',

            },

            role_lista: [],

            errors: null


        }

    },

    mounted() {

        this.roleList();

    },

    methods: {


        createuser() {

            axios.post(base_url + 'usuario', this.user)

                .then(response => {

                    $('#create-user').modal('hide');

                    this.usuario = {
                        'nombre': '',
                        'email': '',
                        'password': '',
                        'password_confirmation': '',
                        'role': ''
                    };

                    this.errors = null;
                    EventBus.$emit('usuario-creado', response.data);
                    this.successALert(response.data);

                })
                .catch(err => {

                    if (err.response) {

                        this.errors = err.response.data.errors;
                    }

                })

        },

        roleList() {

            axios.get(base_url + 'role-list')
                .then(response => {
                    this.role_list = response.data;
                });

        },

    },

    // end of method section


    created() {


    },




}



</script>
