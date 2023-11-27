<template>
    <div class="wrap">

        <div class="body">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" v-on:keyup="getData" placeholder="Buscar por nombre" name
                           v-model="name">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" v-on:keyup="getData" placeholder="Buscar por correo" name
                           v-model="email">
                </div>
                <div class="col-md-4"></div>
            </div>


            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.......</h2>
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Rol</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in usuarios.data" v-bind:key="index">
                        <td>{{ value.nombre }}</td>
                        <td>{{ value.email }}</td>
                        <td>{{ value.role.role_nombre }}</td>
                        <td>
                            <button @click="editUser(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>

                        <td>
                            <button @click="deleteUser(value.id)" type="button"
                                    class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <pagination :pageData="usuarios"></pagination>

            <div class="row">
                <actualizar-usuario></actualizar-usuario>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";
import axios from "axios";
import UpdateUser from "./ActualizarUsuario.vue";
import Pagination from '../pagination/pagination.vue';
import ActualizarUsuario from "@/components/usuario/ActualizarUsuario.vue";

export default {
    mixins: [mixin],

    components: {
        ActualizarUsuario,
        "actualizar-usuario": UpdateUser,
        "pagination": Pagination,
    },

    data() {
        return {
            usuarios: [],
            nombre: "",
            email: "",
            isLoading: true,
        };
    },
    created() {
        var _this = this;
        this.getData();

        EventBus.$on("usuario-creado", function () {
            _this.getData();
        });
    },

    methods: {
        getData(page = 1) {
            this.isLoading = true;
            axios
                .get(
                    base_url +
                    "usuario-lista?page=" +
                    page +
                    "&nombre=" +
                    this.nombre +
                    "&email=" +
                    this.email
                )
                .then(response => {
                    this.usuarios = response.data;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        // edit vendor

        editUser(id) {
            EventBus.$emit("usuario-edit", id);
        },

        // delete user

        deleteUser(id) {
            Swal(
                {
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "¡Sí, eliminar!",
                    cancelButtonText: "Cancelar"
                },
                () => { }
            ).then(result => {
                if (result.value) {
                    axios.get(base_url + "usuario/delete/" + id).then(res => {
                        EventBus.$emit("user-created", 1);
                        this.successAlert(res.data);
                    });
                }
            });
        },

        pageClicked(pageNo) {
            var vm = this;
            vm.getData(pageNo);
        }
    },

    computed: {

    }
};
</script>
