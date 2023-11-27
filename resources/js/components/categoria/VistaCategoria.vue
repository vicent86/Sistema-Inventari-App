<template>
    <div class="wrap">
        <div class="body">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" class="form-control" v-on:keyup="getData" placeholder="Buscar por nombre" name
                           v-model="nombre" />
                </div>
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
            </div>
            <div class="row" v-if="isLoading">
                <h2 style="text-align:center">Cargando......</h2>
            </div>
            <div class="table-responsive" v-else>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in categorias.data" :key="index">
                        <td>{{ value.nombre }}</td>
                        <td>
                            <button @click="editCategory(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>

                        <td>
                            <button @click="deleteCategory(value.id)" type="button"
                                    class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <pagination :pageData="categorias"></pagination>

            <div class="row">
                <update-category></update-category>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";

import Updatecategory from "./ActualizarCategoria.vue";

import Pagination from "../pagination/pagination.vue";

export default {
    mixins: [mixin],

    components: {
        "update-category": Updatecategory,
        pagination: Pagination,
    },

    data() {
        return {
            categorias: [],
            nombre: "",
            isLoading: true,
        };
    },
    created() {
        var _this = this;
        this.getData();

        EventBus.$on("categoria-creada", function () {
            _this.getData();
        });
    },

    methods: {
        getData(page = 1) {
            this.isLoading = true;
            axios
                .get(base_url + "categoria-lista?page=" + page + "&name=" + this.nombre)
                .then((response) => {
                    this.categorias = response.data;
                    this.isLoading = false;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // edit vendor

        editCategory(id) {
            EventBus.$emit("categoria-edit", id);
        },

        showMessage(data) {
            if (data.status === "success") {
                toastr.success(data.message, "Success Alert", { timeOut: 500 });
            } else {
                toastr.error(data.message, "Error Alert", { timeOut: 500 });
            }
        },

        // delete vendor

        deleteCategory(id) {
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
                    axios.get(base_url + "categoria/delete/" + id).then((res) => {
                        EventBus.$emit("categoria-creada", 1);
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
