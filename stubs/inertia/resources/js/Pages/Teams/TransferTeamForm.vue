<template>
    <jet-form-section @submitted="transferTeam">
        <template #title>
            Transfer Team
        </template>

        <template #description>
            Transfer team ownership to another team member.
        </template>

        <template #form>
            <!-- New Team Owner -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="user_id" value="New Team Owner" />

                <div>
                    <select id="user_id" v-model="form.user_id" :disabled="! permissions.canTransferTeam" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                        <option v-for="teamUser in team.users" :key="teamUser.id" :value="teamUser.id">{{ teamUser.name }} ({{ teamUser.email }})</option>
                    </select>
                </div>

                <jet-input-error :message="form.error('user_id')" class="mt-2" />
            </div>
        </template>

        <template #actions v-if="permissions.canTransferTeam">
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Transferred.
            </jet-action-message>

            <jet-danger-button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Transfer
            </jet-danger-button>
        </template>
    </jet-form-section>
</template>

<script>
import JetActionMessage from '@/Jetstream/ActionMessage'
import JetDangerButton from '@/Jetstream/DangerButton'
import JetFormSection from '@/Jetstream/FormSection'
import JetInput from '@/Jetstream/Input'
import JetInputError from '@/Jetstream/InputError'
import JetLabel from '@/Jetstream/Label'

export default {
    components: {
        JetActionMessage,
        JetDangerButton,
        JetFormSection,
        JetInput,
        JetInputError,
        JetLabel,
    },

    props: ['team', 'permissions'],

    data() {
        return {
            form: this.$inertia.form({
                user_id: '',
            }, {
                bag: 'transferTeam',
                resetOnSuccess: false,
            })
        }
    },

    methods: {
        transferTeam() {
            this.form.post(route('teams.transfer', this.team), {
                preserveScroll: true
            });
        },
    },
}
</script>
