<template>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h2
            v-if="!factura_estado"
            style="position: absolute; margin: 18px 0 0 20px; z-index: 2"
        >
            <button @click="showInvoice" type="button" class="btn btn-primary">
                Nueva Factura
            </button>
        </h2>
        <div v-show="factura_estado" class="card">
            <div class="header" style="padding-bottom: 60px">
                <h2 class="pull-left">Crear factura</h2>

                <h2 class="pull-right">
                    <a
                        href
                        @click.prevent="showInvoice"
                        class="btn bg-red btn-circle waves-effect waves-circle waves-float"
                    >
                        <i class="material-icons">close</i>
                    </a>
                </h2>
            </div>

            <div class="body">
                <form @submit.prevent="store()">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <select
                                        class="form-control"
                                        v-model="factura.tipo_cliente"
                                    >
                                        <option value>
                                            Seleccionar cliente
                                        </option>
                                        <option :value="1">
                                            De la base de datos
                                        </option>
                                        <option :value="2">
                                            Nuevo cliente
                                        </option>
                                    </select>
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty(
                                                'tipo_cliente'
                                            )
                                        "
                                    >{{
                                            errors.hasOwnProperty(
                                                "tipo_cliente"
                                            )
                                                ? errors.tipo_cliente[0]
                                                : ""
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" v-if="factura.tipo_cliente === 1">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <multiselect
                                        v-model="factura.cliente_id"
                                        deselect-label=""
                                        track-by="id"
                                        label="nombre_cliente"
                                        open-direction="bottom"
                                        placeholder="Seleccionar cliente"
                                        :options="clientes"
                                        :allow-empty="false"
                                    >
                                    </multiselect>
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty('cliente_id')
                                        "
                                    >{{
                                            errors.hasOwnProperty("cliente_id")
                                                ? errors.cliente_id[0]
                                                : ""
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" v-if="factura.tipo_cliente === 2">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input
                                        type="text"
                                        name
                                        class="form-control"
                                        placeholder="Nombre"
                                        v-model="factura.nombre_cliente"
                                    />
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty(
                                                'nombre_cliente'
                                            )
                                        "
                                    >{{
                                            errors.hasOwnProperty(
                                                "nombre_cliente"
                                            )
                                                ? errors.nombre_cliente[0]
                                                : ""
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">email</i>
                                </span>
                                <div class="form-line">
                                    <input
                                        type="text"
                                        name
                                        class="form-control"
                                        placeholder="Correo electrónico"
                                        v-model="factura.cliente_email"
                                    />
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty(
                                                'cliente_email'
                                            )
                                        "
                                    >{{
                                            errors.hasOwnProperty(
                                                "cliente_email"
                                            )
                                                ? errors.cliente_email[0]
                                                : ""
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">phone</i>
                                </span>
                                <div class="form-line">
                                    <input
                                        type="text"
                                        name
                                        class="form-control"
                                        placeholder="Teléfono"
                                        v-model="factura.cliente_telefono"
                                    />
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty(
                                                'cliente_telefono'
                                            )
                                        "
                                    >{{
                                            errors.hasOwnProperty(
                                                "cliente_telefono"
                                            )
                                                ? errors.cliente_telefono[0]
                                                : ""
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">note</i>
                                </span>
                                <div class="form-line">
                                    <textarea
                                        rows="1"
                                        class="form-control no-resize auto-growth"
                                        placeholder="Dirección"
                                        v-model="factura.cliente_direccion"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <p>Número de factura</p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input
                                        class="form-control"
                                        type="text"
                                        disabled
                                        name
                                        v-model="factura.factura_no"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <p>Fecha de la factura</p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <vuejs-datepicker
                                        :input-class="'form-control'"
                                        :format="'yyyy-MM-dd'"
                                        value-format="yyyy-MM-dd"
                                        v-model="factura.factura_fecha"
                                    ></vuejs-datepicker>
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty(
                                                'ifactura_fecha'
                                            )
                                        "
                                    >{{
                                            errors.hasOwnProperty(
                                                "factura_fecha"
                                            )
                                                ? errors.factura_fecha[0]
                                                : ""
                                        }}</span
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="table-responsive">
                            <table
                                class="table table-bordered table-condensed"
                                style="min-height: 200px"
                            >
                                <thead class="bg-teal">
                                <tr>
                                    <th>#</th>
                                    <th>Categoría</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Descuento</th>
                                    <th>Tipo de descuento</th>
                                    <th>Total</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr
                                    v-for="(vl, index) in factura.producto"
                                    :key="index"
                                >
                                    <td>
                                        <a
                                            href
                                            @click.prevent="
                                                    removeItem(index)
                                                "
                                            style="color: red"
                                        >
                                            <i class="material-icons"
                                            >delete</i
                                            >
                                        </a>
                                    </td>
                                    <td>
                                        <multiselect
                                            v-model="
                                                    factura.producto[index]
                                                        .categoria
                                                "
                                            deselect-label=""
                                            track-by="id"
                                            label="name"
                                            open-direction="bottom"
                                            placeholder="Selecciona categoría"
                                            :options="categorias"
                                            @input="findProduct(index)"
                                            :allow-empty="false"
                                        >
                                        </multiselect>
                                        <span
                                            v-if="
                                                    errors[
                                                        'producto.' +
                                                            index +
                                                            '.categoria'
                                                    ]
                                                "
                                            class="requiredField"
                                        >{{
                                                errors[
                                                "producto." +
                                                index +
                                                ".categoria"
                                                    ][0]
                                            }}</span
                                        >
                                    </td>

                                    <td>
                                        <multiselect
                                            v-model="
                                                    factura.producto[index]
                                                        .producto_id
                                                "
                                            deselect-label=""
                                            track-by="id"
                                            label="producto_nombre"
                                            open-direction="bottom"
                                            placeholder="Seleccionar producto"
                                            :options="
                                                    factura.producto[index]
                                                        .productos
                                                "
                                            @input="findStock(index)"
                                            :allow-empty="false"
                                        >
                                        </multiselect>
                                        <span
                                            v-if="
                                                    errors[
                                                        'producto.' +
                                                            index +
                                                            '.producto_id'
                                                    ]
                                                "
                                            class="requiredField"
                                        >{{
                                                errors[
                                                "producto." +
                                                index +
                                                ".producto_id"
                                                    ][0]
                                            }}</span
                                        >
                                    </td>

                                    <td>

                                    </td>

                                    <td>
                                        <input
                                            class="form-control"
                                            type="number"
                                            @change="new CheckStock(index) "
                                            name
                                            v-model="
                                                    factura.producto[index]
                                                        .cantidad
                                                       "
                                            placeholder="Cantidad"
                                        />

                                        <span
                                            v-if="
                                                    errors[
                                                        'producto.' +
                                                            index +
                                                            '.cantidad'
                                                    ]
                                                "
                                            class="requiredField"
                                        >{{
                                                errors[
                                                "producto." +
                                                index +
                                                ".cantidad"
                                                    ][0]
                                            }}</span
                                        >
                                    </td>

                                    <td>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name
                                            v-model="
                                                    factura.producto[index].precio
                                                "
                                            placeholder="Precio"
                                            value
                                        />

                                        <span
                                            v-if="
                                                    errors[
                                                        'producto.' +
                                                            index +
                                                            '.precio'
                                                    ]
                                                "
                                            class="requiredField"
                                        >{{
                                                errors[
                                                "producto." +
                                                index +
                                                ".precio"
                                                    ][0]
                                            }}</span
                                        >
                                    </td>

                                    <td>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name="factura.producto[index].descuento"
                                            placeholder="Descuento"
                                        />

                                        <span
                                            v-if="
                                                    errors[
                                                        'producto.' +
                                                            index +
                                                            '.descuento'
                                                    ]
                                                "
                                            class="requiredField"
                                        >{{
                                                errors[
                                                "producto." +
                                                index +
                                                ".descuento"
                                                    ][0]
                                            }}</span
                                        >
                                    </td>

                                    <td>
                                        <select
                                            class="form-control"
                                            v-model="
                                                    factura.producto[index]
                                                        .tipo_descuento
                                                "
                                        >
                                            <option value="1">
                                                Importe
                                            </option>
                                            <option value="2">%</option>
                                        </select>
                                    </td>

                                    <!-- for getting discount amount  -->
                                    <input
                                        type="hidden"
                                        :value="
                                                (vl.importe_descuento = discount(
                                                    factura.producto[index]
                                                        .tipo_descuento,
                                                    factura.producto[index]
                                                        .descuento,
                                                    vl.total_precio
                                                ))
                                            "
                                    />

                                    <td>
                                        <input
                                            class="form-control"
                                            type="text"
                                            name
                                            placeholder="Total"
                                            disabled
                                            :value="
                                                    (vl.total_precio =
                                                        vl.quantity * vl.price -
                                                        vl.discount_amount)
                                                "
                                        />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-12">
                                <a
                                    href
                                    @click.prevent="addmore"
                                    class="btn bg-teal"
                                >+ Añadir más</a
                                >
                            </div>
                        </div>
                    </div>

                    <!-- main invoice part  -->
                    <div class="row">
                        <div class="col-md-12" style="margin-top: 20px">
                            <div class="form-group">
                                <label>Precio total: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            (factura.total_importe =
                                                totalAmount + totalDiscount)
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Descuento total: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            (factura.total_descuento = totalDiscount)
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Importe neto por pagar: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            (factura.totalidad = totalAmount)
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Pagar ahora: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="factura.importe_pagado"
                                        placeholder="Pay Now"
                                        style="border-bottom: 1px solid #ccc"
                                    />
                                </div>
                            </div>

                            <div
                                class="form-group"
                                v-show="factura.importe_pagado > 0"
                            >
                                <label>Pagado en :</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon"></div>

                                    <select
                                        class="form-control"
                                        v-model="factura.payment_in"
                                    >
                                        <option :value="'cash'">
                                            Efectivo
                                        </option>
                                        <option :value="'banco'">Banco</option>
                                    </select>
                                </div>
                            </div>
                            <div
                                class="form-group"
                                v-if="factura.payment_in === 'banco'"
                            >
                                <label>Información de pago:</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon"></div>

                                    <textarea
                                        rows="1"
                                        class="form-control no-resize auto-growth"
                                        placeholder="Bank Information"
                                        v-model="factura.banco_info"
                                        style="border-bottom: 1px solid #ccc"
                                    ></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Importe a deber</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            factura.totalidad -
                                            factura.importe_pagado
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn bg-teal">
                                    Generar Factura
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { EventBus } from "../../vue-asset";
import axios from "axios";
import mixin from "../../mixin.mjs";
import Datepicker from "vue3-datepicker";
import Multiselect from "vue-multiselect";
import {base_url} from "../panel/config";

export default {
    props: ["categorias", "clientes"],
    mixins: [mixin],

    components: {
        "vue3-datepicker": Datepicker,
        Multiselect,
    },

    data() {
        return {
            factura: {
                factura_no: "",
                tipo_cliente: "",
                cliente_id: "",
                nombre_cliente: "",
                cliente_email: "",
                cliente_tlefono: "",
                cliente_direccion: "",
                fecha_factura: "",
                total_descuento: 0,
                total_importe: 0,
                grand_total: 0,
                totalidad: 0,
                payment_in: "cash",
                banco_info: "",
                producto: [
                    {
                        categoria: "",
                        producto_id: "",
                        stock_cantidad: 0,
                        cantidad_actual: 0,
                        cantidad: 0,
                        precio: 0,
                        total_precio: 0,
                        descuento: 0,
                        tipo_descuento: "1",
                        importe_descuento: 0,
                        productos: [],
                        stocks: [],
                    },
                ],
            },

            factura_estado: false,
            errors: {},
        };
    },

    created() {},

    methods: {
        store() {
            axios
                .post(base_url + "factura", this.factura)
                .then((response) => {
                    this.successALert(response.data);

                    this.resetForm();

                    this.factura_estado = false;

                    EventBus.$emit("invoice-created", 1);
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;

                        Swal(
                            "Oops",
                            "¡por favor complete el formulario con los datos correctos!",
                            "error"
                        );
                    } else {
                        this.successAlert(error);
                    }
                });
        },

        findProduct(index) {
            if (this.factura.producto[index].categoria === "") {
                this.factura.producto[index].productos = [];
            } else {
                axios
                    .get(
                        base_url +
                        "categoria/producto/" +
                        this.factura.producto[index].categoria.id
                    )
                    .then((response) => {
                        this.factura.producto[index].productos = response.data;
                        this.factura.producto[index].stocks = [];
                    });
            }
        },

        findStock(index) {
            if (this.factura.producto[index].producto_id === "") {
                this.factura.producto[index].stocks = [];
            } else {
                axios
                    .get(
                        base_url +
                        "stock-lista/stock/" +
                        this.factura.producto[index].producto_id.id
                    )
                    .then((response) => {
                        this.factura.producto[index].stocks = response.data;
                    });
            }
        },

        findStockDetails(index) {
            if (this.factura.producto[index].stock_cantidad === "") {
                this.factura.producto[index].cantidad = 0;
                this.factura.producto[index].precio = 0;
                this.factura.producto[index].descuento = 0;
            } else {
                axios
                    .get(
                        base_url +
                        "stock/" +
                        this.factura.producto[index].stock_cantidad
                    )
                    .then((response) => {
                        this.factura.producto[index].cantidad = 1;
                        this.factura.producto[index].precio =
                            response.data.precio;
                        this.factura.product[index].descuento =
                            response.data.descuento;
                        this.factura.producto[index].stock_cantidad =
                            response.data.stock_quantity;
                        this.factura.producto[index].cantidad_actual =
                            response.data.cantidad_actual;
                    });
            }
        },

        CheckStock(producto_index) {
            if (
                this.factura.producto[producto_index].cantidad >
                this.factura.producto[producto_index].cantidad_actual
            ) {
                this.factura.producto[producto_index].cantidad =
                    this.factura.producto[producto_index].cantidad_actual;
            }
        },

        showInvoice() {
            this.factura_estado = !this.factura_estado;

            axios.get(base_url + "get/invoice/number").then((response) => {
                this.factura.factura_no = response.data;
            });

            window.scrollTo(0, top);
        },

        addmore() {
            this.factura.producto.push({
                categoria: "",
                producto_id: "",
                stock_cantidad: 0,
                cantidad_actual: 0,
                cantidad: 0,
                precio: 0,
                total_precio: 0,
                descuento: 0,
                tipo_descuento: "1",
                importe_descuento: 0,
                productoss: [],
                stocks: [],
            });
        },

        removeItem(index) {
            var _this = this;
            if (_this.factura.producto.length > 1) {
                _this.factura.producto.splice(index, 1);
            }
        },

        resetForm() {
            this.factura = {
                factura_no: "",
                tipo_cliente: "",
                cliente_id: "",
                nombre_cliente: "",
                cliente_email: "",
                cliente_tlefono: "",
                cliente_direccion: "",
                fecha_factura: "",
                total_descuento: 0,
                total_importe: 0,
                totalidad: 0,
                importe_pago: 0,
                payment_in: "cash",
                banco__info: "",
                producto: [
                    {
                        categoria: "",
                        producto_id: "",
                        stock_cantidad: 0,
                        cantidad_actual: 0,
                        cantidad: 0,
                        precio: 0,
                        total_precio: 0,
                        descuento: 0,
                        tipo_descuento: "1",
                        importe_descuento: 0,
                        productos: [],
                        stocks: [],
                    },
                ],
            };
        },

        discount(tipo, descuento, importe_principal) {
            if (tipo === "2") {
                return parseFloat((descuento / 100) * importe_principal).toFixed(2);
            } else {
                return parseFloat(descuento).toFixed(2);
            }
        },
    },

    // end of method section

    computed: {
        totalAmount() {
            let sum = 0;
            this.factura.producto.forEach(function (item) {
                sum += item.total_precio;
            });

            return sum;
        },

        totalDiscount() {
            let sum = 0;
            this.factura.producto.forEach(function (item) {
                sum = +sum + +item.importe_descuento;
            });

            return sum;
        },
    },
};
</script>

<style type="text/css">
.requiredField {
    color: red;
}
</style>
