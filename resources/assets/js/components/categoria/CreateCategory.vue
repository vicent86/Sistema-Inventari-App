<template>
    <div class="wrap">
        <div class="modal fade" id="create-category" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Información de Categoría</h4>
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
                      <i class="material-icons">Categoria</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="categoria.nombre" />
                                        </div>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Descripcion" v-model="categoria.descripcion" />
                                        </div>
                                        <div class="form-line">
                                            <label>Estado:</label>
                                            <input type="checkbox" v-model="categoria.estado" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <br />
                        <button @click="createCategory" type="button" class="btn btn-success waves-effect">Guardar</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import  EventBus  from "../../vue-asset";
import mixin from "../../mixin.mjs";
import {base_url} from "../panel/config";

export default {
    mixins: [mixin],

    data() {
        return {
            categoria: {
                nombre: "",
                descripcion:"",
                estado: true,
            },

            errors: null,
        };
    },

    methods: {
        createCategory() {
            axios
                .post(base_url + "categoria", this.categoria)

                .then((response) => {
                   //$("#create-category").modal("hide");

                    this.categoria = { nombre: "", descripcion: "", estado: true };
                    this.errors = null;
                    EventBus.$emit("category-created", response.data);

                    this.successALert(response.data);
                })
                .catch((err) => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },
    },

    // end of method section

    created() { },
};
</script>
