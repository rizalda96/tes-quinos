<template>
    <div>
        <b-row class="d-flex justify-content-center mt-5">
            <b-col sm="5">
                <ValidationObserver v-slot="{ passes }" :slim="true">
                   <form @submit.prevent="passes(submit)">
                   <template>
                       <b-form-group
                       label-for="code"
                       label="Kode"
                       >
                       <input type="hidden" v-model="model.code">
                       <ValidationProvider
                           :rules="isNew ? 'required|min:5|codeExist' : 'required|min:5'"
                           v-slot="{ valid, errors }"
                           name="Kode"
                           :debounce="250"
                       >
                           <b-form-input
                           id="code"
                           v-model="model.code"
                           :state="errors[0] ? false : (valid ? true : null)"
                           autofocus
                           :disabled="isDetail"
                           ></b-form-input>
                           <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                       </ValidationProvider>
                       </b-form-group>
                   </template>
                   <template>
                       <b-form-group
                       label-for="fullname"
                       label="Nama"
                       >
                       <input type="hidden" v-model="model.fullname">
                       <ValidationProvider
                           rules="alpha|required|min:3"
                           v-slot="{ valid, errors }"
                           name="Nama"
                           :debounce="250"
                       >
                           <b-form-input
                           id="fullname"
                           v-model="model.fullname"
                           :state="errors[0] ? false : (valid ? true : null)"
                           autofocus
                           :disabled="isDetail"
                           ></b-form-input>
                           <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                       </ValidationProvider>
                       </b-form-group>
                   </template>
                   <template>
                       <b-form-group
                       label-for="telp"
                       label="Telp"
                       >
                       <input type="hidden" v-model="model.telp">
                       <ValidationProvider
                           rules="required|integer"
                           v-slot="{ valid, errors }"
                           name="Telp"
                           :debounce="250"
                       >
                           <b-form-input
                           id="telp"
                           v-model="model.telp"
                           :state="errors[0] ? false : (valid ? true : null)"
                           autofocus
                           :disabled="isDetail"
                           ></b-form-input>
                           <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                       </ValidationProvider>
                       </b-form-group>
                   </template>
                   <template>
                       <b-form-group
                       label-for="kota"
                       label="Kota"
                       >
                       <input type="hidden" v-model="model.kota">
                       <ValidationProvider
                           rules="required"
                           v-slot="{ valid, errors }"
                           name="Kota"
                           :debounce="250"
                       >
                           <b-form-select
                           v-model="model.kota"
                           :state="errors[0] ? false : (valid ? true : null)"
                           :disabled="isDetail"
                           :options="options"
                           ></b-form-select>
                           <b-form-invalid-feedback>{{ errors[0] }}</b-form-invalid-feedback>
                       </ValidationProvider>
                       </b-form-group>
                   </template>
                   <div class="text-right mt-4 pt-3">
                       <b-button ref="closebtn" variant="secondary" @click="$router.go(-1)">
                       kembali
                       </b-button>
                       <b-button type="submit" variant="primary">
                       simpan
                       </b-button>
                   </div>
                   </form>
               </ValidationObserver>
            </b-col>
        </b-row>
    </div>
</template>

<script>
    import { extend } from 'vee-validate'

    export default {
        name: 'student-form',
        props: {
            id: null,
            // isDetail: false
        },
        data() {
            return {
                modelName: 'id',
                model: {
                    code: null,
                    fullname: null,
                    telp: null,
                    kota: null,
                },
                options: [
                    { value: null, text: 'Please select an option' },
                    { value: 'Jakarta', text: 'Jakarta' },
                ]
            }
        },
        computed: {
            isNew() {
                return this.id === undefined || this.id === null
            },
            isDetail() {
                if (!this.isNew) {
                    let route = this.$route.path.split('/').pop()
                    if (route == 'detail') {
                        return true
                    }
                }
                return false
            }
        },
        async created() {
            await this.validateCode()
            if (!this.isNew) {
                this.fetchData(this.id)
            }
        },
        methods: {
            async submit(){
                let action = this.isNew
                ? this.$app.route('student.store')
                : this.$app.route('student.update', {
                    'id': this.$route.params
                })

                let formData = this.$app.objectToFormData(this.model)

                if (!this.isNew) {
                    formData.append('_method', 'PUT')
                }

                this.$http.post(action, formData)
                .then(response => {
                    this.$router.push({name: 'student-list'})
                    this.$root.$emit('bv::refresh::table', 'table-student')
                })

            },
            async validateCode() {
                const isCodeExist = value => {
                    let vm = this
                    return this.$http.get(
                    this.$app.route('student.validate-code', {
                        code: vm.model.code
                    })).then(response => {
                        console.log(response);
                        return response.data
                    })
                }

                extend('codeExist',
                    {
                    validate: isCodeExist,
                    message: 'Code sudah ada di database'
                    },
                )
            },
            async fetchData(params) {
                try {
                    if (!this.isNew) {
                        let { data } = await this.$http.get(
                            this.$app.route('student.show', {
                                id: params
                            })
                        )

                        this.model.code = data.data.code
                        this.model.fullname = data.data.nama
                        this.model.telp = data.data.telp
                        this.model.kota = data.data.kota

                    }
                } catch (error) {
                    console.log(error);
                }
            },
        }
    }
</script>

<style lang="scss" scoped>

</style>
