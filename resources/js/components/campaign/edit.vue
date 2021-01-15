<template>
    <div>
        <h1>Edit campaign</h1>
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
                            v-model="campaign.name"
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
                        <b-form-datepicker id="fromDate" v-model="campaign.from" class="mb-2"></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.from">
                            {{ validationErrors.from[0] }}
                        </span>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group>
                        <label for="toDate">To</label>
                        <b-form-datepicker id="toDate" v-model="campaign.to" class="mb-2"></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.to">
                            {{ validationErrors.to[0] }}
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
                            v-model="campaign.total_budget"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.total_budget">
                            {{ validationErrors.total_budget[0] }}
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
                            v-model="campaign.daily_budget"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.daily_budget">
                            {{ validationErrors.daily_budget[0] }}
                        </span>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-button type="submit" variant="primary">Update</b-button>
            <b-button @click="$router.push({name:'campaign.list'})" variant="info">Back</b-button>

        </b-form>
    </div>
</template>

<script>
export default {
    name: "edit",
    data() {
        return {
            campaignId : '',
            campaign : {},
            files: [],
            validationErrors : {}
        }
    },
    created() {
        this.campaignId = this.$route.params.id
        this.getCampaign()
    },
    methods: {
        async getCampaign(){
            const response = await this.callApi(
                'get',
                '/api/campaign/'+this.campaignId
            );
            if(response.status == 200){
                this.campaign = response.data
            }
        },
        async onSubmit(event) {
            event.preventDefault()
            const response = await this.callApi(
                'put',
                '/api/campaign/'+this.campaignId,
                this.campaign
            );
            switch (response.status){
                case 201:
                    this.form = {}
                    this.setFlashMessage(
                        'success',
                        'Campaign',
                        'Updated successfully'
                    )
                    this.$router.push({name: "campaign.list"})
                    break
                case 422:
                    this.validationErrors = response.data.errors
                    break
                default:
                    this.setFlashMessage(
                        'error',
                        'Campaign Edit',
                        response.data
                    )
                    this.showFlashMessage()
            }
        }
    }
}
</script>

<style scoped>

</style>
