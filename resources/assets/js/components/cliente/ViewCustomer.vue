<template>
    <div class="wrap">
        <div class="body">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por nombre" name=""
                           v-model="nombre">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por direccion" name=""
                           v-model="direccion">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por teléfono" name=""
                           v-model="telefono">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" v-on:keyup="getData()" placeholder="Buscar por cif" name=""
                           v-model="cif">
                </div>
            </div>

            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.......</h2>
            </div>

            <div class="table-responsive" v-else>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Teléfono</th>
                        <th>Cif</th>
                        <th>Importe comprado</th>
                        <th>Importe pagado</th>
                        <th>Importe debido</th>
                        <th>Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in clientes.data" v-bind:key="index">
                        <td>{{ value.nombre_cliente }}</td>
                        <td>{{ value.direccion }}</td>
                        <td>{{ value.telefono }}</td>
                        <td>{{ value.cif }}</td>
                        <td>{{ value.importe_total }}</td>
                        <td>{{ value.total_importe_pagado }}</td>
                        <td>{{ value.importe_total - value.total_importe_pagado }}</td>
                        <td>
                            <button @click="editcustomer(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <pagination :pageData="clientes"></pagination>

            <div class="row">
                <update-customer></update-customer>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";
import axios from "axios";
import UpdateCustomer from "./UpdateCustomer.vue";
import Pagination from '../pagination/pagination.vue';

export default {
    mixins: [mixin],

    components: {
        "update-customer": UpdateCustomer,
        "pagination": Pagination,
    },

    data() {
        return {
            clientes: [],
            nombre: "",
            direccion: "",
            telefono: "",
            cif: "",
            estado: true,
            isLoading: true,
        };
    },
    created() {
        var _this = this;
        this.getData();

        EventBus.$on("customer-created", function () {
            _this.getData();
        });
    },

    methods: {
        getData(page = 1) {
            this.isLoading = true;
            axios
                .get(
                    base_url +
                    "cliente-lista?page=" +
                    page +
                    "&nombre=" +
                    this.nombre +
                    "&direccion=" +
                    this.direccion +
                    "&telefono=" +
                    this.telefono +
                    "&cif=" +
                    this.cif
                )
                .then(response => {
                    this.clientes = response.data;
                    this.isLoading = false;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        // edit vendor

        editcustomer(id) {
            EventBus.$emit("customer-edit", id);
        },

        showMessage(data) {
            if (data.status === "success") {
                toastr.success(data.message, "Success Alert", { timeOut: 500 });
            } else {
                toastr.error(data.message, "Error Alert", { timeOut: 500 });
            }
        },
        pageClicked(pageNo) {
            let vm = this;
            vm.getData(pageNo);
        }
    },

    computed: {

    }
};
</script>
