<template>
    <div>
        <h1>Campaigns</h1>
        <router-link :to="{name : 'campaign.create'}">Create New Campaign</router-link>
        <b-row v-if="campaigns.length">
            <b-col md="3">
                <b-form-input
                    v-model="filter"
                    type="search"
                    id="filterInput"
                    placeholder="Type to Search"
                ></b-form-input>
            </b-col>
        </b-row>
        <b-row v-if="campaigns.length">
            <b-col>
                <b-table
                    striped
                    hover
                    outlined
                    :items="campaigns"
                    :filter="filter"
                    :per-page="perPage"
                    :current-page="currentPage"
                    :fields="fields"
                >

                    <template v-slot:cell(actions)="data">
                        <b-button
                            @click="$router.push({name: 'campaign.edit',params: {id: data.item.id}})"
                            variant="info"
                        >Edit</b-button>
                    </template>
                </b-table>
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="my-table"
                ></b-pagination>
            </b-col>
        </b-row>
        <b-row v-else>
            <b-col>No campaign found</b-col>
        </b-row>
    </div>
</template>

<script>
export default {
    name: "list",
    data() {
        return {
            campaigns : {},
            fields : ["name",'from','to','daily_budget','total_budget','created_at','actions'],
            filter : '',
            perPage : 10,
            currentPage : 1,
        };
    },
    async created(){
        this.getCampaignList()
        this.showFlashMessage()
    },
    methods: {
        async getCampaignList(){
            const response = await this.callApi(
                'get',
                '/campaign/index'
            );
            if(response.status == 200){
                this.campaigns = response.data
            }
        },

    },
    computed: {
        rows() {
            return this.campaigns.length;
        }
    },
}
</script>

<style scoped>

</style>
