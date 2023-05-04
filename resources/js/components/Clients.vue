<template>
    <!--  -->
    <div>
        <div class="card mb-3">
            <div class="card-body">
                <!-- Add Client button to trigger the modal -->
                <button class="btn btn-primary" @click="openModal">
                    Add Client
                </button>
            </div>
        </div>
        <!--  -->
        <div class="card">
            <div class="card-body">
                <div class="search-bar">
                    <input class="form-control" type="text" v-model="searchQuery" placeholder="Search by last name" />
                </div>
                <table v-if="filteredClients.length > 0" class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Date Profiled</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="client in filteredClients" :key="client.id">
                            <td>{{ client.id }}</td>
                            <td>
                                {{ client.first_name }} {{ client.last_name }}
                            </td>
                            <td>{{ client.email }}</td>
                            <td>{{ client.date_profiled }}</td>
                            <td>
                                <!--  -->
                                <button class="btn btn-primary" @click="viewClient(client)">
                                    View
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- add client Modal form -->
        <div v-if="showModal">
            <div class="modal-overlay">
                <div class="modal-container">
                    <h2>Add Client</h2>
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <!-- First name -->
                        <div>
                            <label for="first_name">First Name:</label>
                            <input class="form-control" type="text" id="first_name" v-model="form.first_name" required />
                        </div>
                        <!-- Last name -->
                        <div class="mb-3">
                            <label for="last_name">Last Name:</label>
                            <input class="form-control" type="text" id="last_name" v-model="form.last_name" required />
                        </div>
                        <!--  -->
                        <div class="mb-3">
                            <label for="email">Email:</label>
                            <input class="form-control" type="email" id="email" v-model="form.email" required />
                        </div>
                        <!--  -->
                        <div class="mb-3">
                            <label for="date_profiled">Date Profiled:</label>
                            <input class="form-control" type="date" id="date_profiled" v-model="form.date_profiled"
                                required />
                        </div>
                        <!--  -->
                        <div class="mb-3">
                            <label for="primary_legal_counsel">Primary Legal Counsel:</label>
                            <input class="form-control" type="text" id="primary_legal_counsel"
                                v-model="form.primary_legal_counsel" required />
                        </div>
                        <!--  -->
                        <div class="mb-3">
                            <label for="date_of_birth">Date of Birth:</label>
                            <input class="form-control" type="date" id="date_of_birth" v-model="form.date_of_birth"
                                required />
                        </div>
                        <!--  -->
                        <div class="mb-3">
                            <label for="profile_image">Profile Image:</label>
                            <input class="form-control" type="file" id="profile_image" v-on:change="handleFileUpload"
                                accept="image/*" />
                        </div>
                        <!--  -->
                        <div>
                            <label for="case_details">Case Details:</label>
                            <input class="form-control" type="text" id="case_details" v-model="form.case_details"
                                required />
                        </div>
                        <!--  -->
                        <div class="modal-footer">
                            <button type="button" @click="closeModal" class="btn btn-secondary" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- view -->
        <div v-if="showViewModal">
            <div class="modal-overlay">
                <div class="modal-container">
                    <h2>View Client</h2>
                    <div>
                        <strong>ID:</strong>
                        {{ selectedClient.id }}
                    </div>

                    <div>
                        <strong>First Name:</strong>
                        {{ selectedClient.first_name }}
                    </div>

                    <div>
                        <strong>Last Name:</strong>
                        {{ selectedClient.last_name }}
                    </div>

                    <div>
                        <strong>Email:</strong> {{ selectedClient.email }}
                    </div>

                    <div>
                        <strong>Date Profiled:</strong> {{ selectedClient.date_profiled }}
                    </div>

                    <div>
                        <strong>Primary Legal Counsel:</strong> {{ selectedClient.primary_legal_counsel }}
                    </div>

                    <div>
                        <strong>Date of Birth:</strong> {{ selectedClient.date_of_birth }}
                    </div>

                    <div>
                        <strong>Case details:</strong> {{ selectedClient.case_details }}
                    </div>

                    <div>
                        <strong>Profile Image:</strong>
                        <img v-if="selectedClient.profile_image" :src="'/img/' + selectedClient.profile_image"
                            alt="Profile Image" width="100" height="100">
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="closeViewModal" class="btn btn-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Swal from "sweetalert2";

export default {
    props: ["clients"],
    data() {
        return {
            loading: false,
            showModal: false,
            showViewModal: false,
            selectedClient: null,
            showEditModal: false,
            editingClient: null,
            originalClient: null,
            form: {
                first_name: "",
                last_name: "",
                email: "",
                date_profiled: "",
                primary_legal_counsel: "",
                date_of_birth: "",
                profile_image: null, // Change the initial value to null
                case_details: "",
            },
            searchQuery: "",
        };
    },
    methods: {
        openModal() {
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
        viewClient(client) {
            this.selectedClient = client;
            this.showViewModal = true;
        },
        closeViewModal() {
            this.showViewModal = false;
            this.selectedClient = null;
        },
        handleFileUpload(event) {
            this.form.profile_image = event.target.files[0];
        },
        submitForm() {
            const formData = new FormData();
            formData.append("first_name", this.form.first_name);
            formData.append("last_name", this.form.last_name);
            formData.append("email", this.form.email);
            formData.append("date_profiled", this.form.date_profiled);
            formData.append("primary_legal_counsel", this.form.primary_legal_counsel);
            formData.append("date_of_birth", this.form.date_of_birth);
            formData.append("profile_image", this.form.profile_image); // Append the file to the FormData
            formData.append("case_details", this.form.case_details);

            axios
                .post("/", formData)
                .then(() => {
                    this.showModal = false;
                    this.fetchClients();
                    this.resetForm();
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: "Client added successfully!",
                    }).then(() => {
                        this.$router.push("/"); // Redirect to the client page
                    });
                })
                .catch((error) => {
                    if (error.response.status === 422) {
                        console.log(error.response.data.errors);
                    } else {
                        console.error(error);
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "Failed to add client.",
                        });
                    }
                    // console.error(error);
                });
        },
        resetForm() {
            this.form.first_name = "";
            this.form.last_name = "";
            this.form.email = "";
            this.form.date_profiled = "";
            this.form.primary_legal_counsel = "";
            this.form.date_of_birth = "";
            this.form.profile_image = "";
            this.form.case_details = "";
        },
        fetchClients() {
            // Fetch clients list code here
        },
    },
    computed: {
        filteredClients() {
            return this.clients.filter((client) =>
                client.last_name
                    .toLowerCase()
                    .includes(this.searchQuery.toLowerCase())
            );
        },
    },
};
</script>

<style lang="scss" scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-container {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
}

/* Add any additional CSS styles for the modal */
</style>
<style></style>
