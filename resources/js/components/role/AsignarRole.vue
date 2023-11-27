<template>
    <div class="col-md-12">
        <div class="modal fade" id="assign-role" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Permiso de <span style="color: teal">{{ role.role_nombre
                            }}</span></h4>
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

                                    <div class="demo-checkbox" v-for="(value, index) in role.menus" :key="index">

                                        <div class="col-md-12">
                                            <hr v-if="index !== 0">
                                            <div style="font-weight: bold;" class="demo-switch-title">{{ value.nombre }}</div>

                                            <div class="switch">
                                                <label v-if="value.sub_menu.length === 0"><input :value="value.id" :id="value.id"
                                                                                                 v-model="value.check" type="checkbox" checked><span
                                                    class="lever switch-col-blue"></span></label>
                                            </div>
                                        </div>
                                        <!-- sub menu  	 -->
                                        <div class="col-md-4" v-for="sub in value.sub_menu" :key="sub">
                                            <div class="demo-switch-title">{{ sub.nombre }}</div>
                                            <div class="switch">
                                                <label><input :value="sub.id" :id="sub.id" v-model="sub.check" type="checkbox" checked><span
                                                    class="lever switch-col-blue"></span></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>


                        </form>

                    </div>
                    <div class="modal-footer">
                        <br>
                        <button @click="AssignRole" type="button" class="btn btn-success waves-effect">Actualizar</button>
                        <button @click="closeModal()" type="button" class="btn btn-default waves-effect"
                                data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { EventBus } from '../../vue-asset';
import mixin from '../../mixin.mjs';
import axios from 'axios';

export default {

    name: 'asignar-role',

    mixins: [mixin],

    data() {

        return {

            role: {

                id: 0,
                role_nombre: '',
                menus: [],
            },



            errors: null

        }

    },

    created() {

        let vm = this;

        EventBus.$on('asignar-permiso', function (id) {

            vm.role.id = id;

            vm.RoleInfo(id);
            vm.getMenus(id);

            $('#assign-role').modal('show');

        });

        $('#assign-role').on('hidden.bs.modal', function () {
            vm.closeModal();
        });



    },

    methods: {

        RoleInfo(id) {

            axios.get(base_url + 'role/' + id + '/edit')

                .then(response => {
                    this.role.id = response.data.id;
                    this.role.role_nombre = response.data.role_nombre;
                })

        },

        getMenus(id) {

            axios.get(base_url + 'role/' + id)

                .then(response => {

                    this.role.menus = response.data;
                })

        },
        AssignRole() {

            axios.post(base_url + 'permiso', this.role)
                .then(res => {

                    console.log(res);

                    if (res.data.status === 'success') {
                        this.successALert(res.data);
                        EventBus.$emit('role-creado', 1);
                        this.closeModal();
                        $('#assign-role').modal('hide');
                    }
                })
                .catch(err => {

                    if (err.response) {

                        this.errors = err.response.data.errors;
                    }
                })

        },



        closeModal() {
            EventBus.$emit('role-creado', 1);
        }




    }

}



</script>
