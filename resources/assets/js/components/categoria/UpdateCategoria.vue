<template>
    <div class="col-md-12">
        <div class="modal fade" id="update-category" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="defaultModalLabel">Actualizar Información de la Categoría</h4>
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
											<i class="material-icons">categoria</i>
										</span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="categoria.nombre">
                                            <input type="text" class="form-control date" placeholder="Descripcion" v-model="categoria.descripcion">
                                            <div class="form-line">
                                                <label>Estado:</label>
                                                <input type="checkbox" v-model="categoria.estado" />
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>


                        </form>

                    </div>
                    <div class="modal-footer">
                        <br>
                        <button @click="updatecategory(categoria.id)" type="button"
                                class="btn btn-success waves-effect">Actualizar</button>
                        <button @click="closeModal()" type="button" class="btn btn-default waves-effect"
                                data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { EventBus } from '../../vue-asset';
import mixin from '../../mixin.mjs';


export default {

    name: 'update-category',

    mixins: [mixin],

    data() {

        return {

            categoria: {

                id: 0,
                nombre: '',
                descripcion: '',
                estado: true,

            },

            errors: null

        }

    },

    created() {

        let vm = this;

        EventBus.$on('category-edit', function (id) {

            vm.categoria.id = id;

            vm.editcategory(id);

            $('#update-category').modal('show');

        });

        $('#update-category').on('hidden.bs.modal', function () {
            vm.closeModal();
        });



    },

    methods: {

        editcategory(id) {

            axios.get(base_url + 'categoria/' + id + '/edit')

                .then(response => {


                    this.categoria = {
                        id: response.data.id,
                        nombre: response.data.nombre,
                        descripcion: response.data.descripcion,
                        estado: response.data.estado,
                    }

                })

        },
        updatecategory(id) {

            axios.post(base_url + 'categoria/update/' + id, this.categoria)
                .then(res => {

                    if (res.data.status === 'success') {

                        this.successALert(res.data);
                        EventBus.$emit('category-created', 1);
                        this.closeModal();
                        $('#update-category').modal('hide');
                    }



                })
                .catch(err => {

                    if (err.response) {

                        this.errors = err.response.data.errors;
                    }
                })

        },



        closeModal() {

            this.errors = null;
            this.categoria = { 'id': 0, 'nombre': '' , 'descripcion': '', 'estado': true };
            EventBus.$emit('category-created', 1);
        }




    }

}

</script>
