<template>
    <div class="wrap">
        <div class="modal fade" id="smallModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="alert alert-danger" v-if="errors">
                        <ul>
                            <li v-for="error in errors" :key="error">
                                {{ error[0] }}
                            </li>
                        </ul>
                    </div>

                    <form @submit.prevent="Payment()">
                        <div class="modal-header">
                            <h4 class="modal-title" id="CreatePayment">
                                Pago de factura N° : {{ pago.id }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-inline">
                                <p>Fecha</p>

                                <vuejs-datepicker
                                    :input-class="'width form-control'"
                                    :format="'yyyy-MM-dd'"
                                    v-model="pago.fecha_pago"
                                ></vuejs-datepicker>
                            </div>

                            <div class="form-inline" style="margin-top: 10px">
                                <p>Importe</p>
                                <input
                                    style="width: 100%"
                                    type="text"
                                    class="form-control"
                                    name=""
                                    placeholder="Importe"
                                    v-model="pago.importe_pago"
                                />
                            </div>

                            <div class="form-inline" style="margin-top: 10px">
                                <p>Pagado en</p>
                                <select
                                    class="form-control"
                                    style="width: 100%"
                                    v-model="pago.pago_in"
                                >
                                    <option :value="'efectivo'">
                                        Efectivo
                                    </option>
                                    <option :value="'banco'">Banco</option>
                                </select>
                            </div>

                            <div
                                class="form-inline"
                                style="margin-top: 10px"
                                v-if="pago.pago_in === 'banco'"
                            >
                                <p>Información Bancaria</p>
                                <textarea
                                    placeholder="Información Bancaria"
                                    style="width: 100%"
                                    v-model="pago.banco_info"
                                ></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="submit"
                                class="btn bg-teal waves-effect"
                            >
                                Guardar
                            </button>
                            <button
                                type="button"
                                class="btn btn-link waves-effect"
                                data-dismiss="modal"
                            >
                                Cerrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
import { EventBus } from "../../vue-asset";
import mixin from "../../mixin.mjs";
import Datepicker from "vue3-datepicker";
import axios from "axios";

export default {
    name: "crear-pago",
    mixins: [mixin],

    components: {
        "vue3-datepicker": Datepicker,
    },

    data() {
        return {
            pago: {
                id: "",
                importe_pago: 0,
                fecha_pago: "",
                pago_in: "efectivo",
                banco_info: "",
            },

            errors: null,
        };
    },

    created() {
        let vm = this;
        EventBus.$on("crear-pago", function (id) {
            vm.pago.id = id;
        });
    },

    methods: {
        Payment() {
            axios
                .post(base_url + "pago", this.pago)
                .then((response) => {
                    this.successALert(response.data);
                    this.resetForm();

                    $("#smallModal").modal("hide");

                    EventBus.$emit("factura-creada", 1);
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
                        this.successALert(error);
                    }
                });
        },

        resetForm() {
            this.pago = {
                id: "",
                importe_pago: 0,
                fecha_pago: "",
                pago_in: "efectivo",
                banco_info: "",
            };
        },
    },
};
</script>

<style type="text/css">
.width {
    width: 100% !important;
}
</style>
