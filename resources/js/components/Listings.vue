<template>
  <div>
    <h1>Listing</h1>
    <button
      type="button"
      class="btn btn-primary"
      data-toggle="modal"
      data-target="#addEditModal"
    >
      Add New Listing
    </button>

    <!-- Modal -->
    <div
      class="modal fade"
      id="addEditModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="addEditModalLabel"
      aria-hidden="true"
    >
      <div
        class="modal-dialog"
        role="document"
      >
        <div class="modal-content">
          <div class="modal-header">
            <h5
              v-if="edit"
              class="modal-title"
              id="addEditModalLabel"
            >
              Update
            </h5>
            <h5
              v-else
              class="modal-title"
              id="addEditModalLabel"
            >
              Add
            </h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="title">Title</label>
              <input
                type="text"
                :class="['form-control', errors.title ? 'is-invalid' : '']"
                v-model="list.title"
                id="title"
                placeholder="Enter title"
              >
              <span
                class="bg-danger text-white p-1 rounded"
                v-if="errors.title"
              >{{ errors.title[0] }}</span>
            </div>
            <div class="form-group">
              <label for="price">Price</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    $
                  </div>
                </div>
                <input
                  type="number"
                  v-model="list.price"
                  :class="['form-control', errors.price ? 'is-invalid' : '']"
                  id="price"
                  placeholder="Enter price"
                >
              </div>
              <span
                class="bg-danger text-white p-1 rounded"
                v-if="errors.price"
              >{{ errors.price[0] }}</span>
            </div>
            <div class="form-group">
              <label for="title">Area</label>
              <input
                type="text"
                v-model="list.area"
                class="form-control"
                id="area"
                placeholder="Enter area"
              >
            </div>
            <div class="form-group">
              <label for="title">Address</label>
              <textarea
                class="form-control"
                id="address"
                v-model="list.address"
                placeholder="Enter full address"
              />
            </div>
            <div class="form-group">
              <label for="title">Name</label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="list.name"
                placeholder="Enter name"
              >
            </div>
            <div class="form-group">
              <label for="email">Email Address</label>
              <input
                type="email"
                :class="['form-control', errors.email ? 'is-invalid' : '']"
                id="email"
                v-model="list.email"
                placeholder="Enter email"
              >
              <span
                class="bg-danger text-white p-1 rounded"
                v-if="errors.email"
              >{{ errors.email[0] }}</span>
            </div>
            <div class="form-group">
              <label for="phoneNumber">Phone Number</label>

              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">
                    +46
                  </div>
                </div>
                <input
                  type="text"
                  class="form-control"
                  v-model="list.phoneNumber"
                  id="phoneNumber"
                  placeholder="Enter phone"
                >
              </div>
            </div>
            <button
              v-if="edit"
              type="submit"
              @click="updateListing()"
              class="btn btn-primary"
            >
              Update
            </button>
            <button
              v-else
              type="submit"
              @click="createListing"
              class="btn btn-primary"
            >
              Add
            </button>
          </div>
        </div>
      </div>
    </div>

    <div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">
              Title
            </th>
            <th scope="col">
              Price
            </th>
            <th scope="col">
              Area
            </th>
            <th scope="col">
              Address
            </th>
            <th scope="col">
              Email
            </th>
            <th scope="col">
              Name
            </th>
            <th scope="col">
              phoneNumber
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="l in listings"
            :key="l.id"
          >
            <td>{{ l.title }}</td>
            <td>{{ l.price }}</td>
            <td>{{ l.area }}</td>
            <td>{{ l.address }}</td>
            <td>{{ l.email }}</td>
            <td>{{ l.name }}</td>
            <td>{{ l.phoneNumber }}</td>
            <td>
              <button
                type="button"
                class="btn btn-primary"
                data-toggle="modal"
                data-target="#addEditModal"
                @click="editListing(l)"
              >
                Edit
              </button>
              <button
                type="button"
                class="btn btn-danger"
                @click="deleteListing(l)"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template> 
<script>
	export default {
		data() {
			return {
				list: {
					id: "",
					title: "",
					price: "",
					area: "",
					address: "",
					name: "",
					email: "",
					phoneNumber: "",
				},
				listings: {},
				edit: false,
				errors: [],
			};
		},
		methods: {
			async createListing() {
				try {
					var response = await axios.post("listAPI", this.list);
					this.listings = response.data.data;
					Toast.fire({
						icon: "success",
						title: "Inserted Successfully",
					});
					$("#addEditModal").modal("hide");
				} catch (err) {
					this.errors = response.data.errors;
				}
			},
			async getListing() {
				try {
					var response = await axios.get("listAPI");
					this.listings = response.data.data;
				} catch (err) {
					this.errors = response.data.errors;
				}
			},
			editListing(list) {
				this.list = list;
				this.edit = true;
			},
			async updateListing() {
				try {
					var response = await axios.put("listAPI/" + this.list._key, this.list);
					this.listings = response.data.data;
					Toast.fire({
						icon: "success",
						title: "Updated Successfully",
					});
					$("#addEditModal").modal("hide");
				} catch (err) {
					this.errors = response.data.errors;
				}
			},
			async deleteListing(list) {
				try {
					await axios.delete("listAPI/" + list._key);
					this.getListing();
					Toast.fire({
						icon: "success",
						title: "Deleted Successfully",
					});
					$("#addEditModal").modal("hide");
				} catch (err) {
					this.errors = err;
				}
			},
		},
		created() {
			this.getListing();
		},
	};
</script>