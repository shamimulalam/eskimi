<template>
    <div>
        <h1>Create new campaign</h1>
        <b-form @submit="onSubmit">
            <b-row>
                <b-col>
                    <b-form-group
                        id="name"
                        label="Name :"
                        label-for="name"
                    >
                        <b-form-input
                            id="name"
                            v-model="form.name"
                            type="text"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.name">
                            {{ validationErrors.name[0] }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>

            <b-row>
                <b-col>
                    <b-form-group>
                        <label for="fromDate">From</label>
                        <b-form-datepicker id="fromDate" v-model="form.fromDate" class="mb-2"></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.fromDate">
                            {{ validationErrors.fromDate[0] }}
                        </span>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <label for="toDate">To</label>
                        <b-form-datepicker id="toDate" v-model="form.toDate" class="mb-2"></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.toDate">
                            {{ validationErrors.toDate[0] }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group>
                        <label for="totalBudget">Total Budget</label>
                        <b-form-input
                            type="number"
                            step="0.01"
                            id="totalBudget"
                            v-model="form.totalBudget"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.totalBudget">
                            {{ validationErrors.totalBudget[0] }}
                        </span>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <label for="dailyBudget">Daily Budget</label>
                        <b-form-input
                            type="number"
                            step="0.01"
                            id="dailyBudget"
                            v-model="form.dailyBudget"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.dailyBudget">
                            {{ validationErrors.dailyBudget[0] }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group>
                        <label for="creatives">Creatives</label>
                        <b-form-file
                            id="creatives"
                            v-model="form.creatives"
                            placeholder="Choose files or drop it here..."
                            drop-placeholder="Drop file here..."
                            multiple
                            ref="creatives"
                            @change="grabFile"
                        ></b-form-file>
                        <span class="text-danger" v-if="validationErrors.creatives">
                            {{ validationErrors.creatives[0] }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <br>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button @click="$router.push({name:'campaign.list'})" variant="info">Back</b-button>

        </b-form>
    </div>
</template>

<script>
export default {
    name: "create",
    data() {
        return {
            form: {
                name: '',
                fromDate: '',
                toDate: '',
                totalBudget: '',
                dailyBudget: '',
            },
            files: [],
            validationErrors : {}
        }
    },
    methods: {
        async onSubmit(event) {
            event.preventDefault()
            var formData = new FormData();
            for(let i=0;i<this.files.length;i++) {
                formData.append('creatives[]', this.files[i])
            }
            if(this.form.name != '') {
                formData.append('name',this.form.name)
            }
            if(this.form.fromDate != '') {
                formData.append('fromDate',this.form.fromDate)
            }
            if(this.form.toDate != '') {
                formData.append('toDate', this.form.toDate)
            }
            if(this.form.totalBudget != '') {
                formData.append('totalBudget', this.form.totalBudget)
            }
            if(this.form.dailyBudget != '') {
                formData.append('dailyBudget', this.form.dailyBudget)
            }
            const response = await this.callApi(
                'post',
                '/api/campaign/store',
                formData
                );
            switch (response.status){
                case 201:
                    this.form = {}
                    this.setFlashMessage(
                        'success',
                        'Campaign',
                        'Created successfully'
                    )
                    this.$router.push({name: "campaign.list"})
                    break
                case 422:
                    this.validationErrors = response.data.errors
                    break
                default:
                    this.setFlashMessage(
                        'error',
                        'Campaign Create',
                        response.data
                    )
                    this.showFlashMessage()
            }
        },
        grabFile(event) {
            let files = event.target.files;
            for(var i=0;i<files.length;i++){
                this.files.push(files[i])
            }
        }
    }
}
</script>

<style scoped>

</style>
