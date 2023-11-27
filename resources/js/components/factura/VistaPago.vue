<template>
    <div class="row">

        <div class="modal fade" id="viewPayment" tabindex="-1" role="dialog" ref="vuemodal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h4 class="modal-title" id="CreatePayment">Pagos de factura N° : {{ id }}  <br> Cliente : {{ factura.cliente.cliente_nombre }} </h4>
                    </div>
                    <div class="modal-body">

                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Importe</th>
                                    <th>Pago con</th>
                                    <th>Informacion</th>
                                    <th>Recibido por</th>
                                    <th>Eliminar</th>
                                </tr>


                                </thead>

                                <tbody>
                                <tr v-for="pago in pagos" :key="pago">
                                    <td>{{ sellDateFormatted(pago.date) }}</td>
                                    <td>{{ pago.importe }}</td>
                                    <td>{{ pagot.pago_in }}</td>
                                    <td>{{ pago.banco_info }}</td>
                                    <td>{{ pago.usuario.nombre }}</td>
                                    <td>
                                        <button @click="deletePayment(pago.id)" type="button" class="btn bg-pink btn-circle waves-effect waves-circle waves-float">
                                            <i class="material-icons">delete</i>
                                        </button> </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <p>Total a pagar</p>
                                    <input type="text" name="" disabled="" :value="factura.total_importe">
                                </div>

                                <div class="form-group">
                                    <p>Total pagado</p>
                                    <input type="text" name="" disabled="" :value="importeTotal">
                                </div>

                                <div class="form-group">
                                    <p>Importe total a pagar</p>
                                    <input type="text" name="" disabled="" :value="factura.total_importe-importeTotal">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button @click="closeModal" type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cerrar</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {EventBus} from '../../vue-asset';
import mixin from '../../mixin.mjs';
import MomentMixin from '../../moment_mixin.mjs';

export default{

    name : 'vista-pago',
    mixins : [mixin,MomentMixin],

    data(){

        return {

            id : '',

            factura :	{
                id	: '',
                usuario_id	: '',
                cliente_id	: '',
                total_importe : 0,
                importe_pagado : 0,

                cliente : {
                    id : '',
                    cliente_nombre : '',
                },
            },


            pagos : [],
            total_pagado : 0,
        }
    },

    created(){

        var  _this = this;

        EventBus.$on('vista-pago',function(id){
            _this.id = id;
            _this.getPayment(id);

        });

    },


    mounted() {

        var _this = this;
        $("#viewPayment").on('hidden.bs.modal', function(){

            _this.closeModal()
        });
    },

    methods : {

        getPayment(id){

            axios.get(base_url+'pago/'+id)
                .then(response => {

                    this.pagos = response.data.pago;
                    this.factura = response.data.invoice;

                })

                .catch(error => {

                    console.log(error);

                });


        },

        deletePayment(id){

            Swal({
                title: '¿Estás seguro?',
                text: '¡No podrás revertir esto!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: '¡Sí, eliminar!'
            },() => {
            }).then((result) => {
                if (result.value) {

                    axios.get(base_url+'pago/delete/'+id)
                        .then(res => {
                            this.getPayment(this.id);
                            this.successALert(res.data);
                        })


                }
            })


        },

        closeModal(){

            EventBus.$emit('factura-creada',1);

        }

    },

    computed : {

        importeTotal(){
            let sum = 0;
            this.pagos.forEach(function(item) {
                sum += item.importe;
            });

            return sum;

        },
    }



}

</script>
