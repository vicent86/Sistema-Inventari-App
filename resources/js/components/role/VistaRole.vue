<template>
    <div class="wrap">

        <div class="body">

            <div class="table-responsive">

                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Otorgar permiso</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in roles" :key="index">
                        <td>{{ value.role_nombre }}</td>
                        <td>
                            <button @click="perMission(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">vpn_key</i>
                            </button>
                        </td>


                        <td>
                            <button @click="editRole(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>

                        <td>
                            <button @click="deleteRole(value.id)" type="button"
                                    class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>

                    </tbody>
                </table>


            </div>
            <div class="row">

                <actualizar-role></actualizar-role>
                <asignar-role></asignar-role>

            </div>



        </div>
    </div>
</template>

<script>

import { EventBus } from '../../vue-asset';
import mixin from '../../mixin.mjs';
import axios from 'axios';
import UpdateRole from './ActualizarRole.vue'
import AssignRole from './AsignarRole.vue'


export default {

    mixins: [mixin],

    components: {

        'actualizar-role': UpdateRole,
        'asignar-role': AssignRole

    },

    data() {

        return {

            roles: [],

        }


    },
    created() {

        var _this = this;
        this.getData();

        EventBus.$on('role-creado', function () {
            _this.getData();
        });

    },

    methods: {


        getData() {

            axios.get(base_url + 'role-lista')
                .then(response => {

                    this.roles = response.data;

                })

        },

        perMission(id) {

            EventBus.$emit('asignar-permiso', id);

        },


        editRole(id) {

            EventBus.$emit('role-edit', id);

        },

        deleteRole(id) {

            Swal({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, eliminar!',
                cancelButtonText: 'Cancelar'
            }, () => {



            }).then((result) => {
                if (result.value) {

                    axios.get(base_url + 'role/delete/' + id)
                        .then(res => {

                            EventBus.$emit('role-creado', 1);
                            this.successAlert(res.data);
                        })


                }
            })

        }


    }

}


</script>
