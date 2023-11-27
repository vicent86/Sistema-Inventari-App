<template>

    <div class="col-md-12">
        <div class="modal fade" id="edit-qty" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar cantidad de {{ producto.producto_nombre }}- {{ producto.lista_no }}</h4>
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
                                    <div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">palette</i>
										</span>
                                        <div class="form-line">
                                            <select class="form-control" v-model="producto.estado">
                                                <option :value="''">¿Tú quieres?</option>
                                                <option :value="'+'">+</option>
                                                <option :value="'-'">-</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="input-group">
										<span class="input-group-addon">
											<i class="material-icons">palette</i>
										</span>
                                        <div class="form-line">
                                            <input type="number" class="form-control date" placeholder="Cantidad para actualizar" v-model="producto.new_qty">
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </form>

                    </div>
                    <div class="modal-footer">
                        <br>
                        <button @click="updateproduct()" type="button" class="btn btn-success waves-effect">Actualizar</button>
                        <button @click="closeModal()" type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>

import {EventBus} from '../../vue-asset';
import mixin from '../../mixin.mjs';
import axios from 'axios';

export default{

    name : 'actualizar-cantidad',

    mixins:[mixin],

    data(){

        return{

            product : {

                id : 0,
                cantidad_actual : 0,
                new_qty : 0,
                estado : '',
                producto_nombre : '',
                lista_no : '',

            },

            errors : null

        }

    },

    created(){

        let vm = this;

        EventBus.$on('edit-cantidad',function(id){

            vm.producto.id = id;

            vm.editproduct(id);

            $('#edit-qty').modal('show');

        });

        $('#edit-qty').on('hidden.bs.modal', function(){
            vm.closeModal();
        });



    },

    methods : {




        editproduct(id){

            axios.get(base_url+'stock/'+id+'/edit')

                .then(response => {


                    this.producto = {
                        id:response.data.id,
                        producto_nombre:response.data.producto.producto_nombre,
                        cantidad_actual:response.data.cantidad_actual,
                        lista_no:response.data.lista_no,
                    }

                })

        },
        updateproduct(){

            axios.post(base_url+'stock-update',this.product)
                .then(res => {

                    this.successALert(res.data);
                    EventBus.$emit('stock-creado',1);
                    this.closeModal();
                    $('#edit-qty').modal('hide');



                })
                .catch(err => {

                    if(err.response){

                        this.errors = err.response.data.errors;
                    }
                })

        },



        closeModal(){

            this.errors = null;
            this.product = {'id':0,'name':''};
            EventBus.$emit('stock-creado',1);
        }




    }

}



</script>
