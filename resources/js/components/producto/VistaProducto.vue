<template>
    <div class="wrap">
        <div class="body">
            <div class="row">
                <div class="col-md-6">
                    <select class="form-control select2" @change="getData" v-model="cat" v-select="cat">
                        <option value>Filtrar por categoría</option>
                        <option v-for="(value,index) in categorias" :value="value.id" :key="index">{{ value.nombre }}</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <input
                        type="text"
                        class="form-control"
                        v-on:keyup="getData"
                        placeholder="Buscar por nombre"
                        name
                        v-model="name"
                    />
                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.....</h2>
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Nombre</th>
                        <th>Detalles</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value,index) in productos.data" :key="index">
                        <td>{{ value.categoria.nombre }}</td>
                        <td>{{ value.producto_nombre }}</td>
                        <td>
                            <div
                                style="width: 650px; text-align: justify; height: 40px; white-space: normal; text-overflow: ellipsis; overflow: hidden;">{{ value.detalles }}</div>
                        </td>
                        <td>
                            <button
                                @click="editProduct(value.id)"
                                type="button"
                                class="btn bg-blue btn-circle waves-effect waves-circle waves-float"
                            >
                                <i class="material-icons">edit</i>
                            </button>
                        </td>
                        <td>
                            <button
                                @click="deleteProduct(value.id)"
                                type="button"
                                class="btn bg-pink btn-circle waves-effect waves-circle waves-float"
                            >
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <pagination :pageData="productos"></pagination>

            <div class="row">
                <actualizar-producto :cat="categorias"></actualizar-producto>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import axios from "axios";
import mixin from "../../mixin.mjs";
import UpdateProduct from "./ActualizarProducto.vue";
import Pagination from "../pagination/pagination.vue";


export default {
    props: ["categorias"],

    mixins: [mixin],

    components: {
        "actualizar-producto": UpdateProduct,
        pagination: Pagination,
    },

    data() {
        return {
            productos: [],
            nombre: "",
            categoria: "",
            isLoading: true,
        };
    },
    created() {
        var _this = this;
        this.getData();

        EventBus.$on("producto-creado", function () {
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
                    "producto-lista?page=" +
                    page +
                    "&nombre=" +
                    this.name +
                    "&categoria=" +
                    this.categoria
                )
                .then((response) => {
                    this.productos = response.data;
                    this.isLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // edit vendor

        editProduct(id) {
            EventBus.$emit("producto-edit", id);
        },

        showMessage(data) {
            if (data.status === "success") {
                toastr.success(data.message, "Success Alert", { timeOut: 500 });
            } else {
                toastr.error(data.message, "Error Alert", { timeOut: 500 });
            }
        },

        // delete vendor

        deleteProduct(id) {
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
                () => {}
            ).then((result) => {
                if (result.value) {
                    axios.get(base_url + "producto/delete/" + id).then((res) => {
                        EventBus.$emit("producto-creado", 1);

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
