<template>
    <div class="wrap">
        <div class="row" v-if="isLoading">
            <h1 style="text-align:center">Cargando......</h1>
        </div>

        <div class="row clearfix" v-if="!isLoading">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-teal hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">contacts</i>
                    </div>
                    <div class="content">
                        <div class="text">Clientes</div>
                        <div class="number">{{ info.total_clientes }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-orange hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">people</i>
                    </div>
                    <div class="content">
                        <div class="text">Proveedores</div>
                        <div class="number">{{ info.total_proveedores }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-deep-purple hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">category</i>
                    </div>
                    <div class="content">
                        <div class="text">Productos</div>
                        <div class="number">{{ info.total_producto }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue-grey hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">receipt</i>
                    </div>
                    <div class="content">
                        <div class="text">Facturas</div>
                        <div class="number">{{ info.total_factura }}</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-indigo hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">local_mall</i>
                    </div>
                    <div class="content">
                        <div class="text">Existencia total</div>
                        <div class="number">
                            <small>{{ info.cantidad_total }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-pink hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">local_shipping</i>
                    </div>
                    <div class="content">
                        <div class="text">Existencia vendida</div>
                        <div class="number">
                            <small>{{ info.total_cantidad_vendida }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-blue hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">bar_chart</i>
                    </div>
                    <div class="content">
                        <div class="text">Existencia actual</div>
                        <div class="number">
                            <small>{{ info.total_cantidad_actual }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-deep-orange hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">payment</i>
                    </div>
                    <div class="content">
                        <div class="text">Importe vendido</div>
                        <div class="number">
                            <small>$ {{ info.total_cantidad_vendida }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-green hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">attach_money</i>
                    </div>
                    <div class="content">
                        <div class="text">Importe pagado</div>
                        <div class="number">
                            <small>$ {{ info.total_importe_pagado }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-red hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">money_off</i>
                    </div>
                    <div class="content">
                        <div class="text">Importe restante</div>
                        <div class="number">
                            <small>$ {{ info.total_restante }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-brown hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">Pagos</i>
                    </div>
                    <div class="content">
                        <div class="text">Beneficio bruto</div>
                        <div class="number">
                            <small>$ {{ info.total_beneficio_bruto }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="info-box bg-cyan hover-zoom-effect">
                    <div class="icon">
                        <i class="material-icons">money</i>
                    </div>
                    <div class="content">
                        <div class="text">Beneficio neto</div>
                        <div class="number">
                            <small>$ {{ info.total_beneficio_neto }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { base_url } from "./config.js";
export default {
    data() {
        return {
            info: {},
            isLoading: true,
            total_clientes: 0,
            total_proveedores : 0,
            total_producto : 0,
            total_factura : 0,
            cantidad_total : 0,
            cantidad_vendida : 0,
            total_cantidad_vendida : 0,
            cantidad_actual : 0,
            total_cantidad_actual : 0,
            total_importe_pagado : 0,
            total_restante : 0,
            total_beneficio_bruto :  0,
            total_beneficio_neto : 0
        };
    },

    created() {
        this.getData();
    },
    methods: {
        getData() {
            axios.get(base_url + "info-box").then((response) => {
                this.info = response.data;
                this.isLoading = false;
            });
        },
    },
};
</script>
