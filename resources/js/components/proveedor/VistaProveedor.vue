<template>
    <div class="wrap">
        <div class="body">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData" placeholder="Nombre" name v-model="nombre" />
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData" placeholder="Correo electrónico" name
                           v-model="email" />
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData" placeholder="Telefono" name v-model="telefono" />
                </div>
            </div>

            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.....</h2>
            </div>

            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Telefono</th>
                        <th>Dirección</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in proveedores.data" :key="index">
                        <td>{{ value.nombre }}</td>
                        <td>{{ value.email }}</td>
                        <td>{{ value.telefono }}</td>
                        <td>{{ value.direccion }}</td>
                        <td>
                            <button @click="editVendor(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>
                        <td>
                            <button @click="deleteVendor(value.id)" type="button"
                                    class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <pagination :pageData="vendors"></pagination>

            <div class="row">
                <actualizar-proveedor></actualizar-proveedor>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import axios from "axios";
import mixin from "../../mixin.mjs";
import UpdateVendor from "./ActualizarProveedor.vue";
import Pagination from "../pagination/pagination.vue";
import ActualizarProveedor from "@/components/proveedor/ActualizarProveedor.vue";

export default {
    mixins: [mixin],

    components: {
        ActualizarProveedor,
        "update-vendor": UpdateVendor,
        pagination: Pagination,
    },

    data() {
        return {
            proveedores: [],
            nombre: "",
            email: "",
            telefono: "",
            isLoading: true,
        };
    },
    created() {
        var _this = this;
        this.getData();

        EventBus.$on("proveedor-creado", function () {
            window.history.pushState({}, null, location.pathname);
            _this.getData();
        });
    },

    methods: {
        getData(page = 1) {
            this.isLoading = true;
            axios
                .get(
                    base_url +
                    "proveedor-lista?page=" +
                    page +
                    "&nombre=" +
                    this.nombre +
                    "&email=" +
                    this.email +
                    "&telefono=" +
                    this.telefono
                )
                .then((response) => {
                    this.proveedores = response.data;
                    this.isLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // edit vendor

        editVendor(id) {
            EventBus.$emit("proveedor-edit", id);
        },

        // delete vendor

        deleteVendor(id) {
            Swal(
                {
                    title: "¿Estás seguro?",
                    text: "¡No podrás revertir esto!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "¡Sí, eliminar!",
                },
                () => { }
            ).then((result) => {
                if (result.value) {
                    axios.get(base_url + "proveedor/delete/" + id).then((res) => {
                        EventBus.$emit("proveedor-creado", 1);
                        this.successALert(res.data);
                    });
                }
            });
        },

        pageClicked(pageNo) {
            var vm = this;
            vm.getData(pageNo);
        },
    },

    computed: {},
};
</script>
