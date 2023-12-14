<template>
    <div class="wrap">
        <div class="modal fade" id="update-user" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="updateUser">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="defaultModalLabel">Actualizar usuario</h4>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" v-if="errors">
                                <ul>
                                    <li v-for="error in errors" :key="error">{{ error[0] }}</li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">account_circle</i>
                    </span>
                                        <div class="form-line">
                                            <input type="text" class="form-control date" placeholder="Nombre" v-model="user.name">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                    <span class="input-group-addon">
                      <i class="material-icons">email</i>
                    </span>
                                        <div class="form-line">
                                            <input type="email" class="form-control date" placeholder="Correo electrónico" v-model="user.email">
                                        </div>
                                    </div>
                                </div>


                        <div class="modal-footer">
                            <br>
                            <button type="submit" class="btn btn-success waves-effect">Actualizar</button>
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancelar</button>
                        </div>
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
import mixin from "../../mixin.mjs";
import axios from "axios";
import {base_url} from "../panel/config";

export default {
    mixins: [mixin],

    data() {
        return {
            user: {
                id: '',
                name: "",
                email: "",

            },



            errors: null
        };
    },

    created() {
        const _this = this;
        EventBus.$on("user-edit", function (id) {
            _this.id = id;
            _this.findUser(id);
            //$('#update-user').modal('show');
        });
    },

    // mounted() {
    //     this.roleList();
    // },

    methods: {
        findUser(id) {
            axios
                .get(base_url + "user/" + id + "/edit")

                .then(response => {
                    this.user = {
                        id: response.data.id,
                        name: response.data.name,
                        email: response.data.email,

                    };
                });
        },

        updateUser() {
            axios
                .post(base_url + "user/update/" + this.user.id, this.user)

                .then(response => {
                    $("#update-user").modal("hide");

                    this.user = {
                        id: "",
                        name: "",
                        email: "",

                    };

                    this.errors = null;
                    EventBus.$emit("user-created", 1);
                    this.successALert(response.data);
                })
                .catch(err => {
                    if (err.response) {
                        this.errors = err.response.data.errors;
                    }
                });
        },

        // roleList() {
        //     axios.get(base_url + "role-list").then(response => {
        //         this.role_list = response.data;
        //     });
        // }
    },

    // end of method section

};
</script>
