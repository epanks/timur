<template>
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <router-link to="/">Dashboard</router-link>
            </li>
            <li class="breadcrumb-item active">Paket</li>
        </ol>

        <div class="card mb-3">
            <div class="card-header d-flex">
                <span>
                    <i class="fas fa-chart-area"></i>
                    Paket management
                </span>
                <button
                    class="btn btn-primary btn-sm ml-auto"
                    v-on:click="showNewPaketModal"
                >
                    <span class="fa fa-plus"></span> Create New
                </button>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <td>#</td>
                        <td>Nama Paket</td>
                        <td>Pagu</td>
                        <td>Image</td>
                        <td>Action</td>
                    </thead>
                    <tbody>
                        <tr v-for="(paket,index) in dtpaket" :key="index">
                            <td>{{index+1}}</td>
                            <td>{{paket.nmpaket}}</td>
                            <td>{{paket.pagurmp}}</td>
                            <td>
                                <!-- <img
                                    :src="
                                        `${$store.state.serverPath}/storage/${paket.image}`
                                    "
                                    alt="paket.image"
                                    class="table-image"
                                /> -->
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" v-on:click="editPaket(paket)">
                                    <span class="fa fa-edit"></span>
                                </button>
                                <button class="btn btn-danger btn-sm" v-on:click="deletePaket(paket)">
                                    <span class="fa fa-trash"></span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <b-modal ref="newPaketModal" hide-footer title="Add Paket">
            <div class="d-block">
                <form v-on:submit.prevent="createPaket">
                    <div class="form-group">
                        <label for="nmpaket">Enter Name</label>
                        <input
                            type="text"
                            v-model="paketData.nmpaket"
                            class="form-control"
                            id="nmpaket"
                            placeholder="Enter Name"
                        />
                        <div class="invalid-feedback" v-if="errors.nmpaket">
                            {{ errors.nmpaket[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pagurmp">Pagu</label>
                        <input
                            type="number"
                            v-model="paketData.pagurmp"
                            class="form-control"
                            id="pagurmp"
                            placeholder="Enter Pagu"
                        />
                        <div class="invalid-feedback" v-if="errors.pagurmp">
                            {{ errors.pagurmp[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Choose an image</label>
                        <div v-if="paketData.image.name">
                            <img
                                src=""
                                ref="newPaketImageDisplay"
                                class="w-150px"
                            />
                        </div>
                        <input
                            type="file"
                            v-on:change="attachImage"
                            ref="newPaketImage"
                            class="form-control"
                            id="image"
                        />
                        <div class="invalid-feedback" v-if="errors.image">
                            {{ errors.image[0] }}
                        </div>
                    </div>
                    <hr />
                    <div class="text-right">
                        <button
                            type="button"
                            class="btn btn-default"
                            v-on:click="hideNewPaketModal"
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

        <b-modal ref="editPaketModal" hide-footer title="Edit Paket">
            <div class="d-block">
                <form v-on:submit.prevent="updatePaket">
                    <div class="form-group">
                        <label for="nmpaket">Enter Nama Paket</label>
                        <input
                            type="text"
                            v-model="editPaketData.nmpaket"
                            class="form-control"
                            id="nmpaket"
                            placeholder="Enter Nama Paket"
                        />
                        <div class="invalid-feedback" v-if="errors.nmpaket">
                            {{ errors.nmpaket[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pagurmp">Enter Pagu</label>
                        <input
                            type="text"
                            v-model="editPaketData.pagurmp"
                            class="form-control"
                            id="pagurmp"
                            placeholder="Enter Pagu"
                        />
                        <div class="invalid-feedback" v-if="errors.pagurmp">
                            {{ errors.pagurmp[0] }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image">Choose an image</label>
                        <div>
                            <img
                                :src="`${$store.state.serverPath}/storage/${editPaketData.image}`"
                                ref="editPaketImageDisplay"
                                class="w-150px"
                            />
                        </div>
                        <input
                            type="file"
                            v-on:change="editAttachImage"
                            ref="editPaketImage"
                            class="form-control"
                            id="image"
                        />
                        <div class="invalid-feedback" v-if="errors.image">
                            {{ errors.image[0] }}
                        </div>
                    </div>
                    <hr />
                    <div class="text-right">
                        <button
                            type="button"
                            class="btn btn-default"
                            v-on:click="hideEditPaketModal"
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
import * as paketService from "../services/paket_service";
export default {
    name: "paket",
    data() {
        return {
            dtpaket: [],
            paketData: {                
                nmpaket: "",
                pagurmp: "",
                image: ""
            },
            editPaketData: {},
            errors: {}
        };
    },
    mounted() {
        this.loadDtpaket();
    },
    methods: {
        loadDtpaket: async function() {
            try {
                const response = await paketService.loadDtpaket();
                this.dtpaket = response.data.data;
            } catch (error) {
                this.flashMessage.error({
                    message: "Salah...Coba lagi ahuuuu!",
                    time: 5000
                });
            }
        },
        attachImage() {
            this.paketData.image = this.$refs.newPaketImage.files[0];
            let reader = new FileReader();
            reader.addEventListener(
                "load",
                function() {
                    this.$refs.newPaketImageDisplay.src = reader.result;
                }.bind(this),
                false
            );
            reader.readAsDataURL(this.paketData.image);
        },
        hideNewPaketModal() {
            this.$refs.newPaketModal.hide();
        },
        showNewPaketModal() {
            this.$refs.newPaketModal.show();
        },
        createPaket: async function() {
            let formData = new FormData();
            formData.append("nmpaket", this.paketData.nmpaket);
            formData.append("pagurmp", this.paketData.pagurmp);
            formData.append("image", this.paketData.image);

            try {
                const response = await paketService.createPaket(formData);
                this.dtpaket.unshift(response.data);
                this.hideNewPaketModal();
                this.flashMessage.success({
                    message: "Paket stored successfully!",
                    time: 5000
                });
                this.paketData = {
                    nmpaket: "",
                    pagurmp: "",
                    image: ""
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
        deletePaket: async function(paket) {
            if (!window.confirm(`Bener mau di hapus ${paket.nmpaket}`)) {
                return;
            }
            try {
                await paketService.deletePaket(paket.id);

                this.flashMessage.success({
                    message: "Paket delete successfully!",
                    time: 5000
                });

                this.dtpaket = this.dtpaket.filter(obj => {
                    return obj.id != paket.id;
                });
            } catch (error) {
                this.flashMessage.error({
                    message: error.response.data.message,
                    time: 5000
                });
            }
        },
        hideEditPaketModal() {
            this.$refs.editPaketModal.hide();
        },
        showEditPaketModal() {
            this.$refs.editPaketModal.show();
        },
        editPaket(paket) {
            this.editPaketData = {...paket};
            this.showEditPaketModal();
        },
        editAttachImage() {
            this.editPaketData.image = this.$refs.editPaketImage.files[0];
            let reader = new FileReader();
            reader.addEventListener(
                "load",
                function() {
                    this.$refs.editPaketImageDisplay.src = reader.result;
                }.bind(this),
                false
            );
            reader.readAsDataURL(this.editPaketData.image);
        },
        updatePaket: async function() {
            try {
                const formData = new FormData();
                formData.append('nmpaket', this.editPaketData.nmpaket);
                formData.append('pagurmp', this.editPaketData.pagurmp);
                formData.append('image', this.editPaketData.image);
                formData.append('_method', 'put');

                const response = await paketService.updatePaket(this.editPaketData.id, formData);
                this.dtpaket.map(paket => {
                    if (paket.id == response.data.id) {
                        for (let key in response.data) {
                            paket[key] = response.data[key];
                        }
                    }
                });
                this.hideEditPaketModal();
                this.flashMessage.success({
                    message: "Paket update successfully!",
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
