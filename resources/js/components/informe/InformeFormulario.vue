<template>
    <div class="row">

        <div class="col-md-4">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="type" required="" v-model="tipo_informe" v-select="tipo_informe">
                        <option :value="''">Elige el Tipo de Informe *</option>
                        <option :value="'stock'">Informe Stock</option>
                        <option :value="'sell'">Informe Vendedor</option>
                        <option :value="'profit'">Informe Beneficio</option>
                        <option :value="'due'">Informe Pendiente</option>
                        <option :value="'invoice'">Informe Factura</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group">
                <div class="form-line">
                    <vuejs-datepicker :required="true" :placeholder="'Date To *'" :name="'start_date'"
                                      :input-class="'form-control'"></vuejs-datepicker>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="input-group">
                <div class="form-line">
                    <vuejs-datepicker :required="true" :placeholder="'Date From *'" :name="'end_date'"
                                      :input-class="'form-control'"></vuejs-datepicker>
                </div>
            </div>
        </div>


        <div class="col-md-4" v-if="!isEnable">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="category_id" v-model="categoria_id" v-select="categoria_id"
                            v-on:change="findProduct">
                        <option value="">Elige Categoria (opcional)</option>
                        <option v-for="value in categoria" :value="value.id" :key="value">{{ value.nombre }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4" v-if="!isEnable">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="producto_id" v-model="producto_id" v-select="producto_id"
                            v-on:change="findStock">
                        <option value="">Elige Producto (opcional)</option>
                        <option v-for="pr in producto" :value="pr.id" :key="pr">{{ pr.producto_nombre }}</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="col-md-4" v-if="!isEnable">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="stock_id" v-model="lista_id" v-select="lista_id">
                        <option value="">Elige Comprobante (opcional)</option>
                        <option v-for="ch in lista" :value="ch.id" :key="ch">{{ ch.lista_no }}</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4" v-if="!isEnable">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="vendor_id">
                        <option value="">Elige Proveedor (opcional)</option>
                        <option v-for="vn in proveedor" :value="vn.id" :key="vn">{{ vn.nombre }}</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="customer_id">
                        <option value="">Cliente (optional)</option>
                        <option v-for="cs in cliente" :value="cs.id" :key="cs">{{ cs.cliente_nombre }}</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="input-group">
                <div class="form-line">
                    <select class="form-control select2" name="user_id">
                        <option value="">Elige Stock Entire / Vendedor (opcional)</option>
                        <option v-for="us in usuario" :value="us.id" :key="us">{{ us.nombre }}</option>
                    </select>
                </div>
            </div>
        </div>


    </div>
</template>


<script>

import Datepicker from 'vue3-datepicker';
import mixin from '../../mixin.mjs';
import axios from 'axios';

export default {
    props: ['categoria', 'usuario', 'cliente', 'proveedor'],
    components: {

        'vue3-datepicker': Datepicker,

    },
    mixins: [mixin],

    data() {

        return {

            tipo_informe: '',
            categoria_id: '',
            producto_id: '',
            lista_id: '',

            producto: [],
            lista: [],


        }

    },

    methods: {

        findProduct() {
            this.producto = [];
            axios.get(base_url + 'categoria/producto/' + this.categoria_id)
                .then(response => {

                    this.producto = response.data;

                })
        },


        findStock() {

            this.chalan = [];
            axios.get(base_url + 'factura-lista/lista/' + this.producto_id)
                .then(response => {

                    this.lista = response.data;

                })

        },



    },

    computed: {
        isEnable() {
            return this.tipo_informe === 'factura' || this.tipo_informe === 'due';

        }
    }

}

</script>
