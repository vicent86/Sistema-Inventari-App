<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form @submit.prevent="register">
                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nombre') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" v-model="name" required autofocus>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Correo Electronico') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-end">{{ __('Confirma Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control" v-model="password_confirmation" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                                <div class="col-md-6">
                                    <select id="role" class="form-control" v-model="role" required>
                                        <option disabled value="">{{ __('Seleccione un rol') }}</option>
                                        <option value="admin">Admin</option>
                                        <option value="gerente">Gerente</option>
                                        <option value="empleado">Empleado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import __ from "lodash/fp/__";

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            role: ''
        }
    },
    methods: {
        __,
        register() {
            // Aquí puedes agregar la lógica para registrarse
            console.log(`Registrando al usuario: ${this.name}`);
        }
    }
}
</script>

<style scoped>
/* Aquí puedes agregar tus estilos */
</style>
