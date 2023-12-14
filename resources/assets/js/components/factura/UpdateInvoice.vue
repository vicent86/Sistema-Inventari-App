<template>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div v-show="factura_estado" class="card">
            <div class="header">
                <h2 class="pull-left">Actualizar Factura</h2>

                <h2 class="pull-right">
                    <a
                        href=""
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
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <select
                                        class="form-control"
                                        v-model="factura.cliente_id"
                                    >
                                        <option value="">Cliente Lista</option>

                                        <option
                                            v-for="cliente in clientes"
                                            :value="cliente.id"
                                            :key="cliente"
                                        >
                                            {{ cliente.nombre }}
                                        </option>
                                    </select>
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty('cliente_id')
                                        "
                                    >
                                        {{
                                            errors.hasOwnProperty("cliente_id")
                                                ? errors.customer_id[0]
                                                : ""
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <p>Factura Nº</p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <input
                                        class="form-control"
                                        type="text"
                                        disabled
                                        name=""
                                        v-model="factura.factura_no"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <p>Fecha Factura</p>
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="material-icons">person</i>
                                </span>
                                <div class="form-line">
                                    <vue3-datepicker
                                        :input-class="'form-control'"
                                        :format="'yyyy-MM-dd'"
                                        value-format="yyyy-MM-dd"
                                        v-model="factura.fecha_factura"
                                    ></vue3-datepicker>
                                    <span
                                        class="requiredField"
                                        v-if="
                                            errors.hasOwnProperty(
                                                'fecha_factura'
                                            )
                                        "
                                    >
                                        {{
                                            errors.hasOwnProperty(
                                                "fecha_factura"
                                            )
                                                ? errors.fecha_factura[0]
                                                : ""
                                        }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- main invoice part  -->

                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-bordered table-condensed">
                                <thead class="bg-teal">
                                <tr>
                                    <th>#</th>
                                    <th>Categoria</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio</th>
                                    <th>Descuenmto</th>
                                    <th>Tipo Descuento</th>
                                    <th>Total</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr
                                    v-for="(vl, index) in factura.producto"
                                    :key="vl"
                                >
                                    <td>
                                        <a
                                            href=""
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
                                        <select
                                            class="form-control"
                                            v-model="
                                                    factura.producto[index]
                                                        .categoria
                                                "
                                            @change="findProduct(index)"
                                        >
                                            <option value="">
                                                Selecciona Categoria
                                            </option>
                                            <option
                                                v-for="(
                                                        value, index
                                                    ) in categorias"
                                                :value="value.id"
                                                :key="index"
                                            >
                                                {{ value.nombre }}
                                            </option>
                                        </select>
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
                                        <select
                                            class="form-control"
                                            v-model="
                                                    factura.producto[index]
                                                        .producto_id
                                                "
                                            @change="findStock(index)"
                                        >
                                            <option value="">
                                                Selecciona Producto
                                            </option>

                                            <option
                                                v-for="pr in vl.productos"
                                                :value="pr.id"
                                                :key="pr"
                                            >
                                                {{ pr.nombre }}
                                            </option>
                                        </select>
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
                                        <input
                                            class="form-control"
                                            type="number"
                                            name=""
                                            v-model="
                                                    factura.producto[index]
                                                        .cantidad
                                                "
                                            placeholder="QTY"
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
                                            name=""
                                            v-model="factura.producto[index].precio"
                                            placeholder="price"
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
                                            name=""
                                            placeholder="Total"
                                            disabled=""
                                            :value="
                                                    (vl.total_precio =
                                                        vl.cantidad * vl.precio -
                                                        vl.importe_descuento)
                                                "
                                        />
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <a
                                    href=""
                                    @click.prevent="addmore"
                                    class="btn bg-teal"
                                >+ Añadir Mas</a
                                >
                            </div>
                        </div>
                    </div>

                    <!-- main invoice part  -->

                    <div class="row">
                        <div class="col-md-8"></div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Total Precio: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            (factura.total_importe =
                                                totalAmount + totalDiscount)
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Total Descuento: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            (factura.total_descuento = totalDiscount)
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Importe Pago Neto: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            (factura.totalidad = totalAmount)
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Importe Pago: &nbsp;</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon"></div>

                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="factura.importe_pago"
                                        placeholder="Pay Now"
                                        style="border-bottom: 1px solid #ccc"
                                        disabled=""
                                    />
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Due Importe</label>
                                <div class="input-group focused">
                                    <div class="input-group-addon">$</div>
                                    <label>{{
                                            factura.totalidad -
                                            factura.importe_pago
                                        }}</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn bg-teal">
                                    Submit
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
import {base_url} from "../panel/config";

export default {
    props: ["categorias", "clientes"],
    mixins: [mixin],

    components: {
        "vue3-datepicker": Datepicker,
    },

    data() {
        return {
            factura: {
                factura_no: "",
                cliente_id: "",
                fecha_factura: "",
                total_descuento: 0,
                total_importe: 0,
                totalidad: 0,
                importe_pago: 0,
                producto: [
                    {
                        categoria: "",
                        producto_id: "",
                        stock_cantidad: 0,
                        cantidad: 0,
                        precio: 0,
                        total_precio: 0,
                        descuento: 0,
                        tipo_descuento: 1,
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

    created() {
        var _this = this;
        EventBus.$on("edit-invoice", function (id) {
            _this.editData(id);
            _this.factura_estado = true;

            window.scrollTo(0, 0);
        });
    },

    methods: {
        // finding the data which have to be edit
        editData(id) {
            axios
                .get(base_url + "factura/" + id + "/edit")

                .then((response) => {
                    this.factura = response.data;
                });
        },

        // submit update data

        store() {
            axios
                .post(
                    base_url + "factura/update/" + this.factura.factura_no,
                    this.factura
                )
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

        // new product finding from database

        findProduct(index) {
            if (this.factura.producto[index].categoria === "") {
                this.factura.producto[index].productos = [];
            } else {
                axios
                    .get(
                        base_url +
                        "categoria/producto/" +
                        this.factura.producto[index].categoria
                    )
                    .then((response) => {
                        this.factura.producto[index].productos = response.data;
                        this.factura.producto[index].stocks = [];
                    });
            }
        },

        // find stcok according to product

        findStock(index) {
            if (this.factura.producto[index].producto_id === "") {
                this.factura.producto[index].stocks = [];
            } else {
                axios
                    .get(
                        base_url +
                        "factura-lista/factura/" +
                        this.factura.producto[index].producto_id
                    )
                    .then((response) => {
                        this.factura.producto[index].stocks = response.data;
                    });
            }
        },

        findStockDetails(index) {
            if (this.factura.producto[index].producto_id === "") {
                this.factura.producto[index].cantidad = 0;
                this.factura.producto[index].precio = 0;
                this.factura.producto[index].descuento = 0;
            } else {
                axios
                    .get(
                        base_url +
                        "stock/" +
                        this.factura.producto[index].producto_id
                    )
                    .then((response) => {
                        this.factura.producto[index].cantidad = 1;
                        this.factura.producto[index].precio =
                            response.data.precio;
                        this.factura.product[index].descuento =
                            response.data.descuento;
                        this.factura.product[index].stock_cantidad =
                            response.data.stock_cantidad;
                    });
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
                cantidad: 0,
                precio: 0,
                total_precio: 0,
                descuento: 0,
                tipo_descuento: 1,
                importe_descuento: 0,
                productos: [],
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
                cliente_id: "",
                fecha_factura: "",
                total_descuento: 0,
                total_importe: 0,
                totalidad: 0,
                importe_pago: 0,
                producto: [
                    {
                        categoria: "",
                        producto_id: "",
                        stock_cantidad: 0,
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

        discount(type, discount, main_amount) {
            if (type === 2) {
                return parseFloat((discount / 100) * main_amount).toFixed(2);
            } else {
                return parseFloat(discount).toFixed(2);
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
