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
                        <label for="from">From</label>
                        <b-form-datepicker id="from" v-model="form.from" class="mb-2"></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.from">
                            {{ validationErrors.from[0] }}
                        </span>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <label for="to">To</label>
                        <b-form-datepicker id="to" v-model="form.to" class="mb-2"></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.to">
                            {{ validationErrors.to[0] }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group>
                        <label for="total_budget">Total Budget</label>
                        <b-form-input
                            type="number"
                            step="0.01"
                            id="total_budget"
                            v-model="form.total_budget"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.total_budget">
                            {{ validationErrors.total_budget[0] }}
                        </span>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <label for="daily_budget">Daily Budget</label>
                        <b-form-input
                            type="number"
                            step="0.01"
                            id="daily_budget"
                            v-model="form.daily_budget"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.daily_budget">
                            {{ validationErrors.daily_budget[0] }}
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
                from: '',
                to: '',
                total_budget: '',
                daily_budget: '',
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
            if(this.form.from != '') {
                formData.append('from',this.form.from)
            }
            if(this.form.to != '') {
                formData.append('to', this.form.to)
            }
            if(this.form.total_budget != '') {
                formData.append('total_budget', this.form.total_budget)
            }
            if(this.form.daily_budget != '') {
                formData.append('daily_budget', this.form.daily_budget)
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
