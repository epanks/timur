<template>
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link to="/">Dashboard</router-link>
            </li>
            <li class="breadcrumb-item active">Balai</li>
        </ol>

        <div class="card mb-3">
            <div class="card-header d-flex">
                <span>
                    <i class="fas fa-chart-area"></i>
                    Balai management
                </span>
                <button
                    class="btn btn-primary btn-sm ml-auto"
                    v-on:click="showNewBalaiModal"
                >
                    <span class="fa fa-plus"></span> Create New
                </button>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <td>#</td>
                        <td>Kategori</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <tr v-for="(balai,index) in dtbalai" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{balai.nmbalai}}</td>
                            
                            <td>
                                <button class="btn btn-primary btn-sm" v-on:click="editBalai(balai)">
                                    <span class="fa fa-edit"></span>
                                </button>
                                <button class="btn btn-danger btn-sm" v-on:click="deleteBalai(balai)">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal ref="newBalaiModal" hide-footer title="Add Balai">
            <div class="d-block">
                <form v-on:submit.prevent="createBalai">
                    <div class="form-group">
                        <label for="nmbalai">Enter Name</label>
                        <input
                            type="text"
                            v-model="balaiData.nmbalai"
                            class="form-control"
                            id="nmbalai"
                            placeholder="Enter Name"
                        />
                        <div class="invalid-feedback" v-if="errors.nmbalai">
                            {{ errors.nmbalai[0] }}
                        </div>
                    </div>
                    
                    <hr />
                    <div class="text-right">
                        <button
                            type="button"
                            class="btn btn-default"
                            v-on:click="hideNewBalaiModal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-check"></span> Save
                        </button>
                    </div>
                </form>
            </div>
        </b-modal>

        <b-modal ref="editBalaiModal" hide-footer title="Edit Balai">
            <div class="d-block">
                <form v-on:submit.prevent="updateBalai">
                    <div class="form-group">
                        <label for="nmbalai">Enter Name</label>
                        <input
                            type="text"
                            v-model="editBalaiData.nmbalai"
                            class="form-control"
                            id="nmbalai"
                            placeholder="Enter Name"
                        />
                        <div class="invalid-feedback" v-if="errors.nmbalai">
                            {{ errors.nmbalai[0] }}
                        </div>
                    </div>
                    <hr />
                    <div class="text-right">
                        <button
                            type="button"
                            class="btn btn-default"
                            v-on:click="hideEditBalaiModal"
                        >
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span class="fa fa-check"></span> Update
                        </button>
                    </div>
                </form>
            </div>
        </b-modal>
    </div>
</template>
<script>
import * as balaiService from "../services/balai_service";
export default {
    name: "balai",
    data() {
        return {
            dtbalai: [],
            balaiData: {                
                nmbalai: ""
            },
            editBalaiData: {},
            errors: {}
        };
    },
    mounted() {
        this.loadDtbalai();
    },
    methods: {
        loadDtbalai: async function() {
            try {
                const response = await balaiService.loadDtbalai();
                this.dtbalai = response.data.data;
            } catch (error) {
                this.flashMessage.error({
                    message: "Salah...Coba lagi ah!",
                    time: 5000
                });
            }
        },
        hideNewBalaiModal() {
            this.$refs.newBalaiModal.hide();
        },
        showNewBalaiModal() {
            this.$refs.newBalaiModal.show();
        },
        createBalai: async function() {
            let formData = new FormData();
            formData.append("nmbalai", this.balaiData.nmbalai);

            try {
                const response = await balaiService.createBalai(formData);
                this.dtbalai.unshift(response.data);
                this.hideNewBalaiModal();
                this.flashMessage.success({
                    message: "Balai stored successfully!",
                    time: 5000
                });
                this.balaiData = {
                    nmbalai: ""
                };
            } catch (error) {
                switch (error.response.status) {
                    case 422:
                        this.errors = error.response.data.errors;
                        break;

                    default:
                        this.flashMessage.error({
                            message: "Salah...Coba lagi!",
                            time: 5000
                        });
                        break;
                }
            }
        },
        deleteBalai: async function(balai) {
            if (!window.confirm(`Bener mau di hapus ${balai.nmbalai}`)) {
                return;
            }
            try {
                await balaiService.deleteBalai(balai.id);

                this.flashMessage.success({
                    message: "Balai delete successfully!",
                    time: 5000
                });

                this.dtbalai = this.dtbalai.filter(obj => {
                    return obj.id != balai.id;
                });
            } catch (error) {
                this.flashMessage.error({
                    message: error.response.data.message,
                    time: 5000
                });
            }
        },
        hideEditBalaiModal() {
            this.$refs.editBalaiModal.hide();
        },
        showEditBalaiModal() {
            this.$refs.editBalaiModal.show();
        },
        editBalai(balai) {
            this.editBalaiData = {...balai};
            this.showEditBalaiModal();
        },
        
        updateBalai: async function() {
            try {
                const formData = new FormData();
                formData.append('name', this.editBalaiData.nmbalai);
                formData.append('_method', 'put');

                const response = await balaiService.updateBalai(this.editBalaiData.id, formData);
                this.dtbalai.map(balai => {
                    if (balai.id == response.data.id) {
                        for (let key in response.data) {
                            balai[key] = response.data[key];
                        }
                    }
                });
                this.hideEditBalaiModal();
                this.flashMessage.success({
                    message: "Balai update successfully!",
                    time: 5000
                });

            } catch (error) {
                this.flashMessage.error({
                    message: error.response.data.message,
                    time: 5000
                });
            }
        }
    }
};
</script>
