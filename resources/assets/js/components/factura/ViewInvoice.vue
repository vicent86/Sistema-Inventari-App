<template>
    <div class="wrap">
        <div class="body" style="position: relative;">
            <update-invoice :categorys="categorias" :customers="clientes"></update-invoice>
            <create-payment></create-payment>
            <view-payment></view-payment>

            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control " v-on:keyup="getData(1)" v-model="factura_id"
                           placeholder="Buscar por número de factura">
                </div>
                <div class="col-md-6">
                    <select class="form-control  select2" data-live-serach="true" @change="getData(1)" v-model="cliente_id">
                        <option value="">Todos los clientes</option>

                        <option v-for="(cliente, index) in clientes" :value="cliente.id" :key="index">{{ cliente.nombre_cliente }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                </div>

            </div>

            <div class="loading" v-if="isLoading">
                <h2 style="text-align:center">Cargando.......</h2>
            </div>

            <div class="table-responsive" v-else>

                <table class="table table-condensed table-hover table-bordered">
                    <thead>
                    <tr>
                        <th>Facturación</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Pagado</th>
                        <th>Debido</th>
                        <th>Vendido por</th>
                        <th>Pagos</th>
                        <th>Abonar</th>
                        <th>Imprimir</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(value, index) in facuras.data" :key="index">
                        <td>{{ value.id }}</td>
                        <td>{{ sellDateFormatted(value.sell_date) }}</td>
                        <td>{{ value.cliente.nombre_cliente }}</td>
                        <td>{{ value.total_importe }}</td>
                        <td>{{ value.importe_pago }}</td>
                        <td v-bind:class="{
                'text-success': value.payment_status === 1,
                'text-danger': value.payment_status === 0
              }">
                            {{ value.total_importe - value.importe_pago }}
                        </td>
                        <td>{{ value.user.nombre }}</td>


                        <td>
                            <a @click.prevent="ViewPayment(value.id)" href="" data-toggle="modal" data-target="#viewPayment"
                               class="btn bg-cyan btn-circle waves-effect waves-circle waves-float"><i
                                class="material-icons">remove_red_eye</i></a>
                        </td>
                        <td>
                            <a @click.prevent="CreatePayment(value.id)" href="" data-toggle="modal" data-target="#smallModal"
                               class="btn bg-blue-grey btn-circle waves-effect waves-circle waves-float"><i
                                class="material-icons">attach_money</i></a>
                        </td>

                        <td>

                            <a :href="url + value.id" target="_blank" type="button"
                               class="btn bg-orange btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">print</i>
                            </a>
                        </td>

                        <td>

                            <button @click="editInvoice(value.id)" type="button"
                                    class="btn bg-blue btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">edit</i>
                            </button>
                        </td>

                        <td>
                            <button @click="deleteInvoice(value.id)" type="button"
                                    class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                <i class="material-icons">delete</i>
                            </button>

                        </td>


                    </tr>

                    </tbody>

                </table>

            </div>

            <pagination :pageData="facturas"></pagination>

        </div>
    </div>
</template>

<script>
import { EventBus } from '../../vue-asset';
import mixin from '../../mixin.mjs';
import MomentMixin from '../../moment_js.mjs';
import Pagination from '../pagination/pagination.vue';
import axios from 'axios';
import Datepicker from 'vue3-datepicker';
import UpdateInvoice from './UpdateInvoice.vue';
import CreatePayment from './CreatePayment.vue';
import ViewPayment from './ViewPayment.vue';
import {base_url} from "../panel/config";


export default {

    props: ['categorias', 'clientes'],

    mixins: [mixin, MomentMixin],

    components: {
        'update-invoice': UpdateInvoice,
        'create-payment': CreatePayment,
        'view-payment': ViewPayment,
        'vue3-datepicker': Datepicker,
        'pagination': Pagination,

    },

    data() {

        return {

            factura_id: '',
            cliente_id: '',
            start_date: new Date('2023-02-03'),
            end_date: '',
            facturas: [],
            format: 'yyyy-MM-dd',
            url: base_url + 'factura/',
            isLoading: true,

        }


    },
    created() {

        var _this = this;
        this.getData();

        EventBus.$on('invoice-created', function () {
            _this.getData();
        });

    },

    methods: {

        getData(page = 1) {

            this.isLoading = true;
            axios.get(base_url + "factura-lista?page=" + page + "&cliente_id=" + this.cliente_id + "&factura_id=" + this.factura_id + "&start_date=" + this.end_date + "&end_date=" + this.start_date).then(response => {
                this.facturas = response.data;
                this.isLoading = false;

            }).catch(error => {

                console.log(error);
            })
        },


        // edit vendor

        editInvoice(id) {

            EventBus.$emit('edit-invoice', id);

        },
        // delete vendor

        deleteInvoice(id) {

            Swal({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: "Cancelar",
                confirmButtonText: '¡Sí, eliminar!'
            }, () => {

            }).then((result) => {
                if (result.value) {

                    axios.get(base_url + 'factura/delete/' + id)
                        .then(res => {

                            EventBus.$emit('invoice-created', 1);

                            this.successALert(res.data);

                        })


                }
            })


        },

        CreatePayment(id) {

            EventBus.$emit('create-payment', id);
        },

        ViewPayment(id) {

            EventBus.$emit('view-payment', id);

        },

        // this function will call from pagination components
        pageClicked(pageNo) {
            let vm = this;
            vm.getData(pageNo);
        },


    },

    computed: {



    },



}

</script>
